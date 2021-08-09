<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

class DeferJS
{

    protected static $assets = [];

    protected static $enqueued_assets = [];

    /**
     * TT_Admin constructor.
     */
    function __construct()
    {
        add_action('init', __CLASS__.'::register_components');
        add_action('wp_footer', __CLASS__.'::enqueue_components');
    }

    public static function register_components()
    {
        self::register([
            'src'                      => '/assets/js/components/order-form.min.js?ver='.PLUGIN_VERSION,
            'handle'                   => 'order-form',
            'elSelector'               => '.js-order-form',
            'loadImmediatelyIfVisible' => false,
            'dependencies'             => []
        ], 'order-form');

        self::register([
            'src'                      => '/assets/js/components/slider.min.js?ver='.PLUGIN_VERSION,
            'handle'                   => 'slider',
            'elSelector'               => '.js-slider',
            'dependencies'             => []
        ], 'slider');

        do_action('js/register');
    }

    public static function enqueue_components()
    {

    }

    /**
     * Assets passed in the array below will be registered for further including
     * @param $data
     * @param string $handle
     */
    public static function register($data, $handle = '')
    {
        if (! array_key_exists($handle, static::$assets)) {
            static::$assets[$handle] = $data;
        }
    }

    /**
     * Assets passed in the array below will be registered for further including
     * @param string $handle
     */
    public static function enqueue($handle = '')
    {
        if (! array_key_exists($handle, static::$enqueued_assets) && array_key_exists($handle, static::$assets)) {
            static::$enqueued_assets[$handle] = static::$assets[$handle];
        }
    }

    public static function get_enqueued_scripts()
    {
        return static::$enqueued_assets;
    }
}


