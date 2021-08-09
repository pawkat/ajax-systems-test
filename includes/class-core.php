<?php
/**
 * Main class which sets all together
 *
 * @since      1.0.0
 */

namespace AjaxSystems;

class Core
{

    protected static $instance = null;

    /**
     * @throws \Exception
     * @since 1.0.0
     */
    public function __construct()
    {

        //autoload files from `/autoload`
        spl_autoload_register(__CLASS__.'::autoload');

        $dependency_plugins = [];

        // check plugin dependencies
        if (! self::has_dependency($dependency_plugins)) {
            return;
        }

        Assets::instance();

        Images::instance();

        Shortcodes::instance();

//        Customizer::instance();

        new DeferCSS();

        new DeferJS();

        if (wp_doing_ajax()) {
            AJAX::instance();
        }

    }

    /**
     * Check whether the required dependencies are met
     * also can show a notice message
     *
     * @param array $plugins - an array with `path => name` of the plugin
     * @param boolean $show_msg
     * @return boolean
     * @since 1.0.0
     */
    private static function has_dependency($plugins = array(), $show_msg = true)
    {

        if (empty($plugins)) {
            return true;
        }

        $valid          = true;
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));

        if (is_multisite()) {

            if (is_network_admin()) {

                $active_plugins          = [];
                $active_sitewide_plugins = get_site_option('active_sitewide_plugins');

                foreach ($active_sitewide_plugins as $path => $item) {
                    $active_plugins[] = $path;
                }

            } else {

                $active_plugins = get_blog_option(get_current_blog_id(), 'active_plugins');
            }
        }

        foreach ($plugins as $path => $name) {

            if (! in_array($path, $active_plugins)) {

                if ($show_msg) {
                    Utility::show_notice(sprintf(
                        __('%s theme requires %s plugin to be installed and active.', TEXT_DOMAIN),
                        '<b>'.PLUGIN_NAME.'</b>',
                        "<b>{$name}</b>"
                    ), 'error');
                }

                $valid = false;
            }
        }

        return $valid;

    }

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     * @throws \Exception
     * @since     1.0.0
     *
     */
    public static function instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function autoload()
    {

        $dir   = PLUGIN_DIR.'/autoload/class-*.php';
        $paths = glob($dir);
//
//        if (defined('GLOB_BRACE')) {
//            $paths = glob('{'.$dir.'}', GLOB_BRACE);
//        }

        if (is_array($paths) && count($paths) > 0) {
            foreach ($paths as $file) {
                if (file_exists($file)) {
                    include_once $file;
                }
            }
        }
    }

    /**
     * Run on plugin activation
     *
     * @return void
     * @since 1.0.0
     */
    public static function on_activation()
    {

        if (version_compare(phpversion(), '7.0', '<')) {
            Utility::show_notice(sprintf(
                __('Hey! Your server must have at least PHP 7.0. Could you please upgrade. %sGo back%s', TEXT_DOMAIN),
                '<a href="'.admin_url('themes.php').'">',
                '</a>'
            ), 'error');
        }

        if (version_compare(get_bloginfo('version'), '5.5', '<')) {
            Utility::show_notice(sprintf(
                __('We need at least Wordpress 5.5. Could you please upgrade. %sGo back%s', TEXT_DOMAIN),
                '<a href="'.admin_url('themes.php').'">',
                '</a>'
            ), 'error');
        }
    }


}

Core::instance();
