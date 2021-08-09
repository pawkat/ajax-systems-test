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

    /**
     * Get attachment image HTML.
     *
     * Retrieve the attachment image HTML code.
     *
     * Note that some widgets use the same key for the media control that allows
     * the image selection and for the image size control that allows the user
     * to select the image size, in this case the third parameter should be null
     * or the same as the second parameter. But when the widget uses different
     * keys for the media control and the image size control, when calling this
     * method you should pass the keys.
     *
     * @param array $settings Control settings.
     * @param string $image_size_key Optional. Settings key for image size.
     *                               Default is `image`.
     * @param string $image_key Optional. Settings key for image. Default
     *                               is null. If not defined uses image size key
     *                               as the image key.
     *
     * @return string Image HTML.
     * @since 1.0.0
     * @access public
     * @static
     *
     */
    public static function get_attachment_image_html($settings, $image_size_key = 'image', $image_key = null)
    {
        $dont_use_aload = array_key_exists('dont_use_aload', $settings) && $settings['dont_use_aload'] === 'yes';
        if (! $image_key) {
            $image_key = $image_size_key;
        }

        $image = $settings[$image_key];

        // Old version of image settings.
        if (! isset($settings[$image_size_key.'_size'])) {
            $settings[$image_size_key.'_size'] = '';
        }

        $size = $settings[$image_size_key.'_size'];

        $image_class = ! empty($settings['hover_animation']) ? 'elementor-animation-'.$settings['hover_animation'] : '';

        $html = '';

        // If is the new version - with image size.
        $image_sizes = get_intermediate_image_sizes();

        $image_sizes[] = 'full';

        if (! empty($image['id']) && ! wp_attachment_is_image($image['id'])) {
            $image['id'] = '';
        }

        $is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();

        // On static mode don't use WP responsive images.
        if (! empty($image['id']) && in_array($size, $image_sizes) && ! $is_static_render_mode) {
            $image_class .= " attachment-$size size-$size";
            $image_attr  = [
                'class'          => trim($image_class),
                'dont_use_aload' => $dont_use_aload
            ];

            $html .= wp_get_attachment_image($image['id'], $size, false, $image_attr);
        } else {
            $image_src = Group_Control_Image_Size::get_attachment_image_src($image['id'], $image_size_key, $settings);
            if (! $image_src && isset($image['url'])) {
                $image_src = $image['url'];
            }

            if (! empty($image_src)) {
                $image_class_html = ! empty($image_class) ? ' class="'.$image_class.'"' : '';

                $html .= sprintf('<img src="%s" title="%s" alt="%s"%s />', esc_attr($image_src),
                    Control_Media::get_image_title($image), Control_Media::get_image_alt($image), $image_class_html);
            }
        }

        /**
         * Get Attachment Image HTML
         *
         * Filters the Attachment Image HTML
         *
         * @param string $html the attachment image HTML string
         * @param array $settings Control settings.
         * @param string $image_size_key Optional. Settings key for image size.
         *                               Default is `image`.
         * @param string $image_key Optional. Settings key for image. Default
         *                               is null. If not defined uses image size key
         *                               as the image key.
         * @since 2.4.0
         */
        return apply_filters('elementor/image_size/get_attachment_image_html', $html, $settings, $image_size_key,
            $image_key);
    }

    public static function aload_attrs($src, $bg = false)
    {
        if (\Elementor\Plugin::$instance->editor->is_edit_mode() || wp_doing_ajax()) {
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


