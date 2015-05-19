<?php

/* FOR SCRIPT CONTROL */

add_action( 'admin_enqueue_scripts', 'iprm_load_backend_scripts' );
add_action( 'wp_enqueue_scripts', 'iprm_load_frontend_scripts' );

function iprm_load_backend_scripts() {
	wp_enqueue_style( 'iprm-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css' );
}
function iprm_load_frontend_scripts() {
	global $post;
	if( has_shortcode( $post->post_content, 'iprm' ) ) {
		wp_enqueue_style( 'iprm-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css' );
	}
}