<?php
/**
 * Handles uninstallation logic.
 **/
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}


require_once 'includes/ucf-footer-config.php';

// Delete options
UCF_Footer_Config::delete_options();
