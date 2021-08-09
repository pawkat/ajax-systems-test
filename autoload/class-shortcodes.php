<?php
/**
 * Main class which sets all together
 *
 * @since      1.0.0
 */

namespace AjaxSystems;

class Shortcodes
{

    protected static $instance = null;

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
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


    public function __construct()
    {

        add_shortcode('hero', __CLASS__.'::hero');
        add_shortcode('slider', __CLASS__.'::slider');

    }

    /**
     * @param $atts
     * @return string
     */
    public static function hero($atts)
    {
        return Utility::get_tpl('template-parts/hero', $atts);
    }

    /**
     * @param $atts
     * @return string
     */
    public static function slider($atts)
    {
        return Utility::get_tpl('template-parts/slider', $atts);
    }


}
