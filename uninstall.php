<?php

/**
 * Uninstall Plugin Name Plugin.
 *
 * If uninstall is not called from WordPress, then exit.
 * This file ensures that the plugin data is removed upon uninstallation.
 *
 * @package plugin\name
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

