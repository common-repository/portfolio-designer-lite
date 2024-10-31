<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Portfolio Designer Lite
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$settings = get_option( 'portfolio_designer_lite_settings' );
if ( ! empty( $settings ) ) {
	$setting = maybe_unserialize( get_option( 'portfolio_designer_lite_settings' ) );

	if ( ! empty( $setting ) ) {
		foreach ( $setting as $key => $value ) {
			$key                       = str_replace( 'portfolio_', '', $key );
			$portfolio_setting[ $key ] = $value;
		}
	} else {
		$portfolio_setting = array();
	}
	$delete_plugins_data = ( isset( $portfolio_setting['delete_plugins_data'] ) && '' != $portfolio_setting['delete_plugins_data'] ) ? esc_attr( $portfolio_setting['delete_plugins_data'] ) : 0;

	if ( 1 == $delete_plugins_data ) {
		delete_option( 'pdl_is_optin' );
		$myplugin_cpt_args  = array(
			'post_type'      => 'sol_portfolio',
			'posts_per_page' => -1,
		);
		$myplugin_cpt_posts = get_posts( $myplugin_cpt_args );
		foreach ( $myplugin_cpt_posts as $post_data ) {
			wp_delete_post( $post_data->ID, false );
		}
		delete_option( 'portfolio_designer_lite_settings' );
	}
}

