<?php

/*
Plugin Name: WordPress: Auto Ancestor
Description: Auto-select ancestor terms/categories on save and quick edit
Version: 0.0.1
Author: We Are Indi
Author URI: https://weareindi.co.uk
*/

// register autoloader
require_once(__DIR__ . '/autoload.php');

if (!function_exists('is_plugin_active')) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// register app classes
use WordPressAutoAncestor\Core\Plugin;
use WordPressAutoAncestor\Core\Edit;

// register WP plugin functions/tools
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

// register definitions used throughout plugin
define('WORDPRESSAUTOANCESTOR_NAME', 'WordPress Auto Ancestor');
define('WORDPRESSAUTOANCESTOR_SHORTNAME', 'AutoAncestor');
define('WORDPRESSAUTOANCESTOR_SLUG', 'wordpressautoancestor');
define('WORDPRESSAUTOANCESTOR_DIR', __DIR__ . '/');
define('WORDPRESSAUTOANCESTOR_BASENAME', basename(WORDPRESSAUTOANCESTOR_DIR) . '/index.php');
define('WORDPRESSAUTOANCESTOR_PATH', WORDPRESSAUTOANCESTOR_DIR . 'index.php');
define('WORDPRESSAUTOANCESTOR_URL', plugin_dir_url(__FILE__));
define('WORDPRESSAUTOANCESTOR_PHP', '7.4');

// Are we in the admin area?
if (is_admin()) {
    Plugin::activation();
}

// Is plugin active
if (Plugin::active()) {
    // global plugin functions here...
}

// Is the plugin active and IN the admin area?
if (Plugin::active() && is_admin()) {
    // admin functions here...
    Edit::Register();
}

// Is the plugin active and NOT IN the admin area?
if (Plugin::active() && !is_admin()) {
    // non-admin functons here...
}