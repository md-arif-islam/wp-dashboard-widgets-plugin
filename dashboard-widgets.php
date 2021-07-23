<?php
/*
Plugin Name: Demo Dashboard Widgets
Plugin URI:
Description:
Version: 1.0
Author: Arif Islam
Author URI: arifislam.techviewing.com
License: GPLv2 or later
Text Domain: ddw
Domain Path: /languages/
*/

function ddw_load_textdomain() {
	load_plugin_textdomain( 'ddw', false, plugin_dir_url( __FILE__ ) . '/languages' );
}

add_action( 'plugin_loaded', 'ddw_load_textdomain' );


function ddw_dashboard_setup() {
	if ( current_user_can( 'edit_dashboard' ) ) {
		wp_add_dashboard_widget( 'ddw1', 'Dashboard Widgets 1', 'ddw1_output', 'ddw1_output_configure' );
	} else {
		wp_add_dashboard_widget( 'ddw1', 'Dashboard Widgets 1', 'ddw1_output' );
	}
}

add_action( 'wp_dashboard_setup', 'ddw_dashboard_setup' );

function ddw1_output() {
	$nmbr_of_posts = get_option( 'ddw1_numbr_of_post' );
	$feed          = array(
		array(
			'url'          => 'https://arifislam.techviewing.com/blog/',
			'items'        => $nmbr_of_posts,
			'show_summary' => 1,
			'show_author'  => 1,
			'show_date'    => 1,
		)
	);

	wp_dashboard_primary_output( 'ddw1', $feed );

}

function ddw1_output_configure() {
	$nmbr_of_posts = get_option( 'ddw1_numbr_of_post', 5 );
	if ( isset( $_POST['dashboard-widget-nonce'] ) && wp_verify_nonce( $_POST['dashboard-widget-nonce'], 'edit-dashboard-widget_ddw1' ) ) {
		if ( isset( $_POST['ddw1_numbr_of_post'] ) && $_POST['ddw1_numbr_of_post'] > 0 ) {
			$nmbr_of_posts = sanitize_text_field( $_POST['ddw1_numbr_of_post'] );
			update_option( 'ddw1_numbr_of_post', $nmbr_of_posts );
		}
	}
	?>
    <p>
        <label for="ddw1-url">Dashboard Feed URL</label>
        <input type="text" class="widefat" name="ddw1_numbr_of_post" id="ddw1_numbr_of_post"
               value="<?php echo $nmbr_of_posts; ?>">
    </p>
	<?php
}