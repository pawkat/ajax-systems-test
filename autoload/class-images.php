<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

class Images
{


    protected static $image_sizes = [];


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

    /**
     * Fields constructor.
     */
    function __construct()
    {

        add_filter('image_size_names_choose', __CLASS__.'::add_custom_image_sizes');

        add_action('after_setup_theme', __CLASS__.'::register_custom_image_sizes');

        add_filter('upload_mimes', __CLASS__.'::add_mime_types', 1, 1);

        add_filter('wp_get_attachment_image_attributes', __CLASS__.'::replace_src_with_data_aload', 50);

    }


    public static function register_custom_image_sizes()
    {

        if (! empty(self::$image_sizes)) {

            foreach (self::$image_sizes as $size) {
                add_image_size("{$size}px", $size, $size);
            }

        }

    }


    /**
     * @param $sizes
     * @return array
     */
    public static function add_custom_image_sizes($sizes)
    {

        if (self::$image_sizes) {

            foreach (self::$image_sizes as $size) {
                $sizes["{$size}px"] = "{$size}x{$size}px";
            }

        }

        return $sizes;
    }


    /**
     * @param $mime_types
     * @return mixed
     */
    public static function add_mime_types($mime_types)
    {
        $mime_types['svg'] = 'image/svg+xml';

        return $mime_types;
    }

    /**
     * @param $attr
     * @return mixed
     * @todo include data-aload
     */
    public static function replace_src_with_data_aload($attr)
    {
        $dont_use_aload = array_key_exists('dont_use_aload', $attr) && $attr['dont_use_aload'];
        if (! is_admin() && ! $dont_use_aload) {
            $attr['data-aload'] = $attr['src'];
            $attr['src']        = self::get_placeholder_image();

            if (isset($attr['srcset']) && $attr['srcset']) {
                $attr['data-aload-srcset'] = $attr['srcset'];
                $attr['srcset']            = self::get_placeholder_image();
            }
        }

        return $attr;
    }


    public static function get_placeholder_image()
    {
        return 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
    }

    public static function aload_attrs($src, $bg = false)
    {
        if (is_admin() || wp_doing_ajax()) {
            if (! $bg) {
                echo "src=\"{$src}\"";
            } else {
                echo "style=\"background-image: url({$src})\"";
            }
        } else {
            $placeholder = self::get_placeholder_image();
            echo "data-aload=\"{$src}\"";
            if (! $bg) {
                echo " src=\"{$placeholder}\"";
            }
        }
    }


}


