<?php
/**
 * @link https://wp-kama.ru/handbook/theme/customize-api
 */

namespace AjaxSystems;

class Customizer
{

    /**
     * Fields constructor.
     */
    function __construct()
    {

        // @example
        // add_action( 'customize_register', __CLASS__ . '::register' );

    }

    /**
     * @param \WP_Customize_Manager $wp_customiz
     * @link https://wp-kama.ru/handbook/theme/customize-api
     */
    public static function register( \WP_Customize_Manager $wp_customize ) {
        // Здесь делаем что-либо с $wp_customize - объектом класса WP_Customize_Manager, например

        // panel actions
        $wp_customize->add_panel();
        $wp_customize->get_panel();
        $wp_customize->remove_panel();

        // section actions
        $wp_customize->add_section();
        $wp_customize->get_section();
        $wp_customize->remove_section();

        // setting action
        $wp_customize->add_setting();
        $wp_customize->get_setting();
        $wp_customize->remove_setting();

        // elemments actions
        $wp_customize->add_control();
        $wp_customize->get_control();
        $wp_customize->remove_control();
    }

    /**
     * @var null
     */
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
}


