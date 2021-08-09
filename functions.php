<?php
/**
 * Main Functions file
 */

namespace AjaxSystems;


// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Core constants
 */

define(__NAMESPACE__.'\PREFIX', 'ajax_systems');

define(__NAMESPACE__.'\PLUGIN_VERSION', wp_get_theme()->get('Version'));

define(__NAMESPACE__.'\PLUGIN_NAME', 'Ajax Systems');

define(__NAMESPACE__.'\PLUGIN_SHORTNAME', 'ajax');

define(__NAMESPACE__.'\TEXT_DOMAIN', 'ajax-systems');

define(__NAMESPACE__.'\PLUGIN_DIR', get_stylesheet_directory());

define(__NAMESPACE__.'\PLUGIN_URL', get_stylesheet_directory_uri());

define(__NAMESPACE__.'\ERROR_PATH', get_stylesheet_directory().'/error.log');

/**
 * Init
 */

if (! class_exists(__NAMESPACE__.'\Core')) {
    include_once PLUGIN_DIR.'/includes/class-core.php';
}

/**
 * On theme activation hook
 */

add_action('after_setup_theme', __NAMESPACE__.'\Core::on_activation');

/**
 * Load translation, make sure this hook runs before all, so we set priority to 1
 */

add_action('init', function () {
    load_theme_textdomain(__NAMESPACE__.'\TEXT_DOMAIN', PLUGIN_DIR.'/languages');
}, 1);
