<?php
/**
 * Portfolio Settings File.
 *
 * @package Portfolio Designer Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add or Edit portfolio layout admin view.
 */
global $wpdb;
$setting = maybe_unserialize( get_option( 'portfolio_designer_lite_settings' ) );

if ( ! empty( $setting ) ) {
	foreach ( $setting as $key => $value ) {
		$key                       = str_replace( 'portfolio_', '', $key );
		$portfolio_setting[ $key ] = $value;
	}
} else {
	$portfolio_setting = array();
}

$portfolio_edit = true;


$font_family = array( 'Default' );
?>

<div class="wrap pdl-admin">
	<div class="pdl-home">
		<div class="pdl-list">
			<div class="pdl-list-header">
				<h4><strong><?php esc_html_e( 'Portfolio Designer Lite Settings', 'portfolio-designer-lite' ); ?></strong></h4>
			</div>
		</div>
	</div>
	<?php
	$view_post_link = ( isset( $portfolio_setting['page_display'] ) && 0 != $portfolio_setting['page_display'] ) ? '<span class="page_link"> <a target="_blank" href="' . get_permalink( $portfolio_setting['page_display'] ) . '"> ' . __( 'View Portfolio', 'portfolio-designer-lite' ) . ' </a></span>' : '';
	if ( isset( $_GET['action'] ) && 'save' == sanitize_text_field( wp_unslash( $_GET['action'] ) ) ) {
		echo '<div id="notice-2" class="updated" ><p>' . esc_html__( 'Portfolio Designer Lite Settings Updated.', 'portfolio-designer-lite' ) . ' ' . wp_kses( $view_post_link, PortfolioDesignerLite::args_kses() ) . '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></p></div>';
	}
	?>
	<div class="preview-screen"></div>
	<form method="post" action="?page=portfolio_lite_settings&action=save" class="pdl-form-class" name="pdl_add_portfolio" id="pdl_add_portfolio">
		<?php
		wp_nonce_field( 'add-portfolio-layout-submit', 'add-portfolio-layout-submit-nonce' );
		$page_data = '';
		if ( isset( $_GET['page'] ) && '' != $_GET['page'] ) {
			$page_data = sanitize_text_field( wp_unslash( $_GET['page'] ) );
			?>
			<input type="hidden" name="portfoliooriginalpage" class="portfoliooriginalpage" value="<?php echo esc_attr( $page_data ); ?>" />
			<?php
		}
		?>
		<div class="portdesign-preview-box" id="portdesign-preview-box"></div>
		<div id="poststuff" class="pdl-settings-wrappers port_poststuff">
			<div class="pdl-header-wrapper">
				<div class="pdl-logo-wrapper pull-left">
					<img src="<?php echo esc_url( PORT_LITE_PLUGIN_URL ) . 'images/logo.png'; ?>">
				</div>
				<div class="pull-right">
					<a id="pdl-btn-show-preview" title="<?php esc_html_e( 'Show Preview', 'portfolio-designer-lite' ); ?>" class="button portfolio_show_preview pdl-button pdl-is-green pro-feature" href="#">
						<span><?php esc_html_e( 'Show Preview', 'portfolio-designer-lite' ); ?></span>
					</a>
					<a id="pdl-btn-show-submit" title="<?php esc_html_e( 'Save Changes', 'portfolio-designer-lite' ); ?>" class="show_portfolio_save button submit_fixed button button-primary"  href="#" >
						<span><?php esc_html_e( 'Save Changes', 'portfolio-designer-lite' ); ?></span>
					</a>
					<a id="pdl-btn-reset-submit" title="<?php esc_html_e( 'Reset Changes', 'portfolio-designer-lite' ); ?>" class="portfolio_reset_settings button submit_fixed button button-default"  href="#" >
						<span><?php esc_html_e( 'Reset Changes', 'portfolio-designer-lite' ); ?></span>
					</a>
				</div>
			</div>
			<div class="postbox-container">
				<div class="pdl-menu-setting">
					<ul class="port-setting-handle">
						<?php
						$current_tab = get_user_option( 'pdselectedtab_' . $page_data );
						$current_tab = esc_attr( $current_tab );
						if ( '' == $current_tab ) {
							$current_tab = 'portdesigngeneral';
						}
						?>
						<li class="portdesigngeneral
						<?php
						if ( 'portdesigngeneral' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesigngeneral">
							<i class="fas fa-cogs"></i>
							<span><?php esc_html_e( 'General Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="portdesignquery
						<?php
						if ( 'portdesignquery' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesignquery">
							<i class="fab fa-quora"></i>
							<span><?php esc_html_e( 'Query Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="portdesignlayout
						<?php
						if ( 'portdesignlayout' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesignlayout">
							<i class="fas fa-th-large"></i>
							<span><?php esc_html_e( 'Layout Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="portdesignthumbnail
						<?php
						if ( 'portdesignthumbnail' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesignthumbnail">
							<i class="fas fa-image"></i>
							<span><?php esc_html_e( 'Thumbnail Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="portdesignfilter
						<?php
						if ( 'portdesignfilter' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesignfilter">
							<i class="fas fa-filter"></i>
							<span><?php esc_html_e( 'Filter Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="portdesignpagination
						<?php
						if ( 'portdesignpagination' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesignpagination">
							<i class="fas fa-ellipsis-h"></i>
							<span><?php esc_html_e( 'Pagination Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="pdlsocial
						<?php
						if ( 'pdlsocial' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="pdlsocial">
							<i class="fas fa-share-alt"></i>
							<span><?php esc_html_e( 'Social Share Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
						<li class="portdesignstyle
						<?php
						if ( 'portdesignstyle' == $current_tab ) {
							echo ' port-active-tab';}
						?>
" data-show="portdesignstyle">
							<i class="fas fa-paint-brush"></i>
							<span><?php esc_html_e( 'Style Settings', 'portfolio-designer-lite' ); ?></span>
						</li>
					</ul>
				</div>
				<div id="portdesigngeneral" 
				<?php
				if ( 'portdesigngeneral' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table>
							<tbody>
								<tr>
									<td> <label for="portfolio_layout_post"><?php esc_html_e( 'Select Post Type for Portfolio', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										$args       = array(
											'public' => true,
										);
										$output     = 'objects';
										$operator   = 'and';
										$post_types = get_post_types( $args, $output, $operator );
										?>
										<div class="select-cover">
											<select name="portfolio_layout_post" id="portfolio_layout_post">
												<?php
												foreach ( $post_types as $post_type_data ) {
													if ( 'attachment' != $post_type_data->name ) {
														?>
														<option value="<?php echo esc_attr( $post_type_data->name ); ?>" <?php echo ( isset( $portfolio_setting['layout_post'] ) && $portfolio_setting['layout_post'] == $post_type_data->name ) ? 'selected="selected"' : ''; ?> ><?php echo esc_html( $post_type_data->labels->name ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<label for="portfolio_page_display"><?php esc_html_e( 'Display Portfolio on page', 'portfolio-designer-lite' ); ?></label>
									</td>
									<td>
										<div class="select-cover">
											<?php
											if ( ! isset( $portfolio_setting['page_display'] ) ) {
												$selected_template = '';
											} else {
												$selected_template = $portfolio_setting['page_display'];
											}
											echo wp_kses(
												wp_dropdown_pages(
													array(
														'name' => 'portfolio_page_display',
														'echo' => 0,
														'depth' => -1,
														'show_option_none' => '-- ' . __( 'Select Page', 'portfolio-designer-lite' ) . ' --',
														'option_none_value' => '0',
														'selected' => $selected_template,
													)
												),
												PortfolioDesignerLite::args_kses()
											);
											?>
										</div>
										<div>
											<p> <strong><?php esc_html_e( 'Note', 'portfolio-designer-lite' ); ?>: </strong> 
												<?php
													esc_html_e( 'You are about to select the page for your portfolio layout, you will lose your page content. There is no undo. Think about it!', 'portfolio-designer-lite' );
												?>
												</p>
										</div>
									</td>
								</tr>
								<tr class="pro-feature">
									<td>
										<label for="portfolio_layout_unique_class_name" class="porfolio-title">
											
											<?php esc_html_e( 'Class Name', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td class="pro-feature">
										<?php
										$layout_unique_class_name = ( isset( $portfolio_setting['layout_unique_class_name'] ) && '' != $portfolio_setting['layout_unique_class_name'] ) ? $portfolio_setting['layout_unique_class_name'] : '';
										?>
										<input type="text" name="portfolio_layout_unique_class_name" id=" portfolio_layout_unique_class_name" value="<?php echo esc_attr( $layout_unique_class_name ); ?>" placeholder="<?php esc_attr_e( 'Enter class name', 'portfolio-designer' ); ?>" readonly>
									</td>
								</tr>
								<tr>
								<td>
									<label for="portfolio_delete_plugins_data"><?php esc_html_e( 'Delete data on deletion of plugin', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<label class="desc_checkbox delete-data">
										<input id="portfolio_delete_plugins_data" name="portfolio_delete_plugins_data" type="checkbox" value="1" <?php echo ( isset( $portfolio_setting['delete_plugins_data'] ) && 1 == $portfolio_setting['delete_plugins_data'] ) ? 'checked="checked"' : ''; ?>/>
										<?php esc_html_e( 'Delete data on deletion of plugin', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
							</tr>
							</tbody>
						</table>
						<div class="pro-feature portfolio-taxonomay-wrapper1">
							<div class="section-seprator"></div>
							<h3 class="portfolio-headding port-typo-heading"><?php esc_html_e( 'Display Setting', 'portfolio-designer' ); ?></h3>
							<div class="portfolio-taxonomy-cover1">
								<div class="port-typo-label">
									<label for="portfolio_title_font_text_decoration" class="porfolio-title">
										<?php esc_html_e( 'Display Date', 'portfolio-designer' ); ?>
									</label>
								</div>
								<div class="port-typo-options">
									<div class="pro-feature port-custom-option">
									<?php
										$display_date = 0;
									if ( isset( $portfolio_setting['display_date'] ) && '' != $portfolio_setting['display_date'] ) {
										$display_date = $portfolio_setting['display_date'];
									}
									?>
										<fieldset class="portfolio-social-options portfolio_social_icon_style buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_display_date_0" name="portfolio_display_date" type="radio" value="1" <?php checked( 1, $display_date ); ?> />
											<label for="portfolio_display_date_0" <?php checked( 1, $display_date ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_display_date_1" name="portfolio_display_date" type="radio" value="0" <?php checked( 0, $display_date ); ?>/>
											<label for="portfolio_display_date_1" <?php checked( 0, $display_date ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>
									</div>
									<label class="display_date desc_checkbox">
										<input id="portfolio_disable_date_link" name="portfolio_disable_date_link" value="1" type="checkbox" <?php echo ( isset( $portfolio_setting['disable_date_link'] ) && 1 == $portfolio_setting['disable_date_link'] ) ? 'checked="checked"' : ''; ?>> Disable Date Link
									</label>
								</div>
							</div>
							<div class="portfolio-taxonomay-wrapper">
							<?php
							$display_custom_tax = isset( $portfolio_setting['display_category_tag'] ) ? $portfolio_setting['display_category_tag'] : array();
							$disable_link       = isset( $portfolio_setting['disable_link'] ) ? $portfolio_setting['disable_link'] : array();
							$custom_posttype    = ( isset( $portfolio_setting['layout_post'] ) && '' != isset( $portfolio_setting['layout_post'] ) ) ? $portfolio_setting['layout_post'] : 'post';
							if ( 'attachment' == $custom_posttype ) {
								$portfolio_layout_post = ( isset( $portfolio_setting['media_layout_post_type'] ) && '' != isset( $portfolio_setting['media_layout_post_type'] ) ) ? $portfolio_setting['media_layout_post_type'] : 'post';
							} else {
								$portfolio_layout_post = ( isset( $portfolio_setting['layout_post'] ) && '' != isset( $portfolio_setting['layout_post'] ) ) ? $portfolio_setting['layout_post'] : 'post';
							}
							$taxonomy_names = get_object_taxonomies( $portfolio_layout_post, 'objects' );

							$taxonomy_names = apply_filters( 'bdp_hide_taxonomies', $taxonomy_names );

							if ( ! empty( $taxonomy_names ) ) {

								foreach ( $taxonomy_names as $taxonomy_name ) {

									if ( ! empty( $taxonomy_name ) && 'product_visibility' != $taxonomy_name->name && 'product_type' != $taxonomy_name->name && 'product_shipping_class' != $taxonomy_name->name && 'post_format' != $taxonomy_name->name ) {
										$_name         = 'display_taxonomy_' . $taxonomy_name->name;
										$_disable_link = 'disable_link_' . $taxonomy_name->name;
										if ( empty( $display_custom_tax ) ) {
											$display_custom_taxonomy = 0;
										} else {
											$display_custom_taxonomy = $display_custom_tax[ $_name ];
										}
										if ( empty( $disable_link ) ) {
											$disable_custom_taxonomy = 0;
										} else {
											$disable_custom_taxonomy = $disable_link[ $_disable_link ];
										}
										?>
												<div class="portfolio-taxonomy-cover">
													<div class="port-typo-label">
														<label for="portfolio_title_font_text_decoration" class="porfolio-title">
															
															<?php echo esc_html( $taxonomy_name->label ); ?>
														</label>
													</div>
													<div class="port-typo-options">
														<div class="port-custom-option">
															<fieldset class="portfolio-social-options portfolio_social_icon_style buttonset buttonset-hide" data-hide='1'>
																<input id="<?php echo esc_attr( $_name ); ?>_0" name="<?php echo esc_attr( $_name ); ?>" type="radio" value="1" <?php checked( 1, $display_custom_taxonomy ); ?>  />
																<label for="<?php echo esc_attr( $_name ); ?>_0" ><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
																<input id="<?php echo esc_attr( $_name ); ?>_1" name="<?php echo esc_attr( $_name ); ?>" type="radio" value="0" <?php checked( 0, $display_custom_taxonomy ); ?> />
																<label for="<?php echo esc_attr( $_name ); ?>_1" <?php checked( 0, $display_custom_taxonomy ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
															</fieldset>
														</div>
														<label class="exclude_term desc_checkbox">
															<input id="<?php echo esc_attr( $_disable_link ); ?>" name="<?php echo esc_attr( $_disable_link ); ?>" value="1" type="checkbox" <?php echo ( 1 == $disable_custom_taxonomy ) ? 'checked="checked"' : ''; ?>> Disable <?php echo esc_html( $taxonomy_name->label ); ?> Link</label>
														</label>
													</div>
												</div>
												<?php
									}
								}
							}
							?>
							</div>
						</div>
					</div>
				</div>
				<div id="portdesignquery" 
				<?php
				if ( 'portdesignquery' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table>
							<?php
							$portfolio_layout_post = ( isset( $portfolio_setting['layout_post'] ) && isset( $portfolio_setting['layout_post'] ) != '' ) ? esc_attr( $portfolio_setting['layout_post'] ) : 'sol_portfolio';
							$portfolio_taxonomy    = get_object_taxonomies( $portfolio_layout_post, 'objects' );
							?>
							<tr class="portfolio_taxonomy_tr">
								<?php
								if ( ! empty( $portfolio_taxonomy ) ) {
									?>
									<td>
										<label for="portfolio_taxonomy"><?php esc_html_e( 'Select Taxonomy Type to Filter Posts', 'portfolio-designer-lite' ); ?></label>
									</td>
									<td>
										<div class="select-cover">
											<select id="portfolio_taxonomy" name="portfolio_taxonomy">
												<?php
												foreach ( $portfolio_taxonomy as $slug => $name ) {
													if ( 'post_format' != $slug ) {
														?>
														<option value="<?php echo esc_attr( $slug ); ?>" <?php echo ( isset( $portfolio_setting['taxonomy'] ) && $portfolio_setting['taxonomy'] == $slug ) ? 'selected="selected"' : ''; ?>><?php echo esc_html( $name->labels->name ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</td>
									<?php
								}
								?>
							</tr>
							<?php
							$portfolio_taxonomy = ( isset( $portfolio_setting['taxonomy'] ) && '' != $portfolio_setting['taxonomy'] ) ? esc_attr( $portfolio_setting['taxonomy'] ) : 'portfolio-category';
							$terms              = get_terms( $portfolio_taxonomy, array( 'hide_empty' => false ) );
							if ( ! isset( $portfolio_setting['taxonomy'] ) ) {
								$portfolio_setting['taxonomy'] = '';
							}
							?>
							<tr class="portfolio_categories_tr">
								<?php
								if ( ! empty( $terms ) ) {
									?>
									<td>
										<label for="portfolio_categories"><?php esc_html_e( 'Select Terms to Filter Posts', 'portfolio-designer-lite' ); ?></label>
									</td>

									<td>
										<div class="select-cover">
											<select id="portfolio_categories" name="portfolio_categories[]" class="chosen-select" multiple="multiple" data-placeholder="Choose Terms" style="width:100%;">
												<?php
												foreach ( $terms as $value ) {
													?>
													<option value="<?php echo esc_attr( $value->slug ); ?>" <?php echo ( ! empty( $portfolio_setting['categories'] ) && in_array( $value->slug, $portfolio_setting['categories'] ) ) ? 'selected="selected"' : ''; ?> ><?php echo esc_html( $value->name ); ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</td>
									<?php
								}
								?>
							</tr>
							<tr class="advance_filter_option">
								<td class='pro-feature'>
									<label for="portfolio_number_post" class="porfolio-title">
										
										<?php esc_html_e( 'Terms filter with', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td class='pro-feature'>
									<fieldset class="portfolio-social-options portfolio_social_icon_style buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_filter_with_0" name="portfolio_filter_with" type="radio" value="1" checked />
										<label for="portfolio_filter_with_0" checked ><?php esc_html_e( 'OR', 'portfolio-designer-lite' ); ?></label>
										<input id="portfolio_filter_with_1" name="portfolio_filter_with" type="radio" value="0" />
										<label for="portfolio_filter_with_1" ><?php esc_html_e( 'AND', 'portfolio-designer-lite' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_post"> <?php esc_html_e( 'Select Posts', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td class="portfolio_post_td">
									<div class="select-cover">
										<select id="portfolio_post" name="portfolio_post[]" class="chosen-select" multiple="multiple" data-placeholder="Choose Posts" style="width:100%;">
											<?php
											$args = array(
												'post_type' => 'post',
												'posts_per_page' => -1,
											);

											if ( isset( $portfolio_setting['layout_post'] ) ) {
												$args['post_type'] = $portfolio_setting['layout_post'];
											}

											if ( isset( $portfolio_setting['categories'] ) && ! empty( $portfolio_setting['categories'] ) ) {
												$args['tax_query'] = array(
													'relation' => 'or',
													array(
														'taxonomy' => $portfolio_setting['taxonomy'],
														'field' => 'slug',
														'terms' => $portfolio_setting['categories'],
													),
												);
											}
											$the_query = new WP_Query( $args );
											if ( $the_query->have_posts() ) {
												while ( $the_query->have_posts() ) {
													$the_query->the_post();
													?>
													<option value="<?php echo get_the_ID(); ?>" <?php echo ( ! empty( $portfolio_setting['post'] ) && in_array( get_the_ID(), $portfolio_setting['post'] ) ) ? 'selected="selected"' : ''; ?>><?php echo esc_html( get_the_title() ); ?></option> 
													<?php
												}
											}
											?>
										</select>
									</div>
									<p><?php esc_html_e( 'Leave blank if you want to show all posts.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="portfolio_number_post_tr">
								<td>
									<label for="portfolio_number_post"> <?php esc_html_e( 'Display Number of Posts', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td>
									<div class="input-number-cover">
										<input id="portfolio_number_post" type="number" name="portfolio_number_post" class="numberOnly" value="<?php echo ( isset( $portfolio_setting['number_post'] ) && '' != $portfolio_setting['number_post'] ) ? esc_attr( $portfolio_setting['number_post'] ) : 10; ?>" min="1"/>
									</div>
									<p><?php esc_html_e( 'Number of posts to be shown in showcase page.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="pro-feature portfolio_number_post_tr">
								<td>
									<label for="portfolio_preview_number_post" class="porfolio-title">
										<?php esc_html_e( 'Display Number of Posts on Preview Page', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<div class="input-number-cover">
										<input id="portfolio_preview_number_post" type="number" name="portfolio_preview_number_post" class="numberOnly" value="<?php echo ( isset( $portfolio_setting['preview_number_post'] ) && '' != $portfolio_setting['preview_number_post'] ) ? esc_attr( $portfolio_setting['preview_number_post'] ) : 10; ?>" min="0" readonly/>
									</div>
									<p><?php esc_html_e( 'Number of posts to be shown in preview page.', 'portfolio-designer' ); ?>
									</p>
									<p>
										<strong>
											<?php esc_html_e( 'Note: ', 'portfolio-designer' ); ?>
										</strong>
										<?php esc_html_e( 'If Layout type is "3D Carousel" then set only odd number ex. 3,5,7,...', 'portfolio-designer' ); ?>
								</p>
								</td>
							</tr>

							<tr class='pro-feature'>
								<td>
									<label for="portfolio_no_post_found_text" class="porfolio-title">
										
										<?php esc_html_e( 'No Post Found Text', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php
									$no_post_found_text = ( isset( $portfolio_setting['no_post_found_text'] ) && '' != $portfolio_setting['no_post_found_text'] ) ? $portfolio_setting['no_post_found_text'] : esc_attr__( 'No posts found.', 'portfolio-designer' );
									?>
									<input type="text" name="portfolio_no_post_found_text" id="portfolio_no_post_found_text" value="<?php echo ( isset( $no_post_found_text ) && '' != $no_post_found_text ) ? esc_attr( $no_post_found_text ) : ''; ?>" class="required" placeholder="<?php esc_attr_e( 'Enter No Posts Found text', 'portfolio-designer' ); ?>" aria-required="true" required="required" readonly>
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_order_by"><?php esc_html_e( 'Order By', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<?php $portfolio_order_by = ( isset( $portfolio_setting['order_by'] ) && '' != $portfolio_setting['order_by'] ) ? $portfolio_setting['order_by'] : 'date'; ?>
									<div class="select-cover">
										<select id="portfolio_order_by" name="portfolio_order_by">
											<option value="author" <?php echo ( 'author' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Author', 'portfolio-designer-lite' ); ?></option>
											<option value="comment_count" <?php echo ( 'comment_count' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Comment Count', 'portfolio-designer-lite' ); ?></option>
											<option value="date"<?php echo ( 'date' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Date', 'portfolio-designer-lite' ); ?></option>
											<option value="ID" <?php echo ( 'ID' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'ID', 'portfolio-designer-lite' ); ?></option>
											<option value="modified" <?php echo ( 'modified' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Modified Date', 'portfolio-designer-lite' ); ?></option>
											<option value="name" <?php echo ( 'name' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Name', 'portfolio-designer-lite' ); ?></option>
											<option value="title" <?php echo ( 'title' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Title', 'portfolio-designer-lite' ); ?></option>
											<option value="rand" <?php echo ( 'rand' == $portfolio_order_by ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Random', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p><?php esc_html_e( 'Parameter to sort posts.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="portfolio_order_tr">
								<td>
									<label for="portfolio_order"> <?php esc_html_e( 'Order', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td>
									<?php
									$portfolio_order = ( isset( $portfolio_setting['order'] ) && '' != $portfolio_setting['order'] ) ? $portfolio_setting['order'] : 'DESC';
									?>
									<div class="select-cover">
										<select id="portfolio_order" name="portfolio_order">
											<option value="ASC" <?php echo ( 'ASC' == $portfolio_order ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Ascending Order', 'portfolio-designer-lite' ); ?></option>
											<option value="DESC" <?php echo ( 'DESC' == $portfolio_order ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Descending Order', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p><?php esc_html_e( 'Descending order from highest to lowest values ( 3,2,1; c,b,a ) or Ascending order from lowest to highest values ( 1,2,3; a,b,c).', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>

							<tr class="pro-feature portfolio_ignore_sticky_post_tr">
								<td>
									<label for="portfolio_ignore_sticky_post" class="porfolio-title">
										
										<?php esc_html_e( 'Ignore Sticky Post', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<?php
									$portfolio_ignore_sticky_post = 1;
									if ( isset( $portfolio_setting['ignore_sticky_post'] ) ) {
										$portfolio_ignore_sticky_post = ( 1 == $portfolio_setting['ignore_sticky_post'] ) ? 1 : 0;
									}
									?>
									<fieldset class="portfolio-social-options portfolio_ignore_sticky_post buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_ignore_sticky_post_1" name="portfolio_ignore_sticky_post" type="radio" value="1" <?php checked( 1, $portfolio_ignore_sticky_post ); ?> />
										<label for="portfolio_ignore_sticky_post_1" <?php checked( 1, $portfolio_ignore_sticky_post ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_ignore_sticky_post_0" name="portfolio_ignore_sticky_post" type="radio" value="0" <?php checked( 0, $portfolio_ignore_sticky_post ); ?>/>
										<label for="portfolio_ignore_sticky_post_0" <?php checked( 0, $portfolio_ignore_sticky_post ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr class="pro-feature portfolio_display_sort_by_tr">
								<td>
									<label for="portfolio_sort_by" class="porfolio-title">
										
										<?php esc_html_e( 'Display Sort By', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php
									$display_sort_by = 0;
									if ( isset( $portfolio_setting['display_sort_by'] ) && '' != $portfolio_setting['display_sort_by'] ) {
										$display_sort_by = $portfolio_setting['display_sort_by'];
									}
									?>
									<fieldset class="portfolio-social-options portfolio_sort_by buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_display_sort_by_0" name="portfolio_display_sort_by" type="radio" value="1" <?php checked( 1, $display_sort_by ); ?> />
										<label for="portfolio_display_sort_by_0"><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_display_sort_by_1" name="portfolio_display_sort_by" type="radio" value="0" <?php checked( 0, $display_sort_by ); ?>/>
										<label for="portfolio_display_sort_by_1"><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
							

							<tr class="pro-feature top_filter_alignment">
							<td>
									<label for="portfolio_enable_pagination" class="porfolio-title">
										
										<?php esc_html_e( 'Top Filter Alignment', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td Class="pro-feature">
									<?php $filter_alignment = ( isset( $portfolio_setting['filter_alignment'] ) && '' != $portfolio_setting['filter_alignment'] ) ? $portfolio_setting['filter_alignment'] : 'center'; ?>
									<div class="select-cover">
									<select name="filter_alignment" id="filter_alignment" class="chosen-select">
											<option value="left" <?php echo selected( 'left', $filter_alignment ); ?> ><?php esc_html_e( 'Left', 'portfolio-designer' ); ?></option>
											<option value="right"<?php echo selected( 'right', $filter_alignment ); ?> ><?php esc_html_e( 'Right', 'portfolio-designer' ); ?></option>
											<option value="center" <?php echo selected( 'center', $filter_alignment ); ?>><?php esc_html_e( 'Center', 'portfolio-designer' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr class=" pro-feature portfolio_sort_by_tr">
								<td>
									<label for="portfolio_display_sorting_order" class="porfolio-title">
										
										<?php esc_html_e( 'Display Sorting Order', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td Class="pro-feature">
									<?php
									$portfolio_sorting_order = ( isset( $portfolio_setting['sorting_order'] ) && '' != $portfolio_setting['sorting_order'] ) ? $portfolio_setting['sorting_order'] : '0';
									?>
									<fieldset class="portfolio-social-options portfolio_display_sorting_order buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_display_sorting_order_0" name="portfolio_display_sorting_order" type="radio" value="1" <?php checked( 1, $portfolio_sorting_order ); ?> />
										<label for="portfolio_display_sorting_order_0"><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_display_sorting_order_1" name="portfolio_display_sorting_order" type="radio" value="0" <?php checked( 0, $portfolio_sorting_order ); ?>/>
										<label for="portfolio_display_sorting_order_1"><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div id="portdesignlayout" 
				<?php
				if ( 'portdesignlayout' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table>
							<tr>
								<td>
									<label for="portfolio_layout_type"><?php esc_html_e( 'Select Layout Type', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<?php $portfolio_layout_type = ( isset( $portfolio_setting['layout_type'] ) && '' != $portfolio_setting['layout_type'] ) ? $portfolio_setting['layout_type'] : 'grid'; ?>
									<div class="select-cover">
										<select id="portfolio_layout_type" name="portfolio_layout_type">
											<option value="grid" <?php echo ( 'grid' == $portfolio_layout_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Grid Layout', 'portfolio-designer-lite' ); ?></option>
											<option value="masonary" <?php echo ( 'masonary' == $portfolio_layout_type ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Masonry Layout', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<td class="pro-feature">
									<label for="portfolio_column_layout"> <?php esc_html_e( 'Select Column Layout(Desktop)', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td class="pro-feature">
									<?php $portfolio_column_layout = ( isset( $portfolio_setting['column_layout'] ) && '' != $portfolio_setting['column_layout'] ) ? $portfolio_setting['column_layout'] : '3'; ?>
									<div class="select-cover">
										<select id="portfolio_column_layout" name="">
											<option value="3" selected=""><?php esc_html_e( '3 Columns', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p><?php esc_html_e( 'Column layout for (Desktop - Above 980px)', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="column_tr">
								<td class="pro-feature">
									<label for="portfolio_column_layout_ipad" class="porfolio-title">
										<?php esc_html_e( 'Select Column Layout(ipad)', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<div class="select-cover">
										<select id="portfolio_column_layout" name="portfolio_column_layout_ipad">
											<option value="3" selected ><?php esc_html_e( '3 Columns', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p><?php esc_html_e( 'Column layout for (iPad - 720px - 980px) ', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="column_tr">
								<td class="pro-feature">
									<label for="portfolio_column_layout_tablet" class="porfolio-title">
										<?php esc_html_e( 'Select Column Layout(Tablet)', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<div class="select-cover">
										<select id="portfolio_column_layout" name="portfolio_column_layout_tablet">
											<option value="2" selected ><?php esc_html_e( '2 Columns', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p><?php esc_html_e( 'Column layout for (Tablet - 480px - 720px)', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="column_tr">
								<td class="pro-feature">
									<label for="portfolio_column_layout_mobile" class="porfolio-title">
										<?php esc_html_e( 'Select Column Layout(Mobile)', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<div class="select-cover">
										<select id="portfolio_column_layout" name="portfolio_column_layout_mobile">
											<option value="1" selected ><?php esc_html_e( '1 Column', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p><?php esc_html_e( 'Column layout for (Mobile - Smaller Than 480px) ', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="portfolio_simple_layout">
								<td>
									<label for="portfolio_column_space"><?php esc_html_e( 'Select Column Spaces', 'portfolio-designer-lite' ); ?></label>
								</td>								
								<td>
									<div class="input-number-cover large-input">
										<input id="portfolio_column_space" name="portfolio_column_space" class="numberOnly" type="number" value="<?php echo ( isset( $portfolio_setting['column_space'] ) && '' != $portfolio_setting['column_space'] ) ? esc_attr( $portfolio_setting['column_space'] ) : '5'; ?>" min="0" />
									</div>
									<div class="select-cover small-select pro-feature">
										<select name="portfolio_column_space_unit" id="portfolio_column_space_unit">
											<option value="px" selected >px</option>
											<option value="em">em</option>
											<option value="%">%</option>
											<option value="cm">cm</option>
											<option value="ex">ex</option>
											<option value="mm">mm</option>
											<option value="in">in</option>
											<option value="pt">pt</option>
											<option value="pc">pc</option>
										</select>
									</div>
									<p><?php esc_html_e( 'Horizontal space between two posts.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr class="portfolio_simple_layout">
								<td>
									<label for="portfolio_row_space"><?php esc_html_e( 'Select Rows Spaces', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<div class="input-number-cover large-input">
										<input id="portfolio_row_space" name="portfolio_row_space" class="numberOnly" type="number" value="<?php echo ( isset( $portfolio_setting['row_space'] ) && '' != $portfolio_setting['row_space'] ) ? esc_attr( $portfolio_setting['row_space'] ) : '5'; ?>" min="0" />
									</div>
									<div class="select-cover small-select pro-feature">
										<select name="portfolio_row_space_unit" id="portfolio_row_space_unit">
											<option value="px" selected >px</option>
											<option value="em">em</option>
											<option value="%">%</option>
											<option value="cm">cm</option>
											<option value="ex">ex</option>
											<option value="mm">mm</option>
											<option value="in">in</option>
											<option value="pt">pt</option>
											<option value="pc">pc</option>
										</select>
									</div>
									<p><?php esc_html_e( 'Vertical space between two posts.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>

						</table>
					</div>
				</div>
				<div id="portdesignthumbnail" 
				<?php
				if ( 'portdesignthumbnail' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table>
							<tr>
								<td>
									<label for="portfolio_thumb_size"> <?php esc_html_e( 'Select Thumbnail Size', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td>
									<?php $portfolio_thumb_size = ( isset( $portfolio_setting['thumb_size'] ) && '' != $portfolio_setting['thumb_size'] ) ? $portfolio_setting['thumb_size'] : 'full'; ?>
									<div class="select-cover">
										<select id="portfolio_thumb_size" name="portfolio_thumb_size">
											<option value="full" <?php echo ( 'full' == $portfolio_thumb_size ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Original Resolution', 'portfolio-designer-lite' ); ?></option>
											<?php
											global $_wp_additional_image_sizes;
											$thumb_sizes = array();
											foreach ( get_intermediate_image_sizes() as $img_s ) {
												$thumb_sizes [ $img_s ] = array( 0, 0 );
												if ( in_array( $img_s, array( 'thumbnail', 'medium', 'large' ) ) ) {
													?>
													<option value="<?php echo esc_attr( $img_s ); ?>"  <?php echo ( $portfolio_thumb_size == $img_s ) ? 'selected="selected"' : ''; ?>> <?php echo esc_html( $img_s ) . ' (' . esc_html( get_option( $img_s . '_size_w' ) ) . 'x' . esc_html( get_option( $img_s . '_size_h' ) ) . ')'; ?> </option>
													<?php
												} else {
													if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $img_s ] ) ) {
														?>
														<option value="<?php echo esc_attr( $img_s ); ?>"  <?php echo ( $portfolio_thumb_size == $img_s ) ? 'selected="selected"' : ''; ?>> <?php echo esc_html( $img_s ) . ' (' . esc_html( $_wp_additional_image_sizes[ $img_s ]['width'] ) . 'x' . esc_html( $_wp_additional_image_sizes[ $img_s ]['height'] ) . ')'; ?> </option>
														<?php
													}
												}
											}
											?>
										</select>
									</div>
									<p>
										<strong><?php esc_html_e( 'Note', 'portfolio-designer-lite' ); ?>: </strong>
										<?php esc_html_e( 'The original resolution is loaded if a thumbnail size doesn\'t exist in an image. ', 'portfolio-designer-lite' ); ?>
									</p>
								</td>
							</tr>

							<tr class="pro-feature enable_image_link">
								<td>
									<label for="portfolio_enable_image_link" class="porfolio-title">
										<?php esc_html_e( 'Enable link on Image', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<?php
									$enable_image_link = 1;
									if ( isset( $portfolio_setting['enable_image_link'] ) ) {
										$enable_image_link = $portfolio_setting['enable_image_link'];
									}
									?>
									<fieldset class="portfolio-social-options portfolio_enable_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_enable_image_link_1" name="portfolio_enable_image_link" type="radio" value="1" <?php checked( 1, $enable_image_link ); ?> />
										<label for="portfolio_enable_image_link_1" <?php checked( 1, $enable_image_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_enable_image_link_0" name="portfolio_enable_image_link" type="radio" value="0" <?php checked( 0, $enable_image_link ); ?>/>
										<label for="portfolio_enable_image_link_0" <?php checked( 0, $enable_image_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php esc_html_e( 'Select Default Image', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<span class="portfolio_default_image_holder">
										<?php
										if ( isset( $portfolio_setting['default_image_src'] ) && '' != $portfolio_setting['default_image_src'] ) {
											echo '<img src="' . esc_url( $portfolio_setting['default_image_src'] ) . '"/>';
										}
										?>
									</span>
									<?php if ( isset( $portfolio_setting['default_image_src'] ) && '' != $portfolio_setting['default_image_src'] ) { ?>
										<input id="portfolio-image-action-button" class="button pdl-remove_image_button" type="button" value="<?php esc_attr_e( 'Remove Image', 'portfolio-designer-lite' ); ?>">
									<?php } else { ?>
										<input class="button pdl-upload_image_button" type="button" value="<?php esc_attr_e( 'Upload Image', 'portfolio-designer-lite' ); ?>">
									<?php } ?>
									<input type="hidden" value="<?php echo isset( $portfolio_setting['default_image_id'] ) ? intval( $portfolio_setting['default_image_id'] ) : ''; ?>" name="portfolio_default_image_id" id="portfolio_default_image_id">
									<input type="hidden" value="<?php echo isset( $portfolio_setting['default_image_src'] ) ? esc_attr( $portfolio_setting['default_image_src'] ) : ''; ?>" name="portfolio_default_image_src" id="portfolio_default_image_src">
								</td>
							</tr>
							<tr class="pro-feature select_html_poster_image">
								<td>
									<label class="porfolio-title">
										<?php esc_html_e( 'Select HTML5 Poster Image', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<span class="portfolio_html_poster_image_holder">
										<?php
										if ( isset( $portfolio_setting['portfolio_html_poster_image_src'] ) && '' != $portfolio_setting['portfolio_html_poster_image_src'] ) {
											echo '<img src="' . esc_url( $portfolio_setting['portfolio_html_poster_image_src'] ) . '"/>';
										}
										?>
									</span>
									<?php if ( isset( $portfolio_setting['portfolio_html_poster_image_src'] ) && '' != $portfolio_setting['portfolio_html_poster_image_src'] ) { ?>
										<input id="portfolio-image-action-button" class="button portfolio-poster_remove_image_button" type="button" value="<?php esc_attr_e( 'Remove Image', 'portfolio-designer' ); ?>">
									<?php } else { ?>
										<input class="button pdl-upload_image_button" type="button" value="<?php esc_attr_e( 'Upload Image', 'portfolio-designer' ); ?>">
									<?php } ?>
									<input type="hidden" value="<?php echo isset( $portfolio_setting['portfolio_html_poster_image_id'] ) ? esc_attr( $portfolio_setting['portfolio_html_poster_image_id'] ) : ''; ?>" name="portfolio_html_poster_image_id" id="portfolio_html_poster_image_id">
									<input type="hidden" value="<?php echo isset( $portfolio_setting['portfolio_html_poster_image_src'] ) ? esc_attr( $portfolio_setting['portfolio_html_poster_image_src'] ) : ''; ?>" name="portfolio_html_poster_image_src" id="portfolio_html_poster_image_src">
								</td>
							</tr>
							<tr class="pro-feature portfolio_media_source_tr">
								<td>
									<label for="portfolio_media_source" class="porfolio-title">
										<?php esc_html_e( 'Media Source', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php
									$portfolio_media_source_order = 'featured_image,youtube,vimeo,html5,dailymotion,videoshub,content-image,content-iframe,content-html5,content-youtube,content-vimeo,youtube-thumbnail,vimeo-thumbnail,dailymotion-thumbnail,html5-thumbnail,soundcloud,mixcloud,beatport';
									$media_source_order           = isset( $portfolio_setting['media_source_order'] ) ? $portfolio_setting['media_source_order'] : $portfolio_media_source_order;
									$portfolio_media_source       = isset( $portfolio_setting['media_source'] ) ? $portfolio_setting['media_source'] : array( 'featured_image' );
									?>
									<ul id="media_sortable">
										<?php
										$media_source_orders = explode( ',', $media_source_order );
										foreach ( $media_source_orders as $value ) {
											if ( 'featured_image' === $value ) {
												$label = 'Featured Image';
											} elseif ( 'youtube' === $value ) {
												$label = 'Youtube Video';
											} elseif ( 'vimeo' === $value ) {
												$label = 'Vimeo Video';
											} elseif ( 'html5' === $value ) {
												$label = 'HTML5 Video';
											} elseif ( 'dailymotion' === $value ) {
												$label = 'Dailymotion Video';
											} elseif ( 'videoshub' === $value ) {
												$label = 'VideosHub Video';
											} elseif ( 'content-image' === $value ) {
												$label = 'First Content Image';
											} elseif ( 'content-iframe' === $value ) {
												$label = 'First Content iFrame';
											} elseif ( 'content-html5' === $value ) {
												$label = 'First Content HTML5 Video';
											} elseif ( 'content-youtube' === $value ) {
												$label = 'First Content YouTube Video';
											} elseif ( 'content-vimeo' === $value ) {
												$label = 'First Content Vimeo Video';
											} elseif ( 'youtube-thumbnail' === $value ) {
												$label = 'Youtube Video Thumbnail';
											} elseif ( 'vimeo-thumbnail' === $value ) {
												$label = 'Vimeo Video Thumbnail';
											} elseif ( 'dailymotion-thumbnail' === $value ) {
												$label = 'Dailymotion Video Thumbnail';
											} elseif ( 'html5-thumbnail' === $value ) {
												$label = 'HTML5 Default Image';
											} elseif ( 'soundcloud' === $value ) {
												$label = 'Soundcloud Audio';
											} elseif ( 'mixcloud' === $value ) {
												$label = 'Mixcloud Audio';
											} elseif ( 'beatport' === $value ) {
												$label = 'Beatport Audio';
											}
											?>
											<li class="ui-state-default" data-order="<?php echo esc_attr( $value ); ?>">
												<label class="desc_checkbox">
													<input id="portfolio_media_source" name="portfolio_media_source[]" type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php echo ( in_array( $value, $portfolio_media_source ) ) ? 'checked="checked"' : ''; ?>/>
													<?php echo esc_html( $label ); ?>
												</label>
											</li>
											<?php
										}
										?>
									</ul>
									<input id="portfolio_media_source_order" name="portfolio_media_source_order" type="hidden" value="<?php echo esc_attr( $media_source_order ); ?>"/>
									<p>
										<strong><?php esc_html_e( 'Note: ', 'portfolio-designer' ); ?></strong>
										<?php esc_html_e( ' First Media Source will be loaded as default. In case one source does not exist, next available media source in this order will be used.', 'portfolio-designer' ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_enable_overlay"><?php esc_html_e( 'Image Overlay Effect', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<label class="desc_checkbox">
										<input id="portfolio_enable_overlay" name="portfolio_enable_overlay" type="checkbox" value="1" <?php echo ( isset( $portfolio_setting['enable_overlay'] ) && 1 == $portfolio_setting['enable_overlay'] ) ? 'checked="checked"' : ''; ?>/>
										<?php esc_html_e( 'Apply Image Overlay Effects', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
							</tr>
							<tr class="portfolio_overlay_tr">
								<td>
									<label for="portfolio_image_effect"> <?php esc_html_e( 'Select Mouse Hover Effect', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td>
									<?php $portfolio_image_effect = ( isset( $portfolio_setting['image_effect'] ) && '' != $portfolio_setting['image_effect'] ) ? $portfolio_setting['image_effect'] : 'right_top_corner'; ?>
									<div class="select-cover">
										<select id="portfolio_image_effect" name="portfolio_image_effect">
											<option value="effect_1" <?php echo ( 'effect_1' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Zoom Out', 'portfolio-designer-lite' ); ?></option>
											<option value="effect_2" <?php echo ( 'effect_2' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Overlay Slide', 'portfolio-designer-lite' ); ?></option>
											<option value="effect_3" <?php echo ( 'effect_3' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Corner Slide', 'portfolio-designer-lite' ); ?></option>
											<option value="effect_4" <?php echo ( 'effect_4' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Rotating Zoom Out', 'portfolio-designer-lite' ); ?></option>
											<option value="right_corner" <?php echo ( 'right_corner' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Right Corner', 'portfolio-designer-lite' ); ?></option>
											<option value="left_corner" <?php echo ( 'left_corner' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Left Corner', 'portfolio-designer-lite' ); ?></option>
											<option value="depth_in" <?php echo ( 'depth_in' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Depth Zoom In', 'portfolio-designer-lite' ); ?></option>
											<option value="depth_out" <?php echo ( 'depth_out' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Depth Zoom Out', 'portfolio-designer-lite' ); ?></option>
											<option value="depth_rorator" <?php echo ( 'depth_rorator' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Depth Rotator', 'portfolio-designer-lite' ); ?></option>
											<option value="rotator_effect" <?php echo ( 'rotator_effect' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Rotator', 'portfolio-designer-lite' ); ?></option>
											<option value="slide_top" <?php echo ( 'slide_top' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Slide Top', 'portfolio-designer-lite' ); ?></option>
											<option value="slide_right" <?php echo ( 'slide_right' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Slide Right', 'portfolio-designer-lite' ); ?></option>
											<option value="slide_bottom" <?php echo ( 'slide_bottom' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Slide Bottom', 'portfolio-designer-lite' ); ?></option>
											<option value="slide_left" <?php echo ( 'slide_left' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Slide Left', 'portfolio-designer-lite' ); ?></option>
											<option value="enclose_zoomin" <?php echo ( 'enclose_zoomin' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Enclose ZoomIn', 'portfolio-designer-lite' ); ?></option>
											<option value="enclose_zoomout" <?php echo ( 'enclose_zoomout' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Enclose ZoomOut', 'portfolio-designer-lite' ); ?></option>
											<option value="enclose_fadein" <?php echo ( 'enclose_fadein' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Enclose FaddeIn', 'portfolio-designer-lite' ); ?></option>
											<option value="enclose_fadeout" <?php echo ( 'enclose_fadeout' == $portfolio_image_effect ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Enclose FaddeOut', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
								</td>
							</tr>

							<tr class="hide_effect_mobile_table_option">
									<td>
										<div class="port-typo-label">
											<label for="portfolio_number_post" class="porfolio-title">
												
												<?php esc_html_e( 'Hide Hover Effect On Mobile Device', 'portfolio-designer' ); ?>
											</label>
										</div>
									</td>
									<td>
										<div class="select-cover">
											<?php
											$portfolio_hide_hover_effect_mobile = 0;
											if ( isset( $portfolio_setting['portfolio_hide_hover_effect_mobile'] ) && '' != $portfolio_setting['portfolio_hide_hover_effect_mobile'] ) {
												$portfolio_hide_hover_effect_mobile = $portfolio_setting['portfolio_hide_hover_effect_mobile'];
											}
											?>
											<fieldset class="portfolio-social-options portfolio_social_icon_style buttonset buttonset-hide" data-hide='1'>
												<input id="portfolio_hide_hover_effect_mobile_tag_yes_1" name="portfolio_hide_hover_effect_mobile" type="radio" class="optionradio" value="1" <?php checked( 1, $portfolio_hide_hover_effect_mobile ); ?>/>
												<label for="portfolio_hide_hover_effect_mobile_tag_yes_1" <?php checked( 1, $portfolio_hide_hover_effect_mobile ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
												<input id="portfolio_hide_hover_effect_mobile_tag_no_0" name="portfolio_hide_hover_effect_mobile" type="radio" class="optionradio" value="0" <?php checked( 0, $portfolio_hide_hover_effect_mobile ); ?>/>
												<label for="portfolio_hide_hover_effect_mobile_tag_no_0" <?php checked( 0, $portfolio_hide_hover_effect_mobile ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
											</fieldset>
									</td>
							</tr>
							<tr class="content_position_tr">
								<td>
									<label for="portfolio_content_position"><?php esc_html_e( 'Select Content Position', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<?php $portfolio_content_position = ( isset( $portfolio_setting['content_position'] ) && '' != $portfolio_setting['content_position'] ) ? $portfolio_setting['content_position'] : 'overlay_image'; ?>
									<div class="select-cover">
										<select id="portfolio_content_position" name="portfolio_content_position">
											<?php if ( ( isset( $portfolio_setting['enable_overlay'] ) && 1 == $portfolio_setting['enable_overlay'] ) ) { ?>
												<option value="overlay_image" <?php echo ( 'overlay_image' == $portfolio_content_position ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Overlay on Image', 'portfolio-designer-lite' ); ?></option>
											<?php } ?>
											<option value="bottom_image" <?php echo ( 'bottom_image' == $portfolio_content_position ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Bottom of Image', 'portfolio-designer-lite' ); ?></option>
											<option value="left_side" <?php echo ( 'left_side' == $portfolio_content_position ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Left side of Image', 'portfolio-designer-lite' ); ?></option>
											<option value="right_side" <?php echo ( 'right_side' == $portfolio_content_position ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Right side of Image', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr class="portfolio_border_radius_tr">
								<td>
									<label for="portfolio_border_radius" class="porfolio-title">
										<?php esc_html_e( 'Select Border Radius', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td>
									<div class="font_size_cover">
										<div class="pull-left">
											<div class="grid_col_space range_slider_fontsize" id="portfolio_border_radius_slider" data-value="<?php echo ( isset( $portfolio_setting['border_radius'] ) && '' != $portfolio_setting['border_radius'] ) ? esc_attr( $portfolio_setting['border_radius'] ) : 0; ?>"></div>
										</div>
										<div class="pull-right">
											<div class="slide_val input-number-cover">
												<input id="portfolio_border_radius" name="portfolio_border_radius" type="number" class="numberOnly range-slider__value" value="<?php echo ( isset( $portfolio_setting['border_radius'] ) && '' != $portfolio_setting['border_radius'] ) ? esc_attr( $portfolio_setting['border_radius'] ) : 0; ?>" min="0"/>
											</div>
											<div class="select-cover font-size-cover">
												<select id="portfolio_border_radius_unit" name="portfolio_border_radius_unit">
													<option value="px" selected>px</option>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>							
							<tr class="portfolio_summary_tr">
								<td>
									<label for="portfolio_summary"><?php esc_html_e( 'Display Summary in Words', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<div class="input-number-cover">
										<input id="portfolio_summary" name="portfolio_summary" type="number" class="numberOnly" min="0" value="<?php echo ( isset( $portfolio_setting['summary'] ) && '' != $portfolio_setting['summary'] ) ? esc_attr( $portfolio_setting['summary'] ) : 0; ?>"/>
									</div>
									<p><b><?php esc_html_e( 'Note', 'portfolio-designer-lite' ); ?>: </b><?php esc_html_e( 'Set ZERO for disable summary.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>


							<tr class="portfolio_image_overlay">
								<td>
									<label for="portfolio_enable_popup_link"> <?php esc_html_e( 'Show Image Popup Link', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td>
									<label class="desc_checkbox">
										<input id="portfolio_enable_popup_link" name="portfolio_enable_popup_link" type="checkbox" value="1" <?php echo ( isset( $portfolio_setting['enable_popup_link'] ) && 1 == $portfolio_setting['enable_popup_link'] ) ? 'checked="checked"' : ''; ?>/>
										<?php esc_html_e( 'Display popup link when hover on image', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
							</tr>
							<tr class="portfolio_popup_tr search_icon_td">
								<td class='pro-feature'>
									<label for="portfolio_search_icon" class="porfolio-title">
										<?php esc_html_e( 'Select Image Popup icon from list', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td class='pro-feature'>
									<div class="pd-form-control">
										<div class="pd-selected-icon" title="fa fa-search">
											<i class="fa fa-search"></i>
										</div>
									</div>
									<input class="button search_icon_open" type="button" value="<?php esc_attr_e( 'Select Gallery Icon', 'portfolio-designer-lite' ); ?>">
								</td>
							</tr>
							<tr class='portfolio_popup_project_tr'>
								<td>
									<label for="portfolio_image_link"> <?php esc_html_e( 'Project URL Open In', 'portfolio-designer-lite' ); ?> </label>
								</td>
								<td>
									<?php $portfolio_image_link = ( isset( $portfolio_setting['image_link'] ) && '' != $portfolio_setting['image_link'] ) ? $portfolio_setting['image_link'] : 'disable'; ?>
									<div class="select-cover">
										<select id="portfolio_image_link" name="portfolio_image_link">
											<option value="disable" <?php echo ( 'disable' == $portfolio_image_link ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Disable', 'portfolio-designer-lite' ); ?></option>
											<option value="same_tab" <?php echo ( 'same_tab' == $portfolio_image_link ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Same Tab', 'portfolio-designer-lite' ); ?></option>
											<option value="new_tab" <?php echo ( 'new_tab' == $portfolio_image_link ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'New Tab', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
									<p>
										<?php esc_html_e( 'The project URL while adding single custom post type.', 'portfolio-designer-lite' ); ?>
										<br/>
										<b><?php esc_html_e( 'Note', 'portfolio-designer-lite' ); ?>: </b>
										<?php esc_html_e( 'This will work only for custom post type generated by this plugin, on image hover.', 'portfolio-designer-lite' ); ?>
									</p>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div id="portdesignfilter" 
				<?php
				if ( 'portdesignfilter' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table>
							<tr>
								<td>
									<label for="portfolio_enable_filter" class="porfolio-title">
										<?php esc_html_e( 'Enable Filter?', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td>
									<?php
									$enable_filter = 0;
									if ( isset( $portfolio_setting['enable_filter'] ) ) {
										$enable_filter = ( 1 == $portfolio_setting['enable_filter'] ) ? 1 : 0;
									}
									?>
									<fieldset class="portfolio-social-options portfolio_enable_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_enable_filter_1" name="portfolio_enable_filter" type="radio" value="1" <?php checked( 1, $enable_filter ); ?> />
										<label for="portfolio_enable_filter_1" <?php checked( 1, $enable_filter ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer-lite' ); ?></label>
										<input id="portfolio_enable_filter_0" name="portfolio_enable_filter" type="radio" value="0" <?php checked( 0, $enable_filter ); ?>/>
										<label for="portfolio_enable_filter_0" <?php checked( 0, $enable_filter ); ?>><?php esc_html_e( 'No', 'portfolio-designer-lite' ); ?></label>
									</fieldset>
									<p>
										<b><?php esc_html_e( 'Note: ', 'portfolio-designer-lite' ); ?></b>
										<?php esc_html_e( 'If you enable filter then Pagination Settings does not apply', 'portfolio-designer-lite' ); ?>
									</p>
								</td>
							</tr>
							<tr class="pro-feature filter_data_tr">
								<td>
									<label for="portfolio_isotop_filter_design" class="porfolio-title">
										
										<?php esc_html_e( 'Select Filter Design', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php $portfolio_isotop_filter_design = ( isset( $portfolio_setting['isotop_filter_design'] ) && '' != $portfolio_setting['isotop_filter_design'] ) ? $portfolio_setting['isotop_filter_design'] : 'template-1'; ?>
									<div class="select-cover">
										<select id="portfolio_isotop_filter_design" name="portfolio_isotop_filter_design" class="chosen-select">
											<option value="template-1" <?php echo ( 'template-1' == $portfolio_isotop_filter_design ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template 1', 'portfolio-designer' ); ?></option>
											<option value="template-2" <?php echo ( 'template-2' == $portfolio_isotop_filter_design ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template 2', 'portfolio-designer' ); ?></option>
											<option value="template-3" <?php echo ( 'template-3' == $portfolio_isotop_filter_design ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template 3', 'portfolio-designer' ); ?></option>
											<option value="template-4" <?php echo ( 'template-4' == $portfolio_isotop_filter_design ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template 4', 'portfolio-designer' ); ?></option>
										</select>
									</div>
									<div class="portfolio-designer-setting-description portfolio-designer-setting-filter">
											<!-- <img class="filter_template_images"src="<?php echo esc_url( PORT_LITE_PLUGIN_URL ) . 'images/filter/' . esc_attr( $portfolio_isotop_filter_design ) . '.png'; ?>"> -->
										</div>
								</td>
							</tr>
							<tr class="pro-feature filter_data_tr">
								<td>
									<label for="portfolio_display_count_filter" class="porfolio-title">
										
										<?php esc_html_e( 'Display Count with filter', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<?php
									$display_count_filter = 0;
									if ( isset( $portfolio_setting['display_count_filter'] ) ) {
										$display_count_filter = ( 1 == $portfolio_setting['display_count_filter'] ) ? 1 : 0;
									}
									?>
									<fieldset class="portfolio-social-options portfolio_display_count_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_display_count_filter_1" name="portfolio_display_count_filter" type="radio" value="1" <?php checked( 1, $display_count_filter ); ?> />
										<label for="portfolio_display_count_filter_1" <?php checked( 1, $display_count_filter ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_display_count_filter_0" name="portfolio_display_count_filter" type="radio" value="0" <?php checked( 0, $display_count_filter ); ?>/>
										<label for="portfolio_display_count_filter_0" <?php checked( 0, $display_count_filter ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
									<p>
										<b><?php esc_html_e( 'Note: ', 'portfolio-designer' ); ?></b>
										<?php esc_html_e( 'If you select Justify layout then "Display Count with filter" option does not apply', 'portfolio-designer' ); ?>
									</p>
								</td>
							</tr>
							<tr class="pro-feature filter_data_tr">
								<td>
									<label for="portfolio_display_checkbox_filter" class="porfolio-title">
										
										<?php esc_html_e( 'Display Checkbox with filter', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<?php
									$display_checkbox_filter = 0;
									if ( isset( $portfolio_setting['display_checkbox_filter'] ) ) {
										$display_checkbox_filter = ( 1 == $portfolio_setting['display_checkbox_filter'] ) ? 1 : 0;
									}
									?>
									<fieldset class="portfolio-social-options portfolio_display_checkbox_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_display_checkbox_filter_1" name="portfolio_display_checkbox_filter" type="radio" value="1" <?php checked( 1, $display_checkbox_filter ); ?> />
										<label for="portfolio_display_checkbox_filter_1" <?php checked( 1, $display_checkbox_filter ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_display_checkbox_filter_0" name="portfolio_display_checkbox_filter" type="radio" value="0" <?php checked( 0, $display_checkbox_filter ); ?>/>
										<label for="portfolio_display_checkbox_filter_0" <?php checked( 0, $display_checkbox_filter ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr class="filter_data_tr">
								<td>
									<label for="portfolio_show_all_txt"><?php esc_html_e( 'Text of "Show All" filter tag', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<input id="portfolio_show_all_txt" name="portfolio_show_all_txt" type="text" placeholder="<?php esc_html_e( 'Show All', 'portfolio-designer-lite' ); ?>" value="<?php echo ( isset( $portfolio_setting['show_all_txt'] ) && '' != $portfolio_setting['show_all_txt'] ) ? esc_attr( $portfolio_setting['show_all_txt'] ) : ''; ?>" />
									<p>
										<b><?php esc_html_e( 'Note', 'portfolio-designer-lite' ); ?>: </b>
										<?php esc_html_e( 'If you will set blank then default text will be "Show All".', 'portfolio-designer-lite' ); ?>
									</p>
								</td>
							</tr>
						</table>

						<div class="section-seprator filter_data_tr"></div>
						<h3 class="portfolio-headding filter_data_tr port-typo-heading"><?php esc_html_e( 'Filter Typography', 'portfolio-designer' ); ?></h3>

						<table>
						<tr class="filter_data_tr">
								<td><label for="portfolio_meta_font_color"><?php esc_html_e( 'Select Filter Font Color', 'portfolio-designer-lite' ); ?></label></td>
								<td>
									<input id="portfolio_meta_font_color" name="portfolio_meta_font_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo isset( $portfolio_setting['meta_font_color'] ) ? esc_attr( $portfolio_setting['meta_font_color'] ) : '#000000'; ?>" />
								</td>
							</tr>
							<tr class="filter_data_tr">
								<td class='pro-feature'><label for="portfolio_meta_font"><?php esc_html_e( 'Select Filter Font Family', 'portfolio-designer-lite' ); ?></label></td>
								<td class='pro-feature'>
									<?php
									$meta_font      = isset( $portfolio_setting['meta_font'] ) ? $portfolio_setting['meta_font'] : '';
									$meta_font_type = isset( $portfolio_setting['meta_font_type'] ) ? $portfolio_setting['meta_font_type'] : '';
									?>
									<div class="select-cover">
										<input type="text" class="hidden" value="<?php echo esc_attr( $meta_font_type ); ?>" name="portfolio_meta_font_type" id="portfolio_meta_font_type" />
										<select id="portfolio_meta_font" name="">
											<option value=""><?php esc_html_e( 'Default', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr class="filter_data_tr">
								<td><label for="portfolio_meta_font_size"><?php esc_html_e( 'Select Filter Font Size', 'portfolio-designer-lite' ); ?></label></td>
								<td>
									<div class="font_size_cover">
										<div class="pull-left">
											<div class="grid_col_space range_slider_fontsize" id="portfolio_meta_font_size_slider" data-value="<?php echo ( isset( $portfolio_setting['meta_font_size'] ) && '' != $portfolio_setting['meta_font_size'] ) ? esc_attr( $portfolio_setting['meta_font_size'] ) : 12; ?>"></div>
										</div>
										<div class="pull-right">
											<div class="slide_val input-number-cover">
												<input id="portfolio_meta_font_size" name="portfolio_meta_font_size" type="number" class="numberOnly range-slider__value" value="<?php echo ( isset( $portfolio_setting['meta_font_size'] ) && '' != $portfolio_setting['meta_font_size'] ) ? esc_attr( $portfolio_setting['meta_font_size'] ) : 12; ?>" min="0"/>
											</div>
											<div class="select-cover font-size-cover pro-feature">
												<select id="portfolio_meta_font_unit" name="portfolio_meta_font_unit">
													<option value="px">px</option>
													<option value="em">em</option>
													<option value="%">%</option>
													<option value="cm">cm</option>
													<option value="ex">ex</option>
													<option value="mm">mm</option>
													<option value="in">in</option>
													<option value="pt">pt</option>
													<option value="pc">pc</option>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>

						<div>
							<div class="pdl-typography-cover pro-feature filter_data_tr">
								<div class="pdl-label"><label for="portfolio_meta_font_weight"><?php esc_html_e( 'Font Weight', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $meta_font_weight = ( isset( $portfolio_setting['meta_font_weight'] ) && '' != $portfolio_setting['meta_font_weight'] ) ? $portfolio_setting['meta_font_weight'] : 'normal'; ?>
									<select id="portfolio_meta_font_weight" name="">
										<option value="100" <?php echo ( '100' == $meta_font_weight ) ? 'selected="selected"' : ''; ?> >100</option>
										<option value="200" <?php echo ( '200' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>200</option>
										<option value="300" <?php echo ( '300' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>300</option>
										<option value="400" <?php echo ( '400' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>400</option>
										<option value="500" <?php echo ( '500' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>500</option>
										<option value="600" <?php echo ( '600' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>600</option>
										<option value="700" <?php echo ( '700' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>700</option>
										<option value="800" <?php echo ( '800' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>800</option>
										<option value="900" <?php echo ( '900' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>>900</option>
										<option value="bold" <?php echo ( 'bold' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Bold', 'portfolio-designer-lite' ); ?></option>
										<option value="normal" <?php echo ( 'normal' == $meta_font_weight ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Normal', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature filter_data_tr">
								<div class="pdl-label"><label for="portfolio_meta_font_text_transform"><?php esc_html_e( 'Text Transform', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $meta_font_text_transform = ( isset( $portfolio_setting['meta_font_text_transform'] ) && '' != $portfolio_setting['meta_font_text_transform'] ) ? $portfolio_setting['meta_font_text_transform'] : 'none'; ?>
									<select id="portfolio_meta_font_text_transform" name="">
										<option value="none" <?php echo ( 'none' == $meta_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'portfolio-designer-lite' ); ?></option>
										<option value="capitalize" <?php echo ( 'capitalize' == $meta_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Capitalize', 'portfolio-designer-lite' ); ?></option>
										<option value="uppercase" <?php echo ( 'uppercase' == $meta_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Uppercase', 'portfolio-designer-lite' ); ?></option>
										<option value="lowercase" <?php echo ( 'lowercase' == $meta_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Lowercase', 'portfolio-designer-lite' ); ?></option>
										<option value="full-width" <?php echo ( 'full-width' == $meta_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Full Width', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>							
							<div class="pdl-typography-cover pro-feature filter_data_tr">
								<div class="pdl-label"><label for="portfolio_meta_font_text_decoration"><?php esc_html_e( 'Text Decoration', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $meta_font_text_decoration = ( isset( $portfolio_setting['meta_font_text_decoration'] ) && '' != $portfolio_setting['meta_font_text_decoration'] ) ? $portfolio_setting['meta_font_text_decoration'] : 'none'; ?>
									<select id="portfolio_meta_font_text_decoration" name="">
										<option value="none" <?php echo ( 'none' == $meta_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'portfolio-designer-lite' ); ?></option>
										<option value="underline" <?php echo ( 'underline' == $meta_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Underline', 'portfolio-designer-lite' ); ?></option>
										<option value="overline" <?php echo ( 'overline' == $meta_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Overline', 'portfolio-designer-lite' ); ?></option>
										<option value="line-through" <?php echo ( 'line-through' == $meta_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Line Through', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature filter_data_tr">
								<div class="pdl-label"><label for="portfolio_meta_font_italic_style"><?php esc_html_e( 'Italic Style ', 'portfolio-designer-lite' ); ?></label></div>
								<input id="portfolio_meta_font_italic_style" name="" type="checkbox" value="1" <?php echo ( isset( $portfolio_setting['meta_font_italic_style'] ) && 1 == $portfolio_setting['meta_font_italic_style'] ) ? 'checked="checked"' : ''; ?>/>
							</div>
							<div class="pdl-typography-cover pro-feature filter_data_tr">
								<div class="pdl-label"><label for="portfolio_meta_font_line_height"><?php esc_html_e( 'Line Height', 'portfolio-designer-lite' ); ?></label></div>
								<div class="input-number-cover">
									<?php $meta_font_line_height = ( isset( $portfolio_setting['meta_font_line_height'] ) && '' != $portfolio_setting['meta_font_line_height'] ) ? $portfolio_setting['meta_font_line_height'] : 1.5; ?>
									<input id="portfolio_meta_font_line_height" name="" type="number" class="numberOnly" value="<?php echo esc_attr( $meta_font_line_height ); ?>" min="0" step="0.1" />
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature filter_data_tr">
								<div class="pdl-label"><label for="portfolio_meta_font_letter_spacing"><?php esc_html_e( 'Letter Spacing (px)', 'portfolio-designer-lite' ); ?></label></div>
								<div class="input-number-cover">
									<?php $meta_font_letter_spacing = ( isset( $portfolio_setting['meta_font_letter_spacing'] ) && '' != $portfolio_setting['meta_font_letter_spacing'] ) ? $portfolio_setting['meta_font_letter_spacing'] : 0; ?>
									<input id="portfolio_meta_font_letter_spacing" name="" type="number" class="numberOnly" value="<?php echo esc_attr( $meta_font_letter_spacing ); ?>" min="0"/>
								</div>
							</div>
						</div>

						<table>
							<tr class="filter_data_tr">
								<td>
									<label for="portfolio_filter_padding_top" class="porfolio-title">
										
										<?php esc_html_e( 'Filter Text Padding', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="filter_text_padding">
									<?php
									$portfolio_filter_padding_top    = ( isset( $portfolio_setting['portfolio_filter_padding_top'] ) && '' != $portfolio_setting['portfolio_filter_padding_top'] ) ? $portfolio_setting['portfolio_filter_padding_top'] : 5;
									$portfolio_filter_padding_right  = ( isset( $portfolio_setting['portfolio_filter_padding_right'] ) && '' != $portfolio_setting['portfolio_filter_padding_right'] ) ? $portfolio_setting['portfolio_filter_padding_right'] : 15;
									$portfolio_filter_padding_bottom = ( isset( $portfolio_setting['portfolio_filter_padding_bottom'] ) && '' != $portfolio_setting['portfolio_filter_padding_bottom'] ) ? $portfolio_setting['portfolio_filter_padding_bottom'] : 5;
									$portfolio_filter_padding_left   = ( isset( $portfolio_setting['portfolio_filter_padding_left'] ) && '' != $portfolio_setting['portfolio_filter_padding_left'] ) ? $portfolio_setting['portfolio_filter_padding_left'] : 15;
									?>
									<div class="input-number-cover pull-left input-number-text-box" style="width:22%;margin-right:2.666666667%">
										<label class="input-number-top-text">Top (px)</label>
										<input id="portfolio_filter_padding_top" name="portfolio_filter_padding_top" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Top', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_filter_padding_top ); ?>" min="0"/>
									</div>
									<div class="input-number-cover pull-left input-number-text-box" style="width:22%;margin-right:2.666666667%">
										<label class="input-number-top-text">Right (px)</label>
										<input id="portfolio_filter_padding_right" name="portfolio_filter_padding_right" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Right', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_filter_padding_right ); ?>" min="0"/>
									</div>
									<div class="input-number-cover pull-left input-number-text-box" style="width:22%;margin-right:2.666666667%">
										<label class="input-number-top-text">Bottom (px)</label>
										<input id="portfolio_filter_padding_bottom" name="portfolio_filter_padding_bottom" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Bottom', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_filter_padding_bottom ); ?>" min="0"/>
									</div>
									<div class="input-number-cover pull-left input-number-text-box" style="width:22%;">
										<label class="input-number-top-text">Left (px)</label>
										<input id="portfolio_filter_padding_left" name="portfolio_filter_padding_left" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Left', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_filter_padding_left ); ?>" min="0"/>
									</div>
								</td>
							</tr>
							<tr class="filter_data_tr">
								<td>
									<label for="portfolio_filter_border_width" class="porfolio-title">
										<?php esc_html_e( 'Filter Text Border', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="filter_text_border">
									<?php
									$portfolio_filter_border_width = ( isset( $portfolio_setting['portfolio_filter_border_width'] ) ) ? $portfolio_setting['portfolio_filter_border_width'] : 1;
									$portfolio_filter_border_style = ( isset( $portfolio_setting['portfolio_filter_border_style'] ) ) ? $portfolio_setting['portfolio_filter_border_style'] : 'solid';
									?>
									<div class="input-number-cover">
										<input id="portfolio_filter_border_width" name="portfolio_filter_border_width" type="number" class="numberOnly" value="<?php echo esc_attr( $portfolio_filter_border_width ); ?>" min="0"/>
									</div>
									<span>px</span>
									<div class="select-cover small-select">
										<select id="portfolio_filter_border_style" name="portfolio_filter_border_style" class="chosen-select">
											<option <?php selected( $portfolio_filter_border_style, 'none' ); ?> value="none"><?php esc_html_e( 'None', 'portfolio-designer' ); ?></option>
											<option <?php selected( $portfolio_filter_border_style, 'solid' ); ?> value="solid"><?php esc_html_e( 'Solid', 'portfolio-designer' ); ?></option>
											<option <?php selected( $portfolio_filter_border_style, 'dotted' ); ?> value="dotted"><?php esc_html_e( 'Dotted', 'portfolio-designer' ); ?></option>
											<option <?php selected( $portfolio_filter_border_style, 'dashed' ); ?> value="dashed"><?php esc_html_e( 'Dashed', 'portfolio-designer' ); ?></option>
											<option <?php selected( $portfolio_filter_border_style, 'double' ); ?> value="double"><?php esc_html_e( 'Double', 'portfolio-designer' ); ?></option>
										</select>
									</div>
									<div class="set-background">
										<input id="portfolio_filter_border_color" name="portfolio_filter_border_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['portfolio_filter_border_color'] ) ) ? esc_attr( $portfolio_setting['portfolio_filter_border_color'] ) : '#47cc8a'; ?>"/>
									</div>
								</td>
							</tr>
							<tr class="filter_data_tr">
								<td>
									<label for="portfolio_filter_text_back_color" class="porfolio-title">
										
										<?php esc_html_e( 'Filter Text Background Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<input id="portfolio_filter_text_back_color" name="portfolio_filter_text_back_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['portfolio_filter_text_back_color'] ) ) ? esc_attr( $portfolio_setting['portfolio_filter_text_back_color'] ) : '#fff'; ?>"/>
								</td>
							</tr>
						</table>
						
					</div>
				</div>
				<div id="portdesignpagination" 
				<?php
				if ( 'portdesignpagination' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table>
							<tr>
								<td>
									<label for="portfolio_enable_pagination"><?php esc_html_e( 'Enable Pagination?', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<label class="desc_checkbox">
										<input type="checkbox" id="portfolio_enable_pagination" name="portfolio_enable_pagination" value="1"  <?php echo ( isset( $portfolio_setting['enable_pagination'] ) && 1 == $portfolio_setting['enable_pagination'] ) ? 'checked="checked"' : ''; ?> />
									</label>
								</td>
							</tr>
							<tr class="portfolio_pagination_tr">
								<td class="pro-feature">
									<label for="portfolio_pagination_type"><?php esc_html_e( 'Pagination Type', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class="pro-feature">
									<?php $portfolio_pagination_type = ( isset( $portfolio_setting['pagination_type'] ) && '' != $portfolio_setting['pagination_type'] ) ? $portfolio_setting['pagination_type'] : 'pagination'; ?>
									<div class="select-cover">
										<select disable id="portfolio_pagination_type" name="">
											<option value="pagination" selected="selected"><?php esc_html_e( 'Pagination', 'portfolio-designer-lite' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr class="portfolio_pagination_tr">
								<td class="pro-feature">
									<label for="portfolio_pagination_type"><?php esc_html_e( 'Pagination Template', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class="pro-feature">
									<?php $portfolio_pagination_template = ( isset( $portfolio_setting['pagination_template'] ) && '' != $portfolio_setting['pagination_template'] ) ? $portfolio_setting['pagination_template'] : 'template-1'; ?>
									<div class="select-cover">
										<select id="portfolio_pagination_template" name="portfolio_pagination_template" class="chosen-select">
											<option value="template-1" <?php echo ( 'template-1' == $portfolio_pagination_template ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template-1', 'portfolio-designer' ); ?></option>
											<option value="template-2" <?php echo ( 'template-2' == $portfolio_pagination_template ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template-2', 'portfolio-designer' ); ?></option>
											<option value="template-3" <?php echo ( 'template-3' == $portfolio_pagination_template ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template-3', 'portfolio-designer' ); ?></option>
											<option value="template-4" <?php echo ( 'template-4' == $portfolio_pagination_template ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Template-4', 'portfolio-designer' ); ?></option>
										</select>
										<div class="portfolio-designer-setting-description portfolio-designer-setting-pagination">
											
										</div>
									</div>
								</td>
							</tr>

							<tr class="portfolio_pagination_tr pro-feature">
								<td>
									<label for="portfolio_pagination_text_color" class="porfolio-title">
										
										<?php esc_html_e( 'Select Pagination Text Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_text_color" name="portfolio_pagination_text_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_text_color'] ) && '' != $portfolio_setting['pagination_text_color'] ) ? esc_attr( $portfolio_setting['pagination_text_color'] ) : '#ffffff'; ?>"/>
								</td>
							</tr>
							<tr class=" portfolio_pagination_tr portfolio_pagination_design_tr pro-feature">
								<td>
									<label for="portfolio_pagination_background_color" class="porfolio-title">
										
										<?php esc_html_e( 'Select Pagination Background Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_background_color" name="portfolio_pagination_background_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_background_color'] ) && '' != $portfolio_setting['pagination_background_color'] ) ? esc_attr( $portfolio_setting['pagination_background_color'] ) : '#777777'; ?>"/>
								</td>
							</tr>
							<tr class=" portfolio_pagination_tr portfolio_pagination_design_tr pro-feature">
								<td>
									<label for="portfolio_pagination_text_hover_color" class="porfolio-title">
										
										<?php esc_html_e( 'Select Pagination Text Hover Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_text_hover_color" name="portfolio_pagination_text_hover_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_text_hover_color'] ) && '' != $portfolio_setting['pagination_text_hover_color'] ) ? esc_attr( $portfolio_setting['pagination_text_hover_color'] ) : '#777777'; ?>"/>
								</td>
							</tr>
							<tr class=" portfolio_pagination_tr portfolio_pagination_design_tr pro-feature">
								<td>
									<label for="portfolio_pagination_background_hover_color" class="porfolio-title">
										
										<?php esc_html_e( 'Select Pagination Background Hover Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_background_hover_color" name="portfolio_pagination_background_hover_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_background_hover_color'] ) && '' != $portfolio_setting['pagination_background_hover_color'] ) ? esc_attr( $portfolio_setting['pagination_background_hover_color'] ) : '#ffffff'; ?>"/>
								</td>
							</tr>


							<tr class="portfolio_pagination_tr portfolio_pagination_design_tr pro-feature pro-feature">
								<td>
									<label for="portfolio_pagination_active_text_color" class="porfolio-title">
										<?php esc_html_e( 'Select Pagination Active Text Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_active_text_color" name="portfolio_pagination_active_text_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_active_text_color'] ) && '' != $portfolio_setting['pagination_active_text_color'] ) ? esc_attr( $portfolio_setting['pagination_active_text_color'] ) : '#777777'; ?>"/>
								</td>
							</tr>
							<tr class="portfolio_pagination_tr portfolio_pagination_design_tr pro-feature pro-feature">
							<td>
									<label for="portfolio_pagination_active_background_color" class="porfolio-title">
										<?php esc_html_e( 'Select Pagination Active Background Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_active_background_color" name="portfolio_pagination_active_background_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_active_background_color'] ) && '' != $portfolio_setting['pagination_active_background_color'] ) ? esc_attr( $portfolio_setting['pagination_active_background_color'] ) : '#ffffff'; ?>"/>
								</td>
							</tr>
							<tr class="portfolio_pagination_tr portfolio_pagination_design_tr portfolio_border_color pro-feature">
							<td>
									<label for="portfolio_pagination_border_color" class="porfolio-title">
										<?php esc_html_e( 'Select Pagination Border Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
								<input id="portfolio_pagination_border_color" name="portfolio_pagination_border_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['pagination_border_color'] ) && '' != $portfolio_setting['pagination_border_color'] ) ? esc_attr( $portfolio_setting['pagination_border_color'] ) : '#b2b2b2'; ?>"/>
								</td>
							</tr>
						</table>
						
					</div>
				</div>
				<div id="pdlsocial" 
				<?php
				if ( 'pdlsocial' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">
						<table class="pdl-social-theme">
							<tbody>
								<tr class="keep-it-on">
									<td><label class="portfolio_enable_social_share_settings" ><?php esc_html_e( 'Social Share Links', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										if ( isset( $portfolio_setting['enable_social_share_settings'] ) ) {
											$portfolio_enable_social_share_settings = $portfolio_setting['enable_social_share_settings'];
										} else {
											$portfolio_enable_social_share_settings = 0;
										}
										?>
										<label><input type="checkbox" id="portfolio_enable_social_share_settings" name="portfolio_enable_social_share_settings" value="1"  <?php echo ( 1 == $portfolio_enable_social_share_settings ) ? 'checked' : ''; ?> />
											<?php esc_html_e( 'Enable Social Share Settings', 'portfolio-designer-lite' ); ?></label>
									</td>
								</tr>
								<tr>
									<td class="pro-feature"><label  class="portfolio_social_icon_display_position" ><?php esc_html_e( 'Social Icon Display Position', 'portfolio-designer-lite' ); ?></label></td>
									<td class="pro-feature">
										<?php
										$portfolio_social_icon_display_position = 1;
										if ( isset( $portfolio_setting['social_icon_display_position'] ) ) {
											$portfolio_social_icon_display_position = $portfolio_setting['social_icon_display_position'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_social_icon_display_position buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_social_icon_display_position_0" name="portfolio_social_icon_display_position" type="radio" value="0" <?php checked( 0, $portfolio_social_icon_display_position ); ?>/>
											<label for="portfolio_social_icon_display_position_0" <?php checked( 0, $portfolio_social_icon_display_position ); ?>><?php esc_html_e( 'Before Loop', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_social_icon_display_position_1" name="portfolio_social_icon_display_position" type="radio" value="1" <?php checked( 1, $portfolio_social_icon_display_position ); ?> />
											<label for="portfolio_social_icon_display_position_1" <?php checked( 1, $portfolio_social_icon_display_position ); ?>><?php esc_html_e( 'After Loop', 'portfolio-designer-lite' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr>
									<td><label class="portfolio_social_icon_alignment" ><?php esc_html_e( 'Select Social Icon Alignment', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										$portfolio_social_icon_alignment = 'bottom';
										if ( isset( $portfolio_setting['social_icon_alignment'] ) ) {
											$portfolio_social_icon_alignment = esc_attr( $portfolio_setting['social_icon_alignment'] );
										}
										?>
										<div class="typo-field">
											<div class="select-cover">
												<select name="portfolio_social_icon_alignment" id="portfolio_social_icon_alignment">
													<option value="left" <?php echo selected( 'left', $portfolio_social_icon_alignment ); ?>><?php esc_html_e( 'Left', 'portfolio-designer-lite' ); ?></option>
													<option value="center" <?php echo selected( 'center', $portfolio_social_icon_alignment ); ?>><?php esc_html_e( 'Center', 'portfolio-designer-lite' ); ?></option>
													<option value="right" <?php echo selected( 'right', $portfolio_social_icon_alignment ); ?>><?php esc_html_e( 'Right', 'portfolio-designer-lite' ); ?></option>
												</select>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="pro-feature"><label  class="portfolio_social_style" ><?php esc_html_e( 'Social Share Style', 'portfolio-designer-lite' ); ?></label></td>
									<td class="pro-feature">
										<?php
										$portfolio_social_style = 1;
										if ( isset( $portfolio_setting['social_style'] ) ) {
											$portfolio_social_style = $portfolio_setting['social_style'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_social_style buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_social_style_1" name="portfolio_social_style" type="radio" value="1"  />
											<label for="portfolio_social_style_1" ><?php esc_html_e( 'Default', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_social_style_0" name="portfolio_social_style" type="radio" value="0" <?php echo "checked='checked'"; ?>/>
											<label for="portfolio_social_style_0" <?php echo "checked='checked'"; ?>><?php esc_html_e( 'Custom', 'portfolio-designer-lite' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="social_share_theme_tr">
									<td class="pro-feature"><?php esc_html_e( 'Available Icon Themes', 'portfolio-designer-lite' ); ?></td>
									<td class="pro-feature social-share-td">
										<div class="social-share-theme">
											<?php for ( $i = 1; $i <= 10; $i++ ) { ?>
												<div class="social-cover social_share_theme_<?php echo esc_attr( $i ); ?>">
													<label>
														<input type="radio" id="default_icon_theme_<?php echo esc_attr( $i ); ?>" value="" name="default_icon_theme" />
														<span class="pdl-social-icons facebook-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons twitter-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons linkdin-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons pin-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons whatsup-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons telegram-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons pocket-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons mail-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons reddit-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons tumblr-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons skype-icon pdl_theme_wrapper"></span>
														<span class="pdl-social-icons wordpress-icon pdl_theme_wrapper"></span>
													</label>
												</div>
											<?php } ?>
										</div>
									</td>
								</tr>
								<tr class="portfolio-social-style-on">
									<td><label  class="portfolio_social_icon_style" ><?php esc_html_e( 'Shape of Social Icon', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										$portfolio_social_icon_style = 1;
										if ( isset( $portfolio_setting['social_icon_style'] ) ) {
											$portfolio_social_icon_style = $portfolio_setting['social_icon_style'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_social_icon_style buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_social_icon_style_1" name="portfolio_social_icon_style" type="radio" value="1" <?php checked( 1, $portfolio_social_icon_style ); ?> />
											<label for="portfolio_social_icon_style_1" <?php checked( 1, $portfolio_social_icon_style ); ?>><?php esc_html_e( 'Square', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_social_icon_style_0" name="portfolio_social_icon_style" type="radio" value="0" <?php checked( 0, $portfolio_social_icon_style ); ?>/>
											<label for="portfolio_social_icon_style_0" <?php checked( 0, $portfolio_social_icon_style ); ?>><?php esc_html_e( 'Circle', 'portfolio-designer-lite' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="portfolio-social-style-on">
									<td><label  class="portfolio_social_icon_size" ><?php esc_html_e( 'Size of Social Icon', 'portfolio-designer-lite' ); ?></td>
									<td>
										<?php
										$portfolio_social_icon_size = 1;
										if ( isset( $portfolio_setting['social_icon_size'] ) ) {
											$portfolio_social_icon_size = $portfolio_setting['social_icon_size'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_social_icon_size buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_social_icon_size_1" name="portfolio_social_icon_size" type="radio" value="1" <?php checked( 1, $portfolio_social_icon_size ); ?> />
											<label for="portfolio_social_icon_size_1" <?php checked( 1, $portfolio_social_icon_size ); ?>><?php esc_html_e( 'Small', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_social_icon_size_0" name="portfolio_social_icon_size" type="radio" value="0" <?php checked( 0, $portfolio_social_icon_size ); ?>/>
											<label for="portfolio_social_icon_size_0" <?php checked( 0, $portfolio_social_icon_size ); ?>><?php esc_html_e( 'Large', 'portfolio-designer-lite' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr>
									<td><label class="portfolio_facebook_link" ><?php esc_html_e( 'Show Facebook Share Link', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										$portfolio_facebook_link = 1;
										if ( isset( $portfolio_setting['facebook_link'] ) ) {
											$portfolio_facebook_link = $portfolio_setting['facebook_link'];
										}

										$portfolio_facebook_link_with_count = 1;
										if ( isset( $portfolio_setting['facebook_link_with_count'] ) ) {
											$portfolio_facebook_link_with_count = $portfolio_setting['facebook_link_with_count'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_facebook_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_facebook_link_1" name="portfolio_facebook_link" type="radio" value="1" <?php checked( 1, $portfolio_facebook_link ); ?> />
											<label for="portfolio_facebook_link_1" <?php checked( 1, $portfolio_facebook_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_facebook_link_0" name="portfolio_facebook_link" type="radio" value="0" <?php checked( 0, $portfolio_facebook_link ); ?>/>
											<label for="portfolio_facebook_link_0" <?php checked( 0, $portfolio_facebook_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer-lite' ); ?></label>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td><label class="portfolio_twitter_link" ><?php esc_html_e( 'Show Twitter Share Link', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										$portfolio_twitter_link = 1;
										if ( isset( $portfolio_setting['twitter_link'] ) ) {
											$portfolio_twitter_link = $portfolio_setting['twitter_link'];
										}
										?>
										<fieldset class="pdl-social-options portfolio_twitter_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_twitter_link_1" name="portfolio_twitter_link" type="radio" value="1" <?php checked( 1, $portfolio_twitter_link ); ?> />
											<label for="portfolio_twitter_link_1" <?php checked( 1, $portfolio_twitter_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_twitter_link_0" name="portfolio_twitter_link" type="radio" value="0" <?php checked( 0, $portfolio_twitter_link ); ?>/>
											<label for="portfolio_twitter_link_0" <?php checked( 0, $portfolio_twitter_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer-lite' ); ?></label>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td><label class="portfolio_linkedin_link" ><?php esc_html_e( 'Show Linkedin Share Link', 'portfolio-designer-lite' ); ?></td>
									<td>
										<?php
										$portfolio_linkedin_link = 1;
										if ( isset( $portfolio_setting['linkedin_link'] ) ) {
											$portfolio_linkedin_link = $portfolio_setting['linkedin_link'];
										}

										$portfolio_linkedin_link_with_count = 1;
										if ( isset( $portfolio_setting['linkedin_link_with_count'] ) ) {
											$portfolio_linkedin_link_with_count = $portfolio_setting['linkedin_link_with_count'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_linkedin_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_linkedin_link_1" name="portfolio_linkedin_link" type="radio" value="1" <?php checked( 1, $portfolio_linkedin_link ); ?> />
											<label for="portfolio_linkedin_link_1" <?php checked( 1, $portfolio_linkedin_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_linkedin_link_0" name="portfolio_linkedin_link" type="radio" value="0" <?php checked( 0, $portfolio_linkedin_link ); ?>/>
											<label for="portfolio_linkedin_link_0" <?php checked( 0, $portfolio_linkedin_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer-lite' ); ?></label>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td><label class="portfolio_pinterest_link" ><?php esc_html_e( 'Show Pinterest Share link', 'portfolio-designer-lite' ); ?></label></td>
									<td>
										<?php
										$portfolio_pinterest_link = 1;
										if ( isset( $portfolio_setting['pinterest_link'] ) ) {
											$portfolio_pinterest_link = $portfolio_setting['pinterest_link'];
										}

										$portfolio_pinterest_link_with_count = 1;
										if ( isset( $portfolio_setting['pinterest_link_with_count'] ) ) {
											$portfolio_pinterest_link_with_count = $portfolio_setting['pinterest_link_with_count'];
										}
										?>

										<fieldset class="pdl-social-options portfolio_pinterest_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_pinterest_link_1" name="portfolio_pinterest_link" type="radio" value="1" <?php checked( 1, $portfolio_pinterest_link ); ?> />
											<label for="portfolio_pinterest_link_1" <?php checked( 1, $portfolio_pinterest_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer-lite' ); ?></label>
											<input id="portfolio_pinterest_link_0" name="portfolio_pinterest_link" type="radio" value="0" <?php checked( 0, $portfolio_pinterest_link ); ?>/>
											<label for="portfolio_pinterest_link_0" <?php checked( 0, $portfolio_pinterest_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer-lite' ); ?></label>
										</fieldset>

										<label class="portfolio_pinterest_link_with_count pro-feature">
											<input id="portfolio_pinterest_link_with_count" name="portfolio_pinterest_link_with_count" type="checkbox" value="1" 
											<?php
											if ( 1 == $portfolio_pinterest_link_with_count && 1 == $portfolio_pinterest_link ) {
												echo '';
											}
											?>
											/> <?php esc_html_e( 'Hide Pinterest Share Count', 'portfolio-designer-lite' ); ?>
										</label>
									</td>
								</tr>


								<tr class=" pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_skype_link porfolio-title" >
											
											<?php esc_html_e( 'Show Skype Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_skype_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_skype_link'] ) ) {
											$portfolio_single_skype_link = $portfolio_setting['portfolio_single_skype_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_skype_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_skype_link_1" class="skype_link_1" name="portfolio_single_skype_link" type="radio" value="1" <?php checked( 1, $portfolio_single_skype_link ); ?> />
											<label for="portfolio_single_skype_link_1" <?php checked( 1, $portfolio_single_skype_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_skype_link_0" class="skype_link_0" name="portfolio_single_skype_link" type="radio" value="0" <?php checked( 0, $portfolio_single_skype_link ); ?>/>
											<label for="portfolio_single_skype_link_0" <?php checked( 0, $portfolio_single_skype_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_pocket_link porfolio-title" >
											
											<?php esc_html_e( 'Show Pocket Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_pocket_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_pocket_link'] ) ) {
											$portfolio_single_pocket_link = $portfolio_setting['portfolio_single_pocket_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_pocket_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_pocket_link_1" class="pocket_link_1" name="portfolio_single_pocket_link" type="radio" value="1" <?php checked( 1, $portfolio_single_pocket_link ); ?> />
											<label for="portfolio_single_pocket_link_1" <?php checked( 1, $portfolio_single_pocket_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_pocket_link_0" class="pocket_link_0" name="portfolio_single_pocket_link" type="radio" value="0" <?php checked( 0, $portfolio_single_pocket_link ); ?>/>
											<label for="portfolio_single_pocket_link_0" <?php checked( 0, $portfolio_single_pocket_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_telegram_link porfolio-title" >
											
											<?php esc_html_e( 'Show Telegram Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_telegram_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_telegram_link'] ) ) {
											$portfolio_single_telegram_link = $portfolio_setting['portfolio_single_telegram_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_telegram_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_telegram_link_1" class="telegram_link_1" name="portfolio_single_telegram_link" type="radio" value="1" <?php checked( 1, $portfolio_single_telegram_link ); ?> />
											<label for="portfolio_single_telegram_link_1" <?php checked( 1, $portfolio_single_telegram_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_telegram_link_0" class="telegram_link_0" name="portfolio_single_telegram_link" type="radio" value="0" <?php checked( 0, $portfolio_single_telegram_link ); ?>/>
											<label for="portfolio_single_telegram_link_0" <?php checked( 0, $portfolio_single_telegram_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_reddit_link porfolio-title" >
											
											<?php esc_html_e( 'Show Reddit Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_reddit_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_reddit_link'] ) ) {
											$portfolio_single_reddit_link = $portfolio_setting['portfolio_single_reddit_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_reddit_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_reddit_link_1" class="reddit_link_1" name="portfolio_single_reddit_link" type="radio" value="1" <?php checked( 1, $portfolio_single_reddit_link ); ?> />
											<label for="portfolio_single_reddit_link_1" <?php checked( 1, $portfolio_single_reddit_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_reddit_link_0" class="reddit_link_0" name="portfolio_single_reddit_link" type="radio" value="0" <?php checked( 0, $portfolio_single_reddit_link ); ?>/>
											<label for="portfolio_single_reddit_link_0" <?php checked( 0, $portfolio_single_reddit_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr >
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_digg_link porfolio-title" >
											
											<?php esc_html_e( 'Show Digg Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_digg_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_digg_link'] ) ) {
											$portfolio_single_digg_link = $portfolio_setting['portfolio_single_digg_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_digg_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_digg_link_1" class="digg_link_1" name="portfolio_single_digg_link" type="radio" value="1" <?php checked( 1, $portfolio_single_digg_link ); ?> />
											<label for="portfolio_single_digg_link_1" <?php checked( 1, $portfolio_single_digg_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_digg_link_0" class="digg_link_0" name="portfolio_single_digg_link" type="radio" value="0" <?php checked( 0, $portfolio_single_digg_link ); ?>/>
											<label for="portfolio_single_digg_link_0" <?php checked( 0, $portfolio_single_digg_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_tumblr_link porfolio-title" >
											
											<?php esc_html_e( 'Show Tumblr Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_tumblr_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_tumblr_link'] ) ) {
											$portfolio_single_tumblr_link = $portfolio_setting['portfolio_single_tumblr_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_tumblr_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_tumblr_link_1" class="tumblr_link_1" name="portfolio_single_tumblr_link" type="radio" value="1" <?php checked( 1, $portfolio_single_tumblr_link ); ?> />
											<label for="portfolio_single_tumblr_link_1" <?php checked( 1, $portfolio_single_tumblr_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_tumblr_link_0" class="tumblr_link_0" name="portfolio_single_tumblr_link" type="radio" value="0" <?php checked( 0, $portfolio_single_tumblr_link ); ?>/>
											<label for="portfolio_single_tumblr_link_0" <?php checked( 0, $portfolio_single_tumblr_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="portfolio_single_wordpress_link porfolio-title" >
											
											<?php esc_html_e( 'Show WordPress Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td>
										<?php
										$portfolio_single_wordpress_link = 0;
										if ( isset( $portfolio_setting['portfolio_single_wordpress_link'] ) ) {
											$portfolio_single_wordpress_link = $portfolio_setting['portfolio_single_wordpress_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_wordpress_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_wordpress_link_1" class="wordPress_link_1" name="portfolio_single_wordpress_link" type="radio" value="1" <?php checked( 1, $portfolio_single_wordpress_link ); ?> />
											<label for="portfolio_single_wordpress_link_1" <?php checked( 1, $portfolio_single_wordpress_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_wordpress_link_0" class="wordPress_link_0" name="portfolio_single_wordpress_link" type="radio" value="0" <?php checked( 0, $portfolio_single_wordpress_link ); ?>/>
											<label for="portfolio_single_wordpress_link_0" <?php checked( 0, $portfolio_single_wordpress_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>

								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="porfolio-title">
											
											<?php esc_html_e( 'Show WhatsApp Share Link', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td class="pd_label_design">
										<?php
										$portfolio_single_whatsapp_link = 'yes';
										if ( isset( $portfolio_setting['portfolio_single_whatsapp_link'] ) && '' != $portfolio_setting['portfolio_single_whatsapp_link'] ) {
											$portfolio_single_whatsapp_link = $portfolio_setting['portfolio_single_whatsapp_link'];
										}
										?>

										<fieldset class="portfolio-social-options portfolio_single_whatsapp_link buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_whatsapp_link_1" name="portfolio_single_whatsapp_link" type="radio" value="1" <?php checked( 1, $portfolio_single_whatsapp_link ); ?> />
											<label for="portfolio_single_whatsapp_link_1" <?php checked( 1, $portfolio_single_whatsapp_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_whatsapp_link_0" name="portfolio_single_whatsapp_link" type="radio" value="0" <?php checked( 0, $portfolio_single_whatsapp_link ); ?>/>
											<label for="portfolio_single_whatsapp_link_0" <?php checked( 0, $portfolio_single_whatsapp_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>
								<tr class="pro-feature portfolio_single_social_share_link">
									<td>
										<label class="porfolio-title">
											
											<?php esc_html_e( 'Show Share Via Mail', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td class="pd_label_design">
										<?php
										$portfolio_single_share_via_mail = 'yes';
										if ( isset( $portfolio_setting['portfolio_single_share_via_mail'] ) && '' != $portfolio_setting['portfolio_single_share_via_mail'] ) {
											$portfolio_single_share_via_mail = $portfolio_setting['portfolio_single_share_via_mail'];
										}
										?>
										<fieldset class="portfolio-social-options portfolio_single_share_via_mail buttonset buttonset-hide" data-hide='1'>
											<input id="portfolio_single_share_via_mail_1" class="share_via_mail_1" name="portfolio_single_share_via_mail" type="radio" value="1" <?php checked( 1, $portfolio_single_share_via_mail ); ?> />
											<label for="portfolio_single_share_via_mail_1" <?php checked( 1, $portfolio_single_share_via_mail ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
											<input id="portfolio_single_share_via_mail_0" class="share_via_mail_0" name="portfolio_single_share_via_mail" type="radio" value="0" <?php checked( 0, $portfolio_single_share_via_mail ); ?>/>
											<label for="portfolio_single_share_via_mail_0" <?php checked( 0, $portfolio_single_share_via_mail ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
										</fieldset>

									</td>
								</tr>

								

								<tr class="pro-feature portfolio_single_social_share_link count_position">
									<td>
										<label class="porfolio-title">
											
											<?php esc_html_e( 'Select Social Share Count Position', 'portfolio-designer' ); ?>
										</label>
									</td>
									<td class="pro-feature">
										<?php
										$social_count_position = 'bottom';
										if ( isset( $portfolio_setting['portfolio_single_social_count_position'] ) && '' != $portfolio_setting['portfolio_single_social_count_position'] ) {
											$social_count_position = $portfolio_setting['portfolio_single_social_count_position'];
										}
										?>
										<div class="select-cover">
											<select name="portfolio_single_social_count_position" id="social_sharecount" class="chosen-select">
												<option value="bottom" <?php echo selected( 'bottom', $social_count_position ); ?>><?php esc_html_e( 'Bottom', 'portfolio-designer' ); ?></option>
												<option value="right" <?php echo selected( 'right', $social_count_position ); ?>><?php esc_html_e( 'Right', 'portfolio-designer' ); ?></option>
												<option value="top" <?php echo selected( 'top', $social_count_position ); ?>><?php esc_html_e( 'Top', 'portfolio-designer' ); ?></option>
											</select>
										</div>
									</td>
								</tr>
							</tbody>
						</table>


					</div>
				</div>
				<div id="portdesignstyle" 
				<?php
				if ( 'portdesignstyle' == $current_tab ) {
					echo ' style="display: block;"';}
				?>
				class="postbox postbox-with-fw-options pdltab">
					<div class="inside">						
						<h3 class="portfolio-headding"><?php esc_html_e( 'Title Typography', 'portfolio-designer-lite' ); ?></h3>
						<table>

						

						<tr class="pro-feature">
								<td>
									<label for="portfolio_enable_pagination" class="porfolio-title">
										
										<?php esc_html_e( 'Display Title?', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<?php
									$portfolio_display_tittle_status = 1;
									if ( isset( $portfolio_setting['portfolio_display_tittle_status'] ) ) {
										$portfolio_display_tittle_status = ( 1 == $portfolio_setting['portfolio_display_tittle_status'] ) ? 1 : 0;
									}
									?>
									<fieldset class="portfolio-social-options portfolio_enable_pagination buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_display_tittle_status_1" class="portfolio_display_tittle_status_input" name="portfolio_display_tittle_status" type="radio" value="1" <?php checked( 1, $portfolio_display_tittle_status ); ?> />
										<label for="portfolio_display_tittle_status_1" <?php checked( 1, $portfolio_display_tittle_status ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_display_tittle_status_0" class="portfolio_display_tittle_status_input" name="portfolio_display_tittle_status" type="radio" value="0" <?php checked( 0, $portfolio_display_tittle_status ); ?>/>
										<label for="portfolio_display_tittle_status_0" <?php checked( 0, $portfolio_display_tittle_status ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr class="pro-feature portfolio_title_sub_input_tr">
								<td>
									<label for="portfolio_enable_title_link" class="porfolio-title">
										
										<?php esc_html_e( 'Enable Title Link?', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php
									$enable_title_link = 1;
									if ( isset( $portfolio_setting['enable_title_link'] ) ) {
										$enable_title_link = ( 1 == $portfolio_setting['enable_title_link'] ) ? 1 : 0;
									}
									?>
									<fieldset class="portfolio-social-options portfolio_enable_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_enable_title_link_1" name="portfolio_enable_title_link" type="radio" value="1" <?php checked( 1, $enable_title_link ); ?> />
										<label for="portfolio_enable_title_link_1" <?php checked( 1, $enable_title_link ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_enable_title_link_0" name="portfolio_enable_title_link" type="radio" value="0" <?php checked( 0, $enable_title_link ); ?>/>
										<label for="portfolio_enable_title_link_0" <?php checked( 0, $enable_title_link ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr class="pro-feature portfolio_title_sub_input_tr">
								<td>
									<label for="portfolio_enable_pagination" class="porfolio-title">
										
										<?php esc_html_e( 'Title HTML Tag?', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php $title_html_tag = ( isset( $portfolio_setting['title_html_tag'] ) && '' != $portfolio_setting['title_html_tag'] ) ? $portfolio_setting['title_html_tag'] : 'h4'; ?>
									<div class="select-cover">
									<select name="title_html_tag" id="title_html_tag" class="chosen-select">
											<option value="h1" <?php echo selected( 'h1', $title_html_tag ); ?>>h1</option>
											<option value="h2" <?php echo selected( 'h2', $title_html_tag ); ?> >h2</option>
											<option value="h3" <?php echo selected( 'h3', $title_html_tag ); ?> >h3</option>
											<option value="h4" <?php echo selected( 'h4', $title_html_tag ); ?>>h4</option>
											<option value="h5" <?php echo selected( 'h5', $title_html_tag ); ?>>h5</option>
											<option value="h6" <?php echo selected( 'h6', $title_html_tag ); ?> >h6</option>
											<option value="p" <?php echo selected( 'p', $title_html_tag ); ?>>p</option>
										</select>
									</div>
								</td>
							</tr>
							<tr class="pro-feature portfolio_title_sub_input_tr">
								<td>
									<label for="portfolio_enable_pagination" class="porfolio-title">
										
										<?php esc_html_e( 'Title Alignment', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php $title_alignment = ( isset( $portfolio_setting['title_alignment'] ) && '' != $portfolio_setting['title_alignment'] ) ? $portfolio_setting['title_alignment'] : 'center'; ?>
									<div class="select-cover">
									<select name="title_alignment" id="title_alignment" class="chosen-select">
											<option value="left" <?php echo selected( 'left', $title_alignment ); ?> ><?php esc_html_e( 'Left', 'portfolio-designer' ); ?></option>
											<option value="right"<?php echo selected( 'right', $title_alignment ); ?> ><?php esc_html_e( 'Right', 'portfolio-designer' ); ?></option>
											<option value="center" <?php echo selected( 'center', $title_alignment ); ?>><?php esc_html_e( 'Center', 'portfolio-designer' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
							<tr class="pro-feature portfolio_title_sub_input_tr port_title_bg">
								<td>
									<label for="portfolio_title_background_color" class="porfolio-title">
										
										<?php esc_html_e( 'Select Title Background Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<input id="portfolio_title_background_color" name="portfolio_title_background_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['title_background_color'] ) ) ? esc_attr( $portfolio_setting['title_background_color'] ) : ''; ?>"/>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php esc_html_e( 'Select Title Font Color', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<input id="portfolio_title_font_color" name="portfolio_title_font_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['title_font_color'] ) && '' != $portfolio_setting['title_font_color'] ) ? esc_attr( $portfolio_setting['title_font_color'] ) : ''; ?>"/>
								</td>
							</tr>
							<tr>
								<td class='pro-feature'>
									<label for="portfolio_title_font" class="porfolio-title">
										<?php esc_html_e( 'Select Title Font Family', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td class='pro-feature'>
									<?php
									$title_font      = isset( $portfolio_setting['title_font'] ) ? $portfolio_setting['title_font'] : '';
									$title_font_type = isset( $portfolio_setting['title_font_type'] ) ? $portfolio_setting['title_font_type'] : '';
									?>
									<div class="select-cover">
										<input type="text" class="hidden" value="<?php echo esc_attr( $title_font_type ); ?>" name="portfolio_title_font_type" id="portfolio_title_font_type"/>
										<select id="portfolio_title_font" name="portfolio_title_font">
											<option value="">
											<?php
												esc_html_e( 'Default', 'portfolio-designer-lite' );
											?>
											</option>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_title_font_size" class="porfolio-title">
										<?php esc_html_e( 'Select Title Font Size', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td>
									<div class="font_size_cover">
										<div class="pull-left">
											<div class="grid_col_space range_slider_fontsize" id="portfolio_title_font_size_slider" data-value="<?php echo ( isset( $portfolio_setting['title_font_size'] ) && '' != $portfolio_setting['title_font_size'] ) ? esc_attr( $portfolio_setting['title_font_size'] ) : 14; ?>"></div>
										</div>
										<div class="pull-right">
											<div class="slide_val input-number-cover">
												<input id="portfolio_title_font_size" name="portfolio_title_font_size" type="number" class="numberOnly range-slider__value" value="<?php echo ( isset( $portfolio_setting['title_font_size'] ) && '' != $portfolio_setting['title_font_size'] ) ? esc_attr( $portfolio_setting['title_font_size'] ) : 14; ?>" min="0"/>
											</div>
											<div class="select-cover font-size-cover pro-feature">
												<select id="portfolio_title_font_unit" name="portfolio_title_font_unit">
													<option value="px">px</option>
												</select>
											</div>
										</div>
									</div>
									<p><b><?php esc_html_e( 'Note: ', 'portfolio-designer-lite' ); ?></b><?php esc_html_e( 'If want to default font size set value ZERO.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>

							<tr class="post_tilte_max">
								<td>
									<label for="portfolio_post_tilte_max" class="porfolio-title">
										<?php esc_html_e( 'Post Title Maximun Line', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
									<?php
									$post_tilte_max = 1;
									if ( isset( $portfolio_setting['post_tilte_max'] ) ) {
										$post_tilte_max = ( 1 == $portfolio_setting['post_tilte_max'] ) ? 1 : 0;
									}


									?>
									<fieldset class="portfolio-social-options portfolio_enable_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_post_tilte_max_1" name="portfolio_post_tilte_max" type="radio" value="1" <?php checked( 1, $post_tilte_max ); ?> />
										<label for="portfolio_post_tilte_max_1" <?php checked( 1, $post_tilte_max ); ?>><?php esc_html_e( 'Yes', 'portfolio-designer' ); ?></label>
										<input id="portfolio_post_tilte_max_0" name="portfolio_post_tilte_max" type="radio" value="0" <?php checked( 0, $post_tilte_max ); ?>/>
										<label for="portfolio_post_tilte_max_0" <?php checked( 0, $post_tilte_max ); ?>><?php esc_html_e( 'No', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
						</tr>
						<tr class="layout_unique_post_tilte">
						<td>
									<label for="total_no_ofline"><?php esc_html_e( 'Dispaly Maximun Number of Line', 'portfolio-designer-lite' ); ?></label>
								</td>								
								<td>
									<div class="input-number-cover large-input">
										<input id="portfolio_column_space" name="total_no_ofline" class="numberOnly" type="number" value="<?php echo ( isset( $portfolio_setting['total_no_ofline'] ) && '' != $portfolio_setting['total_no_ofline'] ) ? esc_attr( $portfolio_setting['total_no_ofline'] ) : '2'; ?>" min="0" />
									</div>
									
									
								</td>
						</tr>
						<tr class="post_tilte_max_word">
								<td>
									<label for="portfolio_post_tilte_max_word" class="porfolio-title">
										<?php esc_html_e( 'Post Title Break Words', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td>
								<?php
									$portfolio_post_title_word_break = isset( $portfolio_setting['post_title_word_break'] ) ? $portfolio_setting['post_title_word_break'] : 'default';
								?>
									<fieldset class="portfolio-social-options portfolio_enable_filter buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_post_title_word_break_default" name="portfolio_post_title_word_break" type="radio" value="default" <?php checked( 'default', $portfolio_post_title_word_break ); ?>/>
										<label for="portfolio_post_title_word_break_default" <?php checked( 'default', $portfolio_post_title_word_break ); ?>><?php esc_html_e( 'Default', 'portfolio-designer' ); ?></label>
										<input id="portfolio_post_title_word_break_break-all" name="portfolio_post_title_word_break" type="radio" value="break-all" <?php checked( 'break-all', $portfolio_post_title_word_break ); ?> />
										<label for="portfolio_post_title_word_break_break-all" <?php checked( 'break-all', $portfolio_post_title_word_break ); ?>><?php esc_html_e( 'Break all', 'portfolio-designer' ); ?></label>
										<input id="portfolio_post_title_word_break_break-word" name="portfolio_post_title_word_break" type="radio" value="break-word" <?php checked( 'break-word', $portfolio_post_title_word_break ); ?>/>
										<label for="portfolio_post_title_word_break_break-word" <?php checked( 'break-word', $portfolio_post_title_word_break ); ?>><?php esc_html_e( 'Break word', 'portfolio-designer' ); ?></label>
									</fieldset>
								</td>
						</tr>

							<tr class="pro-feature portfolio_title_sub_input_tr">
								<td>
									<label  class="porfolio-title">
										
										<?php esc_html_e( 'Padding Title Section', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature filter_text_padding">
									<?php
									$portfolio_title_section_padding_top    = ( isset( $portfolio_setting['portfolio_title_section_padding_top'] ) && '' != $portfolio_setting['portfolio_title_section_padding_top'] ) ? $portfolio_setting['portfolio_title_section_padding_top'] : 10;
									$portfolio_title_section_padding_right  = ( isset( $portfolio_setting['portfolio_title_section_padding_right'] ) && '' != $portfolio_setting['portfolio_title_section_padding_right'] ) ? $portfolio_setting['portfolio_title_section_padding_right'] : 0;
									$portfolio_title_section_padding_bottom = ( isset( $portfolio_setting['portfolio_title_section_padding_bottom'] ) && '' != $portfolio_setting['portfolio_title_section_padding_bottom'] ) ? $portfolio_setting['portfolio_title_section_padding_bottom'] : 10;
									$portfolio_title_section_padding_left   = ( isset( $portfolio_setting['portfolio_title_section_padding_left'] ) && '' != $portfolio_setting['portfolio_title_section_padding_left'] ) ? $portfolio_setting['portfolio_title_section_padding_left'] : 0;
									?>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Top (px)</label>
										<input id="portfolio_title_section_padding_top" name="portfolio_title_section_padding_top" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Top', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_title_section_padding_top ); ?>" min="0"/>
									</div>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Right (px)</label>
										<input id="portfolio_title_section_padding_right" name="portfolio_title_section_padding_right" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Right', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_title_section_padding_right ); ?>" min="0"/>
									</div>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Bottom (px)</label>
										<input id="portfolio_title_section_padding_bottom" name="portfolio_title_section_padding_bottom" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Bottom', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_title_section_padding_bottom ); ?>" min="0"/>
									</div>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Left (px)</label>
										<input id="portfolio_title_section_padding_left" name="portfolio_title_section_padding_left" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Left', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_title_section_padding_left ); ?>" min="0"/>
									</div>
								</td>
							</tr>
							<tr class="pro-feature portfolio_title_sub_input_tr">
								<td>
									<label  class="porfolio-title">
										
										<?php esc_html_e( 'Margin Title Section', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature filter_text_padding">
									<?php
									$portfolio_title_section_margin_top    = ( isset( $portfolio_setting['portfolio_title_section_margin_top'] ) && '' != $portfolio_setting['portfolio_title_section_margin_top'] ) ? $portfolio_setting['portfolio_title_section_margin_top'] : 0;
									$portfolio_title_section_margin_bottom = ( isset( $portfolio_setting['portfolio_title_section_margin_bottom'] ) && '' != $portfolio_setting['portfolio_title_section_margin_bottom'] ) ? $portfolio_setting['portfolio_title_section_margin_bottom'] : 0;
									?>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Top (px)</label>
										<input id="portfolio_title_section_margin_top" name="portfolio_title_section_margin_top" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Top', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_title_section_margin_top ); ?>" min="0"/>
									</div>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Bottom (px)</label>
										<input id="portfolio_title_section_margin_bottom" name="portfolio_title_section_margin_bottom" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Bottom', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_title_section_margin_bottom ); ?>" min="0"/>
									</div>
								</td>
							</tr>
						</table>
						<div class="pdl-typography-wrapper">
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_title_font_weight"><?php esc_html_e( 'Font Weight', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $title_font_weight = ( isset( $portfolio_setting['title_font_weight'] ) && '' != $portfolio_setting['title_font_weight'] ) ? $portfolio_setting['title_font_weight'] : 'normal'; ?>
									<select id="portfolio_title_font_weight" name="">
										<option value="normal" <?php echo ( 'normal' == $title_font_weight ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Normal', 'portfolio-designer-lite' ); ?></option>
										<option value="100" <?php echo ( '100' == $title_font_weight ) ? 'selected="selected"' : ''; ?> >100</option>
										<option value="200" <?php echo ( '200' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>200</option>
										<option value="300" <?php echo ( '300' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>300</option>
										<option value="400" <?php echo ( '400' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>400</option>
										<option value="500" <?php echo ( '500' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>500</option>
										<option value="600" <?php echo ( '600' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>600</option>
										<option value="700" <?php echo ( '700' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>700</option>
										<option value="800" <?php echo ( '800' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>800</option>
										<option value="900" <?php echo ( '900' == $title_font_weight ) ? 'selected="selected"' : ''; ?>>900</option>
										<option value="bold" <?php echo ( 'bold' == $title_font_weight ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Bold', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_title_font_text_transform"><?php esc_html_e( 'Text Transform', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $title_font_text_transform = ( isset( $portfolio_setting['title_font_text_transform'] ) && '' != $portfolio_setting['title_font_text_transform'] ) ? $portfolio_setting['title_font_text_transform'] : 'none'; ?>
									<select id="portfolio_title_font_text_transform" name="">
										<option value="none" <?php echo ( 'none' == $title_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'portfolio-designer-lite' ); ?></option>
										<option value="capitalize" <?php echo ( 'capitalize' == $title_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Capitalize', 'portfolio-designer-lite' ); ?></option>
										<option value="uppercase" <?php echo ( 'uppercase' == $title_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Uppercase', 'portfolio-designer-lite' ); ?></option>
										<option value="lowercase" <?php echo ( 'lowercase' == $title_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Lowercase', 'portfolio-designer-lite' ); ?></option>
										<option value="full-width" <?php echo ( 'full-width' == $title_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Full Width', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>							
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_title_font_text_decoration"><?php esc_html_e( 'Text Decoration', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $title_font_text_decoration = ( isset( $portfolio_setting['title_font_text_decoration'] ) && '' != $portfolio_setting['title_font_text_decoration'] ) ? $portfolio_setting['title_font_text_decoration'] : 'none'; ?>
									<select id="portfolio_title_font_text_decoration" name="portfolio_title_font_text_decoration">
										<option value="none" <?php echo ( 'none' == $title_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'portfolio-designer-lite' ); ?></option>
										<option value="underline" <?php echo ( 'underline' == $title_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Underline', 'portfolio-designer-lite' ); ?></option>
										<option value="overline" <?php echo ( 'overline' == $title_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Overline', 'portfolio-designer-lite' ); ?></option>
										<option value="line-through" <?php echo ( 'line-through' == $title_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Line Through', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_title_font_italic_style"><?php esc_html_e( 'Italic Style ', 'portfolio-designer-lite' ); ?></label></div>
								<input id="portfolio_title_font_italic_style" name="portfolio_title_font_italic_style" type="checkbox" value="1" <?php echo ( isset( $portfolio_setting['title_font_italic_style'] ) && 1 == $portfolio_setting['title_font_italic_style'] ) ? 'checked="checked"' : ''; ?>/>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_title_font_line_height"><?php esc_html_e( 'Line Height', 'portfolio-designer-lite' ); ?></label></div>
								<div class="input-number-cover">
									<?php $title_font_line_height = ( isset( $portfolio_setting['title_font_line_height'] ) && '' != $portfolio_setting['title_font_line_height'] ) ? $portfolio_setting['title_font_line_height'] : 1.5; ?>
									<input id="portfolio_title_font_line_height" name="" type="number" class="numberOnly" value="<?php echo esc_attr( $title_font_line_height ); ?>" min="0" step="0.1"/>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_title_font_letter_spacing"><?php esc_html_e( 'Letter Spacing (px)', 'portfolio-designer-lite' ); ?></label></div>
								<div class="input-number-cover">
									<?php $title_font_letter_spacing = ( isset( $portfolio_setting['title_font_letter_spacing'] ) && '' != $portfolio_setting['title_font_letter_spacing'] ) ? $portfolio_setting['title_font_letter_spacing'] : 0; ?>
									<input id="portfolio_title_font_letter_spacing" name="" type="number" class="numberOnly" value="<?php echo intval( $title_font_letter_spacing ); ?>" min="0"/>
								</div>
							</div>
						</div>
						<div class="section-seprator"></div>
						<h3 class='portfolio-headding'><?php esc_html_e( 'Content Typography', 'portfolio-designer-lite' ); ?></h3>
						<table>
						<tr class="pro-feature">
								<td>
									<label for="portfolio_enable_pagination" class="porfolio-title">
										
										<?php esc_html_e( 'Content Alignment', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<?php $content_alignment = ( isset( $portfolio_setting['content_alignment'] ) && '' != $portfolio_setting['content_alignment'] ) ? $portfolio_setting['content_alignment'] : 'center'; ?>
									<div class="select-cover">
									<select name="content_alignment" id="content_alignment" class="chosen-select">
											<option value="left" <?php echo ( 'left' == $content_alignment ) ? 'selected="selected"' : ''; ?> ><?php esc_html_e( 'Left', 'portfolio-designer' ); ?></option>
											<option value="right" <?php echo ( 'right' == $content_alignment ) ? 'selected="selected"' : ''; ?> ><?php esc_html_e( 'Right', 'portfolio-designer' ); ?></option>
											<option value="center" <?php echo ( 'center' == $content_alignment ) ? 'selected="selected"' : ''; ?> ><?php esc_html_e( 'Center', 'portfolio-designer' ); ?></option>
										</select>
									</div>
								</td>
							</tr>
						<tr class="pro-feature">
								<td>
									<label for="portfolio_contents_background_color" class="porfolio-title">
										
										<?php esc_html_e( 'Select Content Background Color', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature">
									<input id="portfolio_contents_background_color" name="portfolio_contents_background_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['contents_background_color'] ) ) ? esc_attr( $portfolio_setting['contents_background_color'] ) : ''; ?>"/>
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_content_font_color"><?php esc_html_e( 'Select Content Font Color', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<input id="portfolio_content_font_color" name="portfolio_content_font_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['content_font_color'] ) && '' != $portfolio_setting['content_font_color'] ) ? esc_attr( $portfolio_setting['content_font_color'] ) : ''; ?>" />
								</td>
							</tr>
							<tr>
								<td class='pro-feature'>
									<label for="portfolio_content_font"><?php esc_html_e( 'Select Content Font Family', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class='pro-feature'>
									<?php
									$content_font      = isset( $portfolio_setting['content_font'] ) ? $portfolio_setting['content_font'] : '';
									$content_font_type = isset( $portfolio_setting['content_font_type'] ) ? $portfolio_setting['content_font_type'] : '';
									?>
									<div class="select-cover">
										<input type="text" class="hidden" value="<?php echo esc_attr( $content_font_type ); ?>" name="portfolio_content_font_type" id="portfolio_content_font_type"/>
										<select id="portfolio_content_font" name="">
											<option value="">
											<?php
												esc_html_e( 'Default', 'portfolio-designer-lite' );
											?>
												</option>
										</select>
									</div>
								</td>
							</tr>

							<tr class="pro-feature content_padding_section_tr">
								<td>
									<label for="portfolio_filter_padding_top" class="porfolio-title">
										
										<?php esc_html_e( 'Padding Content Section', 'portfolio-designer' ); ?>
									</label>
								</td>
								<td class="pro-feature filter_text_padding">
									<?php
									$portfolio_content_section_padding_top    = ( isset( $portfolio_setting['portfolio_content_section_padding_top'] ) && '' != $portfolio_setting['portfolio_content_section_padding_top'] ) ? $portfolio_setting['portfolio_content_section_padding_top'] : 10;
									$portfolio_content_section_padding_right  = ( isset( $portfolio_setting['portfolio_content_section_padding_right'] ) && '' != $portfolio_setting['portfolio_content_section_padding_right'] ) ? $portfolio_setting['portfolio_content_section_padding_right'] : 10;
									$portfolio_content_section_padding_bottom = ( isset( $portfolio_setting['portfolio_content_section_padding_bottom'] ) && '' != $portfolio_setting['portfolio_content_section_padding_bottom'] ) ? $portfolio_setting['portfolio_content_section_padding_bottom'] : 10;
									$portfolio_content_section_padding_left   = ( isset( $portfolio_setting['portfolio_content_section_padding_left'] ) && '' != $portfolio_setting['portfolio_content_section_padding_left'] ) ? $portfolio_setting['portfolio_content_section_padding_left'] : 10;
									?>
									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Top (px)</label>
										<input id="portfolio_content_section_padding_top" name="portfolio_content_section_padding_top" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Top', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_content_section_padding_top ); ?>" min="0"/>
									</div>

									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Right (px)</label>
										<input id="portfolio_content_section_padding_right" name="portfolio_content_section_padding_right" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Right', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_content_section_padding_right ); ?>" min="0"/>
									</div>

									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Bottom (px)</label>
										<input id="portfolio_content_section_padding_bottom" name="portfolio_content_section_padding_bottom" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Bottom', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_content_section_padding_bottom ); ?>" min="0"/>
									</div>

									<div class="input-number-cover input-number-text-box">
										<label class="input-number-top-text">Left (px)</label>
										<input id="portfolio_content_section_padding_left" name="portfolio_content_section_padding_left" type="number" class="numberOnly" placeholder="<?php esc_attr_e( 'Left', 'portfolio-designer' ); ?>" value="<?php echo esc_attr( $portfolio_content_section_padding_left ); ?>" min="0"/>
									</div>
									<!--<span class="input-number-px-text">px</span>-->
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_content_font_size">
										<?php esc_html_e( 'Select Content Font Size', 'portfolio-designer-lite' ); ?>
									</label>
								</td>
								<td>
									<div class="font_size_cover">
										<div class="pull-left">
											<div class="grid_col_space range_slider_fontsize" id="portfolio_content_font_size_slider" data-value="<?php echo ( isset( $portfolio_setting['content_font_size'] ) && '' != $portfolio_setting['content_font_size'] ) ? esc_attr( $portfolio_setting['content_font_size'] ) : 12; ?>"></div>
										</div>
										<div class="pull-right">
											<div class="slide_val input-number-cover">
												<input id="portfolio_content_font_size" name="portfolio_content_font_size" type="number" class="numberOnly range-slider__value" value="<?php echo ( isset( $portfolio_setting['content_font_size'] ) && '' != $portfolio_setting['content_font_size'] ) ? esc_attr( $portfolio_setting['content_font_size'] ) : 12; ?>" min="0"/>
											</div>
											<div class="select-cover font-size-cover pro-feature">
												<select id="portfolio_content_font_unit" name="portfolio_content_font_unit">
													<option value="px">px</option>
													<option value="em">em</option>
													<option value="%">%</option>
													<option value="cm">cm</option>
													<option value="ex">ex</option>
													<option value="mm">mm</option>
													<option value="in">in</option>
													<option value="pt">pt</option>
													<option value="pc">pc</option>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
						<div class="pdl-typography-wrapper">
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_content_font_weight"><?php esc_html_e( 'Font Weight', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $content_font_weight = ( isset( $portfolio_setting['content_font_weight'] ) && '' != $portfolio_setting['content_font_weight'] ) ? $portfolio_setting['content_font_weight'] : 'normal'; ?>
									<select id="portfolio_content_font_weight" name="">
										<option value="100" <?php echo ( '100' == $content_font_weight ) ? 'selected="selected"' : ''; ?> >100</option>
										<option value="200" <?php echo ( '200' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>200</option>
										<option value="300" <?php echo ( '300' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>300</option>
										<option value="400" <?php echo ( '400' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>400</option>
										<option value="500" <?php echo ( '500' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>500</option>
										<option value="600" <?php echo ( '600' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>600</option>
										<option value="700" <?php echo ( '700' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>700</option>
										<option value="800" <?php echo ( '800' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>800</option>
										<option value="900" <?php echo ( '900' == $content_font_weight ) ? 'selected="selected"' : ''; ?>>900</option>
										<option value="bold" <?php echo ( 'bold' == $content_font_weight ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Bold', 'portfolio-designer-lite' ); ?></option>
										<option value="normal" <?php echo ( 'normal' == $content_font_weight ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Normal', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_content_font_text_transform"><?php esc_html_e( 'Text Transform', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $content_font_text_transform = ( isset( $portfolio_setting['content_font_text_transform'] ) && '' != $portfolio_setting['content_font_text_transform'] ) ? $portfolio_setting['content_font_text_transform'] : 'none'; ?>
									<select id="portfolio_content_font_text_transform" name="portfolio_content_font_text_transform">
										<option value="none" <?php echo ( 'none' == $content_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'portfolio-designer-lite' ); ?></option>
										<option value="capitalize" <?php echo ( 'capitalize' == $content_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Capitalize', 'portfolio-designer-lite' ); ?></option>
										<option value="uppercase" <?php echo ( 'uppercase' == $content_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Uppercase', 'portfolio-designer-lite' ); ?></option>
										<option value="lowercase" <?php echo ( 'lowercase' == $content_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Lowercase', 'portfolio-designer-lite' ); ?></option>
										<option value="full-width" <?php echo ( 'full-width' == $content_font_text_transform ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Full Width', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>							
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"> <label for="portfolio_content_font_text_decoration"><?php esc_html_e( 'Text Decoration', 'portfolio-designer-lite' ); ?></label></div>
								<div class="select-cover">
									<?php $content_font_text_decoration = ( isset( $portfolio_setting['content_font_text_decoration'] ) && '' != $portfolio_setting['content_font_text_decoration'] ) ? $portfolio_setting['content_font_text_decoration'] : 'none'; ?>
									<select id="portfolio_content_font_text_decoration" name="">
										<option value="none" <?php echo ( 'none' == $content_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'None', 'portfolio-designer-lite' ); ?></option>
										<option value="underline" <?php echo ( 'underline' == $content_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Underline', 'portfolio-designer-lite' ); ?></option>
										<option value="overline" <?php echo ( 'overline' == $content_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Overline', 'portfolio-designer-lite' ); ?></option>
										<option value="line-through" <?php echo ( 'line-through' == $title_font_text_decoration ) ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Line Through', 'portfolio-designer-lite' ); ?></option>
									</select>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_content_font_italic_style"><?php esc_html_e( 'Italic Style ', 'portfolio-designer-lite' ); ?></label></div>
								<div class="">
									<input id="portfolio_content_font_italic_style" name="" type="checkbox" value="1" <?php echo ( isset( $portfolio_setting['content_font_italic_style'] ) && 1 == $portfolio_setting['content_font_italic_style'] ) ? 'checked="checked"' : ''; ?>/>
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_content_font_line_height"><?php esc_html_e( 'Line Height', 'portfolio-designer-lite' ); ?></label></div>
								<div class="input-number-cover">
									<?php $content_font_line_height = ( isset( $portfolio_setting['content_font_line_height'] ) && '' != $portfolio_setting['content_font_line_height'] ) ? $portfolio_setting['content_font_line_height'] : 1.5; ?>
									<input id="portfolio_content_font_line_height" name="" type="number" class="numberOnly" value="<?php echo esc_attr( $content_font_line_height ); ?>" min="0" step="0.1" />
								</div>
							</div>
							<div class="pdl-typography-cover pro-feature">
								<div class="pdl-label"><label for="portfolio_content_font_letter_spacing"><?php esc_html_e( 'Letter Spacing (px)', 'portfolio-designer-lite' ); ?></label></div>
								<div class="input-number-cover">
									<?php $content_font_letter_spacing = ( isset( $portfolio_setting['content_font_letter_spacing'] ) && '' != $portfolio_setting['content_font_letter_spacing'] ) ? $portfolio_setting['content_font_letter_spacing'] : 0; ?>
									<input id="portfolio_content_font_letter_spacing" name="" type="number" class="numberOnly" value="<?php echo esc_attr( $content_font_letter_spacing ); ?>" min="0"/>
								</div>
							</div>
						</div>
						<div class="section-seprator"></div>
						<h3 class='pdl-headding'><?php esc_html_e( 'Content background Typography', 'portfolio-designer-lite' ); ?></h3>
						<table>
							<tr class="content_background_color_tr">
								<td>
									<label for="content_background_color"><?php esc_html_e( 'Content Background Color', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<input id="content_background_color" name="content_background_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['content_background_color'] ) && '' != $portfolio_setting['content_background_color'] ) ? esc_attr( $portfolio_setting['content_background_color'] ) : ''; ?>" />
								</td>
							</tr>
							<tr>
								<td class="pro-feature">
									<label for="portfolio_overlay_background_color"><?php esc_html_e( 'Image Hover Background Color', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class="pro-feature">
									<input id="portfolio_overlay_background_color" name="portfolio_overlay_background_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['overlay_background_color'] ) && '' != $portfolio_setting['overlay_background_color'] ) ? esc_attr( $portfolio_setting['overlay_background_color'] ) : ''; ?>" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_custom_css"><?php esc_html_e( 'Custom CSS', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<?php $custom_css = ( isset( $portfolio_setting['custom_css'] ) && '' != $portfolio_setting['custom_css'] ) ? $portfolio_setting['custom_css'] : ''; ?>
									<textarea class="widefat textarea" name="portfolio_custom_css" id="portfolio_custom_css" placeholder=".class_name{ color:#ffffff }"><?php echo esc_textarea( wp_unslash( $custom_css ) ); ?></textarea>
								</td>
							</tr>
						</table>
						
						
						<div class="section-seprator"></div>
						<h3 class='pdl-headding pdl_button_title'><?php esc_html_e( 'Button Typography', 'portfolio-designer-lite' ); ?></h3>
						<table class="pdl_button_table">
							<tr>
								<td class='pro-feature'>
									<label for="portfolio_button_font"><?php esc_html_e( 'Button Font Family', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class='pro-feature'>
									<?php
									$button_font      = isset( $portfolio_setting['button_font'] ) ? $portfolio_setting['button_font'] : '';
									$button_font_type = isset( $portfolio_setting['button_font_type'] ) ? $portfolio_setting['button_font_type'] : '';
									?>
									<div class="select-cover">
										<input type="text" class="hidden" value="<?php echo esc_attr( $button_font_type ); ?>" name="portfolio_button_font_type" id="portfolio_button_font_type" />
										<select id="portfolio_button_font" name="">
											<option value="">
											<?php
												esc_html_e( 'Default', 'portfolio-designer-lite' );
											?>
												</option>
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<td class="pro-feature">
									<label for="portfolio_button_font_size"><?php esc_html_e( 'Button Font Size', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class="pro-feature">
									<div class="font_size_cover">
										<div class="pull-left">
											<div class="grid_col_space range_slider_fontsize" id="portfolio_button_font_size_slider" data-value="<?php echo ( isset( $portfolio_setting['button_font_size'] ) && '' != $portfolio_setting['button_font_size'] ) ? esc_attr( $portfolio_setting['button_font_size'] ) : 0; ?>"></div>
										</div>
										<div class="pull-right">
											<div class="slide_val input-number-cover">
												<input id="portfolio_button_font_size" name="" type="number" class="numberOnly range-slider__value" value="<?php echo ( isset( $portfolio_setting['button_font_size'] ) && '' != $portfolio_setting['button_font_size'] ) ? esc_attr( $portfolio_setting['button_font_size'] ) : 0; ?>" min="0"/>
											</div>
											<div class="select-cover font-size-cover">
												<select id="portfolio_button_font_unit" name="portfolio_button_font_unit">
													<option value="px">px</option>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td class='pro-feature'>
									<label for="portfolio_button_type"><?php esc_html_e( 'Button Type', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class='pro-feature'>
									<?php
									$button_type = 'rectangle';
									?>
									<fieldset class="pdl-social-options portfolio_button_type buttonset buttonset-hide" data-hide='1'>
										<input id="portfolio_button_type_0" name="portfolio_button_type" type="radio" value="rectangle" <?php checked( 'rectangle', $button_type ); ?>/>
										<label for="portfolio_button_type_0" <?php checked( 0, $button_type ); ?>><?php esc_html_e( 'Rectangle', 'portfolio-designer-lite' ); ?></label>
										<input id="portfolio_button_type_1" name="portfolio_button_type" type="radio" value="oval" <?php checked( 'oval', $button_type ); ?> />
										<label for="portfolio_button_type_1" <?php checked( 1, $button_type ); ?>><?php esc_html_e( 'Oval', 'portfolio-designer-lite' ); ?></label>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td class='pro-feature'>
									<label for="portfolio_button_radius"><?php esc_html_e( 'Button Radius', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class='pro-feature'>
									<div class="font_size_cover">
										<div class="pull-left">
											<div class="grid_col_space range_slider_fontsize" id="portfolio_button_radius_slider" data-value="<?php echo ( isset( $portfolio_setting['button_radius'] ) && '' != $portfolio_setting['button_radius'] ) ? esc_attr( $portfolio_setting['button_radius'] ) : 40; ?>"></div>
										</div>
										<div class="pull-right">
											<div class="slide_val input-number-cover">
												<input id="portfolio_button_radius" name="" type="number" class="numberOnly range-slider__value" value="<?php echo ( isset( $portfolio_setting['button_radius'] ) && '' != $portfolio_setting['button_radius'] ) ? esc_attr( $portfolio_setting['button_radius'] ) : 40; ?>" min="0"/>
											</div>
											<div class="select-cover font-size-cover">
												<select id="portfolio_button_radius_unit" name="portfolio_button_radius_unit">
													<option value="px">px</option>
													<option value="%">%</option>
												</select>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<label for="portfolio_button_font_color"><?php esc_html_e( 'Button Icon Color', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td>
									<input id="portfolio_button_font_color" name="portfolio_button_font_color" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['button_font_color'] ) && '' != $portfolio_setting['button_font_color'] ) ? esc_attr( $portfolio_setting['button_font_color'] ) : ''; ?>" />
									<p><?php esc_html_e( 'This color used for example button icon color.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
							<tr>
								<td class="pro-feature">
									<label for="portfolio_button_background_color"><?php esc_html_e( 'Button Background Color', 'portfolio-designer-lite' ); ?></label>
								</td>
								<td class="pro-feature">
									<input id="portfolio_button_background_color" name="" type="text" data-alpha="true" class="portfolio-color-picker color-picker" value="<?php echo ( isset( $portfolio_setting['button_background_color'] ) && '' != $portfolio_setting['button_background_color'] ) ? esc_attr( $portfolio_setting['button_background_color'] ) : '#000000'; ?>" />
									<p><?php esc_html_e( 'This color used for example button icon background color.', 'portfolio-designer-lite' ); ?></p>
								</td>
							</tr>
						</table>						
					</div>
				</div>
			</div>
		</div>
		<?php
		wp_nonce_field( '_wp_portfolio_designer_action', '_wp_portfolio_designer_nonce' );
		?>
		<input type="submit" class="hide"  name="addPortfolioDesigner" id="addPortfolioDesigner" />

	</form>
	<div id="pdl-advertisement-popup" style="display:none">
		<div class="portfolio-advertisement-cover">
			<a class="portfolio-advertisement-link" target="_blank" href="<?php echo esc_url( 'https://www.solwininfotech.com/product/wordpress-plugins/portfolio-designer/' ); ?>">
				<img src="<?php echo esc_url( PORT_LITE_PLUGIN_URL ) . '/images/portfolio_advertisement_popup.png'; ?>" />
			</a>
		</div>
	</div>
</div>
