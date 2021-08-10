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

        add_action('wp_ajax_order_form_submit', __CLASS__.'::order_form_submit');
        add_action('wp_ajax_nopriv_order_form_submit', __CLASS__.'::order_form_submit');

    }


    public static function order_form_submit()
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

        $data           = array_key_exists('data', $_POST) && is_array($_POST['data']) ? $_POST['data'] : [];
        $formatted_data = [];
        if (array_key_exists('name', $data) && $data['name']) {
            array_push($formatted_data, $data['name']);
        }
        if (array_key_exists('email', $data) && $data['email']) {
            array_push($formatted_data, $data['email']);
        }
        if (array_key_exists('phone', $data) && $data['phone']) {
            array_push($formatted_data, $data['phone']);
        }
        if (empty($formatted_data)) {
            echo json_encode([
                'notification' => __('Data is empty', TEXT_DOMAIN)
            ]);
            wp_die();
        }


        try {
            $result   = SpreadsheetAPI::add_row([$formatted_data]);
            $response = [
                'result'       => $result,
                'notification' => __('Data appended successfully!', TEXT_DOMAIN),
            ];
            echo json_encode($response);
            wp_die();
        } catch (\Exception $e) {
            $response = json_decode($e->getMessage());
            echo json_encode([
                'values'       => array_values($data),
                'notification' => $response->error->message,
                'message'      => $e->getMessage()
            ]);
            wp_die();
        }
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


