<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

class DeferCSS extends Defer
{

    protected static $assets = [];

    protected static $enqueued_assets = [];

    /**
     * TT_Admin constructor.
     */
    function __construct()
    {
        parent::__construct();

        add_action('init', __CLASS__.'::register');
        add_action('wp_head', __CLASS__.'::enqueue_components');
    }

    /**
     * Assets passed in the array below will be registered for further including
     */
    public static function register()
    {
        static::$assets = apply_filters('css/register', [
            'hero'   => '/assets/css/components/hero.min.css',
            'logos'  => '/assets/css/components/logos.min.css',
            'form'   => '/assets/css/components/form.min.css',
            'swiper' => '/assets/css/lib/swiper.min.css',
            'slider' => '/assets/css/components/slider.min.css',
        ]);
    }

    public static function enqueue_components()
    {

    }

    /**
     * @param $name
     * @param string $type
     * @return string
     */
    protected static function enqueue_singular($name, $type = '__echo')
    {
        if (! array_key_exists($name, static::$assets)) {
            return;
        }
        if (static::is_enqueued($name)) {
            static::$enqueued_assets[$name] = [
                'path'        => static::$assets[$name],
                'type'        => $type,
                'is_inserted' => false,
            ];

            if ($type === '__echo') :
                echo '<style data-style="'.$name.'">'.static::get_content($name).'</style>';
            endif;

            if ($type === 'return') :
                return '<style data-style="'.$name.'">'.static::get_content($name).'</style>';
            endif;

        }

        return '';
    }
}


