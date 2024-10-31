<?php
/**
 * Main file to handle requests and reponses.
 *
 * @package Portfolio Designer Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/* Shortcode Page */
require_once PORT_LITE_PLUGIN_DIR . 'includes/shortcode.php';

if ( ! function_exists( 'pdl_paging_nav' ) ) {
	/**
	 * Pagination.
	 *
	 * @param int $mid_size Mid Size.
	 */
	function pdl_paging_nav( $mid_size = 1 ) {
		// Don't print empty markup if there's only one page.

		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
		$format       = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format      .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		if ( is_rtl() ) {
			$prev_arrow  = '<span class="next-prev-arrow"><i class="dashicons dashicons-arrow-right-alt2"></i></span>';
			$next_arrrow = '<span class="next-prev-arrow"><i class="dashicons dashicons-arrow-left-alt2"></i></span>';
		} else {
			$prev_arrow  = '<span class="next-prev-arrow"><i class="dashicons dashicons-arrow-left-alt2"></i></span>';
			$next_arrrow = '<span class="next-prev-arrow"><i class="dashicons dashicons-arrow-right-alt2"></i></span>';
		}

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $GLOBALS['wp_query']->max_num_pages,
				'current'   => $paged,
				'mid_size'  => $mid_size,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => $prev_arrow,
				'next_text' => $next_arrrow,
			)
		);

		if ( $links ) :
			?>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'portfolio-designer-lite' ); ?></h1>
				<div class="pagination loop-pagination">
					<?php echo wp_kses( $links, PortfolioDesignerLite::args_kses() ); ?>
				</div><!-- .pagination -->
			</nav><!-- .navigation -->
			<?php
		endif;
	}
}

if ( ! function_exists( 'pdl_get_social_icons' ) ) {
	/**
	 *  Add social share icons in portfolio layout shortcode.
	 *
	 * @param string $data_setting Data Settings.
	 * @param string $current_page_id Current Page ID.
	 * @param string $position Position.
	 */
	function pdl_get_social_icons( $data_setting, $current_page_id, $position = 0 ) {

		if ( ! isset( $data_setting['portfolio_enable_social_share_settings'] ) ) {
			return;
		}

		if ( isset( $data_setting['portfolio_enable_social_share_settings'] ) && 1 != $data_setting['portfolio_enable_social_share_settings'] ) {
			return;
		}

		if ( isset( $data_setting['portfolio_social_icon_display_position'] ) && $position != $data_setting['portfolio_social_icon_display_position'] ) {
			return;
		}

		if ( ( 1 == $data_setting['portfolio_facebook_link'] ) || ( 1 == $data_setting['portfolio_twitter_link'] ) || ( 1 == $data_setting['portfolio_linkedin_link'] ) || ( 1 == $data_setting['portfolio_pinterest_link'] ) ) {
			?>
			<div class="social-component 
			<?php
			echo esc_html( sanitize_title( get_the_title() ) );
			if ( isset( $data_setting['portfolio_social_style'] ) && 0 == $data_setting['portfolio_social_style'] ) {
				if ( isset( $data_setting['portfolio_social_icon_size'] ) && 0 == $data_setting['portfolio_social_icon_size'] ) {
					echo ' large ';
				}
				if ( isset( $data_setting['portfolio_social_icon_style'] ) && 0 == $data_setting['portfolio_social_icon_style'] ) {
					echo ' circle ';
				}
			}

			if ( 1 == $data_setting['portfolio_social_style'] ) {
				echo ' default-icon ';
			}

			if ( isset( $data_setting['portfolio_social_icon_alignment'] ) ) {
				echo esc_attr( ' align-' . $data_setting['portfolio_social_icon_alignment'] . ' ' );
			}

			if ( isset( $data_setting['portfolio_social_icon_display_position'] ) && 1 == $data_setting['portfolio_social_icon_display_position'] ) {
				echo ' after ';
			} else {
				echo ' before ';
			}
			?>
			">
				<?php if ( 1 == $data_setting['portfolio_facebook_link'] ) { ?>
					<div class="social-share">
						<a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . esc_url( get_the_permalink( $current_page_id ) ); ?>" target="_blank" class="pdl-facebook-share facebook-share social-icon">
							<i class="fab fa-facebook-f"></i>
						</a>
					</div>
				<?php } ?>

				<?php if ( 1 == $data_setting['portfolio_linkedin_link'] ) { ?>
					<div class="social-share">
						<a href="<?php echo 'https://www.linkedin.com/shareArticle?url=' . esc_url( get_the_permalink( $current_page_id ) ); ?>" target="_blank" class="linkedin-share social-icon">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div>
				<?php } ?>

				<?php if ( 1 == $data_setting['portfolio_pinterest_link'] ) { ?>
					<div class="social-share">
						<a href="<?php echo '//pinterest.com/pin/create/button/?url=' . esc_url( get_the_permalink( $current_page_id ) ) . '&description=' . esc_attr( get_the_title() ); ?>" target="_blank" class="pinterest-share social-icon">
							<i class="fab fa-pinterest"></i>
						</a>
					</div>
				<?php } ?>

				<?php if ( 1 == $data_setting['portfolio_twitter_link'] ) { ?>
					<div class="social-share">
						<a href="<?php echo 'https://twitter.com/share?text=' . esc_attr( get_the_title() ) . '&url=' . esc_url( get_the_permalink( $current_page_id ) ); ?>" target="_blank" class="twitter-share social-icon">
							<i class="fab fa-x-twitter"></i>
						</a>
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<?php
		}
	}
}



if ( ! function_exists( 'pdl_get_the_thumbnail' ) ) {
	/**
	 *  Add social share icons in portfolio layout shortcode.
	 *
	 * @param string $portfolio_settings Portfolio Settings.
	 * @param string $post_thumbnail Post Thumbnail.
	 * @param int    $post_thumbnail_id Post Thumbnail ID.
	 * @param int    $portfolio_post_id Portfolio Post ID.
	 */
	function pdl_get_the_thumbnail( $portfolio_settings, $post_thumbnail, $post_thumbnail_id, $portfolio_post_id ) {
		$thumbnail = '';
		if ( '' == $post_thumbnail ) {
			$post_thumbnail = 'full';
		}

		if ( has_post_thumbnail() ) {
			if ( isset( $portfolio_settings['thumb_size'] ) ) {
				$post_thumbnail = $portfolio_settings['thumb_size'];
				$thumbnail      = get_the_post_thumbnail( $portfolio_post_id, $post_thumbnail );
			} else {
				$thumbnail = get_the_post_thumbnail( $portfolio_post_id, $post_thumbnail );
			}
		} elseif ( isset( $portfolio_settings['default_image_id'] ) && '' != $portfolio_settings['default_image_id'] ) {
			if ( isset( $portfolio_settings['thumb_size'] ) ) {
				$post_thumbnail = $portfolio_settings['thumb_size'];
				$thumbnail      = wp_get_attachment_image( $portfolio_settings['default_image_id'], $post_thumbnail );
			} else {
				$thumbnail = get_the_post_thumbnail( $portfolio_settings['default_image_id'], $post_thumbnail );
			}
			if ( empty( $thumbnail ) ) {
				$thumbnail = '<img src="' . PORT_LITE_PLUGIN_URL . 'images/no_image.jpg" alt="' . esc_attr( get_the_title() ) . '" />';
			}
		} else {
			$thumbnail = '<img src="' . PORT_LITE_PLUGIN_URL . 'images/no_image.jpg" alt="' . esc_attr( get_the_title() ) . '" />';
		}
		return $thumbnail;
	}
}

if ( ! function_exists( 'pdl_image_resize' ) ) {
	/**
	 * Resize Images.
	 *
	 * @param string $width Width of image.
	 * @param string $height Height of image.
	 * @param string $img_url Image URL.
	 * @param bool   $crop Cropped Image.
	 */
	function pdl_image_resize( $width, $height, $img_url = null, $crop = false ) {
		// this is an attachment, so we have the ID.
		$file_path = '';
		if ( $img_url ) {
			$file_path     = wp_parse_url( $img_url );
			$document_root = isset( $_SERVER['DOCUMENT_ROOT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['DOCUMENT_ROOT'] ) ) : '';
			$file_path     = $document_root . $file_path['path'];
			// Look for Multisite Path.
			if ( is_multisite() ) {
				$img_info    = pathinfo( $img_url );
				$uploads_dir = wp_upload_dir();
				$file_path   = $uploads_dir['path'] . '/' . $img_info['basename'];
			}
			if ( ! file_exists( $file_path ) ) {
				return;
			}
			$orig_size    = getimagesize( $file_path );
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
		$file_info = pathinfo( $file_path );
		// check if file exists.
		$base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];

		if ( ! file_exists( $base_file ) ) {
			return;
		}
		$extension = '.' . $file_info['extension'];
		// the image path without the extension.
		$no_ext_path      = $file_info['dirname'] . '/' . $file_info['filename'];
		$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;
		// checking if the file size is larger than the target size.
		// if it is smaller or the same size, stop right here and return.
		if ( $image_src[1] > $width ) {
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match).
			if ( file_exists( $cropped_img_path ) ) {
				$cropped_img_url  = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
				$portfolio_images = array(
					'url'    => $cropped_img_url,
					'width'  => $width,
					'height' => $height,
				);
				return $portfolio_images;
			}
			// $crop = false or no height set.
			if ( false == $crop || ! $height ) {
				// calculate the size proportionaly.
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path  = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;
				// checking if the file already exists.
				if ( file_exists( $resized_img_path ) ) {
					$resized_img_url  = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
					$portfolio_images = array(
						'url'    => $resized_img_url,
						'width'  => $proportional_size[0],
						'height' => $proportional_size[1],
					);
					return $portfolio_images;
				}
			}
			// check if image width is smaller than set width.
			$img_size = getimagesize( $file_path );
			if ( $img_size[0] <= $width ) {
				$width = $img_size[0];
			}
			// Check if GD Library installed.
			if ( ! function_exists( 'imagecreatetruecolor' ) ) {
				esc_html_e( 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library', 'portfolio-designer-lite' );
				return;
			}
			// no cache files - let's finally resize it.
			$image = wp_get_image_editor( $file_path );

			if ( ! is_wp_error( $image ) ) {
				$new_file_name = $file_info['filename'] . '-' . $width . 'x' . $height . '.' . $file_info['extension'];
				$image->resize( $width, $height, $crop );
				$image->save( $file_info['dirname'] . '/' . $new_file_name );
			}
			$new_img_path = $file_info['dirname'] . '/' . $new_file_name;
			$new_img_size = getimagesize( $new_img_path );
			$new_img      = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
			// resized output.
			$portfolio_images = array(
				'url'    => $new_img,
				'width'  => $new_img_size[0],
				'height' => $new_img_size[1],
			);
			return $portfolio_images;
		}
		// default output - without resizing.
		$portfolio_images = array(
			'url'    => $image_src[0],
			'width'  => $width,
			'height' => $height,
		);
		return $portfolio_images;
	}
}
add_action( 'wp_ajax_nopriv_get_content_position', 'pdl_get_content_position' );
add_action( 'wp_ajax_get_content_position', 'pdl_get_content_position' );
/**
 * Get Content Position.
 */
function pdl_get_content_position() {
	ob_start();
	if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
		$portfolio_overlay = ( isset( $_POST['overlay'] ) && '' != $_POST['overlay'] ) ? sanitize_text_field( wp_unslash( $_POST['overlay'] ) ) : 'enable';
		?>
		<td>
			<label for="portfolio_content_position"><?php esc_html_e( 'Select Content Position', 'portfolio-designer-lite' ); ?></label>
		</td>
		<td>
			<?php $portfolio_content_position = ( isset( $portfolio_setting['content_position'] ) && '' != $portfolio_setting['content_position'] ) ? $portfolio_setting['content_position'] : 'overlay_image'; ?>
			<div class="select-cover">
				<select id="portfolio_content_position" name="portfolio_content_position">
					<?php if ( 'enable' == $portfolio_overlay ) { ?>
						<option value="overlay_image" <?php echo ( 'overlay_image' == $portfolio_content_position ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Overlay on Image', 'portfolio-designer-lite' ); ?></option>
						<?php
					}
					?>
					<option value="bottom_image" ><?php esc_html_e( 'Bottom of Image', 'portfolio-designer-lite' ); ?></option>
					<option value="left_side" ><?php esc_html_e( 'Left side of Image', 'portfolio-designer-lite' ); ?></option>
					<option value="right_side" ><?php esc_html_e( 'Right side of Image', 'portfolio-designer-lite' ); ?></option>
				</select>
			</div>
		</td>
		<?php
	}
	$data = ob_get_clean();
	echo wp_kses( $data, PortfolioDesignerLite::args_kses() );
	die();
}
