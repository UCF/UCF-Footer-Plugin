<?php
/*
Plugin Name: UCF Footer
Description: Adds a UCF-branded footer to UCF sites.
Github Plugin URI: UCF/UCF-Footer-Plugin
Version: 1.0.9
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'UCF_FOOTER__PLUGIN_FILE', __FILE__ );

require_once 'includes/ucf-footer-config.php';
require_once 'includes/ucf-footer-feed.php';
require_once 'includes/ucf-footer-common.php';


/**
 * Activation/deactivation hooks
 **/
if ( !function_exists( 'ucf_footer_plugin_activation' ) ) {
	function ucf_footer_plugin_activation() {
		return UCF_Footer_Config::add_options();
	}
}

if ( !function_exists( 'ucf_footer_plugin_deactivation' ) ) {
	function ucf_footer_plugin_deactivation() {
		return;
	}
}

register_activation_hook( UCF_FOOTER__PLUGIN_FILE, 'ucf_footer_plugin_activation' );
register_deactivation_hook( UCF_FOOTER__PLUGIN_FILE, 'ucf_footer_plugin_deactivation' );
