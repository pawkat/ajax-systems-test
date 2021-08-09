<?php
/**
 * Enqueue assets.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

class Assets
{

    const CSS_PATH = '/assets/css/app.min.css';
    const JS_PATH  = '/assets/js/app.min.js';

    const JS_SCRIPT_NAME = 'app-js';
    const CSS_SHEET_NAME = 'app-css';

    const CSS_FRONT_PATH = '/assets/css/frontend.min.css';
    const JS_FRONT_PATH  = '/assets/js/frontend.min.js';

    const CSS_ADMIN_PATH = '/assets/css/admin.min.css';
    const JS_ADMIN_PATH  = '/assets/js/admin.min.js';

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


    function __construct()
    {

        /**
         * Deregister the scripts because they will be bundled into a single file
         */
        add_action('wp', __CLASS__ . '::deregister_assets');

        /**
         * Add a button to the WP panel so it's possible to rebundle the assets
         */
        add_action('init', __CLASS__.'::refresh_assets');
        add_action('admin_bar_menu', __CLASS__.'::admin_bar_menu', 500);

        /**
         * Iterate theme version
         */
        add_action('after_setup_theme', __CLASS__.'::check_theme_version');

        /**
         * Enqueue js and css assets
         */
        add_action('wp_enqueue_scripts', __CLASS__.'::enqueue_assets', 999);

        /**
         * Assign the js variables
         */
        add_action('wp_enqueue_scripts', __CLASS__.'::enqueue_js_variables', 999);

        /**
         * Enqueue the assets on admin panel end
         */
        // add_action('admin_enqueue_scripts', __CLASS__ . '::enqueue_admin_assets');

        /**
         * Make the scrripts to be loaded through defer
         */
//        add_filter('script_loader_tag', __CLASS__ . '::add_async_attribute', 10, 2);

        /**
         * Make the scrripts to be loaded through defer
         */
        add_filter('wp_footer', __CLASS__.'::set_to_footer_the_scripts_to_enqueue', 1000);

        /**
         * Get rid of no needed assets from header
         */

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', __CLASS__.'::disable_emojis_tinymce');
        add_filter('wp_resource_hints', __CLASS__.'::disable_emojis_remove_dns_prefetch', 10, 2);

    }

    public static function set_to_footer_the_scripts_to_enqueue()
    {
        $json = json_encode(DeferJS::get_enqueued_scripts());

        echo "<script type='text/javascript'>var scripts_to_enqueue=$json</script>";
    }

    /**
     * Deregister the scripts because we have them bundled in app.min.js
     */
    public static function deregister_assets()
    {
        if (! is_admin() && ! current_user_can('edit_posts')) {
            wp_deregister_script('jquery');
            wp_deregister_script('jquery-migrate');
            wp_deregister_script('wp-embed');
        }
    }

    public static function refresh_assets()
    {

        if (isset($_GET['refresh_assets_bundles'])) :
            self::create_assets_bundles();

            Utility::show_notice(__('Assets have been successfully refreshed!', TEXT_DOMAIN), 'success');
        endif;

    }

    public static function check_theme_version()
    {

        $current_version = wp_get_theme()->get('Version');
        $old_version     = get_option('theme_version');

        if ($old_version !== $current_version) {

            self::create_assets_bundles();

            // update not to run twice
            update_option('theme_version', $current_version);
        }
    }

    public static function is_bundled_assets()
    {
        return ! current_user_can('edit_posts');
    }

    public static function enqueue_assets()
    {
        /**
         * Include assets separately
         */
        if (! self::is_bundled_assets()) :

            /**
             * Enqueue CSS
             */
            self::enqueue_styles();

            /**
             * Enqueue JavaScript
             */
            self::enqueue_scripts();


        else :
            $css_path = get_template_directory().self::CSS_PATH;
            $js_path  = get_template_directory().self::JS_PATH;

            $css_inline = file_exists($css_path) ? file_get_contents($css_path) : '';

            if ($css_inline) :
                wp_dequeue_style('wp-block-library');
                add_action('wp_head', function () use ($css_inline) {
                    echo "<style>$css_inline</style>";
                }, 999);
            else :
                self::enqueue_styles();
            endif;

            if (file_exists($js_path)) :
                $version = wp_get_theme()->get('Version').'.bundle-v.'.(int)get_option('theme_bundle_version', 0);

                wp_enqueue_script(
                    self::JS_SCRIPT_NAME,
                    get_template_directory_uri().self::JS_PATH,
                    array(),
                    $version,
                    true
                );
            else :
                self::enqueue_scripts();
            endif;
        endif;
    }

    public static function enqueue_admin_assets()
    {

        wp_enqueue_style(
            PREFIX,
            PLUGIN_URL.self::CSS_ADMIN_PATH,
            array(),
            PLUGIN_VERSION
        );

        wp_enqueue_script(
            PREFIX,
            PLUGIN_URL.self::JS_ADMIN_PATH,
            array('jquery'),
            PLUGIN_VERSION,
            true
        );

    }

    public static function create_assets_bundles()
    {

        /**
         * Get the arrays of asset files
         */
        $styles  = self::include_css_libraries();
        $scripts = self::include_js_libraries();

        /**
         * Bundle the assets so they are saved
         * to self::CSS_PATH and self::JS_PATH files
         */
        self::update_js_bundle($scripts);
        self::update_css_bundle($styles);

        /**
         * Refresh theme's version
         */

        $old_bundle_version = (int)get_option('theme_bundle_version', 0);

        if ($old_bundle_version > 10000) {
            $old_bundle_version = 0;
        }

        update_option('theme_bundle_version', $old_bundle_version + 1);
    }

    /**
     * @param $tag
     * @param $handle
     * @return string|string[]
     */
    public static function add_async_attribute($tag, $handle)
    {
        if (! in_array($handle, [self::JS_SCRIPT_NAME])) {
            return $tag;
        }

        return str_replace(' src', ' defer src', $tag);
    }

    public static function enqueue_js_variables()
    {

        wp_localize_script(self::JS_SCRIPT_NAME, PREFIX, array(
            'ajax_url'       => admin_url('admin-ajax.php'),
            'nonce'          => wp_create_nonce(PREFIX),
            'post_id'        => get_the_ID(),
            'theme_path'     => PLUGIN_URL,
            'theme_version'  => PLUGIN_VERSION,
        ));

    }

    /**
     * @param $plugins
     * @return array
     */
    public static function disable_emojis_tinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    }

    /**
     * @param $urls
     * @param $relation_type
     * @return array
     */
    public static function disable_emojis_remove_dns_prefetch($urls, $relation_type)
    {
        if ('dns-prefetch' == $relation_type) {
            /** This filter is documented in wp-includes/formatting.php */
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

            $urls = array_diff($urls, array($emoji_svg_url));
        }

        return $urls;
    }


    /**
     * Adds refesh assets bundles button
     *
     * @param object $wp_admin_bar
     * @since 0.9
     *
     */
    public static function admin_bar_menu($wp_admin_bar)
    {
        $item = (object)array(
            'slug' => 'all',
            'name' => __('Refresh assets bundles', TEXT_DOMAIN),
        );

        $title = sprintf(
            '<span class="ab-label"><span class="screen-reader-text">%1$s</span>%2$s</span>',
            $item->name,
            esc_html($item->name)
        );

        $wp_admin_bar->add_menu(
            array(
                'id'    => 'refresh_assets_bundles',
                'title' => $title,
                'href'  => esc_url(add_query_arg('refresh_assets_bundles', 1, remove_query_arg('paged'))),
                'meta'  => array('title' => $item->name),
            )
        );
    }

    /**
     * @param $str
     * @return bool
     */
    private static function is_url($str)
    {
        return (bool)(explode('://', $str)[0] === 'https' || explode('://', $str)[0] === 'http');
    }

    private static function enqueue_styles()
    {
        $version = wp_get_theme()->get('Version');
        $styles  = self::include_css_libraries();

        foreach ($styles as $name => $path) :
            if (explode('/', $path)[0] === 'wp-includes') :
                wp_enqueue_style($name, site_url()."/$path", array(), $version);
            elseif (self::is_url($path)) :
                wp_enqueue_style($name, $path, array(), null);
            else :
                wp_enqueue_style($name, get_template_directory_uri()."/$path", array(), $version);
            endif;
        endforeach;
    }

    private static function enqueue_scripts()
    {
        $version = wp_get_theme()->get('Version');
        $scripts = self::include_js_libraries();

        foreach ($scripts as $name => $path) :
            if (explode('/', $path)[0] === 'wp-includes') :
                wp_enqueue_script($name, site_url()."/$path", array(), $version, true);
            elseif (self::is_url($path)) :
                wp_enqueue_script($name, $path, array(), null, true);
            else :
                wp_enqueue_script($name, get_template_directory_uri()."/$path", array(), $version, true);
            endif;
        endforeach;
    }

    /**
     * @param string $sources
     * @param string $name
     * @param array $conditional
     * @return mixed|string
     */
    private static function handle_conditionals($sources = '', $name = '', $conditional = [])
    {
        if (array_key_exists($name, $conditional)) :
            if (is_array($conditional[$name])) :
                foreach ($conditional[$name] as $function) :
                    $sources = call_user_func_array($function['name'], [
                        $function['attributes'][0],
                        $function['attributes'][1],
                        $sources
                    ]);
                endforeach;
            else :
                $sources = call_user_func_array($conditional[$name]['name'], [
                    $conditional[$name]['attributes'][0],
                    $conditional[$name]['attributes'][1],
                    $sources
                ]);
            endif;
        endif;

        return $sources;
    }

    /**
     * @param array $assets
     * @param array $conditional
     * @return string
     */
    private static function concat_assets($assets = array(), $conditional = [])
    {
        $content = '';

        foreach ($assets as $name => $path) :
            if (explode('/', $path)[0] === 'wp-includes') :
                $path = realpath(WP_CONTENT_DIR.'/..')."/$path";

                $content .= file_get_contents($path);
            elseif (explode('/', $path)[0] === 'wp-content') :
                $path = ABSPATH.$path;

                $content .= file_get_contents($path);
            elseif (self::is_url($path)) :
                $content .= self::handle_conditionals(file_get_contents($path), $name, $conditional);
            else :
                $path = get_template_directory()."/$path";

                if ($path && file_exists($path)) :
                    $content .= self::handle_conditionals(file_get_contents($path), $name, $conditional);
                endif;
            endif;
        endforeach;

        return $content;
    }

    /**
     * @param array $scripts
     */
    private static function update_js_bundle($scripts = [])
    {
        $assets_dir = get_template_directory().self::JS_PATH;
        $js_content = self::concat_assets($scripts);

        $file = fopen($assets_dir, 'w+');
        fwrite($file, $js_content);
        fclose($file);
    }

    /**
     * @param array $styles
     */
    private static function update_css_bundle($styles = array())
    {
        $assets_dir  = get_template_directory().self::CSS_PATH;
        $css_content = self::concat_assets($styles, [
            self::CSS_SHEET_NAME => [
                [
                    'name'       => 'str_replace',
                    'attributes' => [
                        '(fonts/',
                        '('.get_bloginfo('wpurl').'/wp-content/themes/'.TEXT_DOMAIN.'/assets/css/fonts/'
                    ]
                ],
                [
                    'name'       => 'str_replace',
                    'attributes' => [
                        '(../',
                        '('.get_bloginfo('wpurl').'/wp-content/themes/'.TEXT_DOMAIN.'/assets/'
                    ]
                ]
            ]
        ]);

        $file = fopen($assets_dir, 'w+');

        fwrite($file, $css_content);
        fclose($file);
    }

    private static function include_js_libraries()
    {

        $scripts = [
            'jquery'         => 'wp-includes/js/jquery/jquery.js',
            'jquery-migrate' => 'wp-includes/js/jquery/jquery-migrate.js',
            //            'wp-embed'       => 'wp-includes/js/wp-embed.min.js',
        ];

        $scripts[self::JS_SCRIPT_NAME] = trim(self::JS_FRONT_PATH, '/');

        return $scripts;
    }

    private static function include_css_libraries()
    {
        $styles = [];

        $styles[self::CSS_SHEET_NAME] = trim(self::CSS_FRONT_PATH, '/');

        return $styles;
    }
}


