<?php

/* FOR SCRIPT CONTROL */

add_action( 'admin_enqueue_scripts', 'iprm_load_scripts' );

function iprm_load_scripts() {
	wp_enqueue_style( 'iprm-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css' );
}