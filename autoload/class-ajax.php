<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

class AJAX
{

    /**
     * Fields constructor.
     */
    function __construct()
    {

        /**
         * @example request handler
         */
        add_action('wp_ajax_handle_ping', __CLASS__.'::handle_ping');
        add_action('wp_ajax_nopriv_handle_ping', __CLASS__.'::handle_ping');

        add_action('wp_ajax_get_views', __CLASS__.'::get_views');
        add_action('wp_ajax_nopriv_get_views', __CLASS__.'::get_views');

        add_action('wp_ajax_load_posts', __CLASS__.'::load_posts');
        add_action('wp_ajax_nopriv_load_posts', __CLASS__.'::load_posts');

    }


    public static function handle_ping()
    {

        if (! wp_verify_nonce($_POST['nonce'], PREFIX)) {
            echo json_encode([
                'notification' => __('403. Nonce is not verified.', TEXT_DOMAIN)
            ]);
            wp_die();
        }

        /**
         * Handle request
         */
        $response = $_POST;

        // code goes here

        /**
         * Response
         */
        echo json_encode($response);
        wp_die();
    }


    public static function get_views()
    {

        if (! wp_verify_nonce($_GET['nonce'], PREFIX)) {
            echo json_encode([
                'notification' => __('403. Nonce is not verified.', TEXT_DOMAIN)
            ]);
            wp_die();
        }

        $post_id = $_GET['post_id'] ? $_GET['post_id'] : 0;

        echo json_encode([
            'views' => PostTypes::get_post_views($post_id)
        ]);
        wp_die();
    }


    public static function load_posts()
    {

        if (! wp_verify_nonce($_GET['nonce'], PREFIX)) {
            echo json_encode([
                'notification' => __('403. Nonce is not verified.', TEXT_DOMAIN)
            ]);
            wp_die();
        }

        $query_args     = $new_query_args = $_GET['query_args'] ? $_GET['query_args'] : false;
        $template       = $_GET['template'] ? $_GET['template'] : 'post-item-min';
        $show_post_info = $_GET['show_post_info'] ? $_GET['show_post_info'] : false;

        if ($query_args && is_array($query_args) && ! empty($query_args)) {
            $query = new \WP_Query($query_args);
            $posts = false;

            foreach ($query->posts as $post) {
                $posts .= Utility::get_tpl('template-parts/partials/'.$template, [
                    'id'             => $post->ID,
                    'show_post_info' => $show_post_info,
                ]);
            }

            $new_query_args['paged']++;

            echo json_encode([
                'posts'      => $posts,
                'query_args' => $new_query_args,
                'hide'       => $query->max_num_pages <= $query->query_vars['paged'],
            ]);
            wp_die();
        }

        echo json_encode([
            'notification' => __('Something went wrong, try again later.', TEXT_DOMAIN),
        ]);
        wp_die();
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


