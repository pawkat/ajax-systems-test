<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

class SpreadsheetAPI
{

    protected static $spreadsheet_id = '1RlLbhSVP6tBqX8Wq2wE1G1eZHQZCK0y50Usf8ZeM0PQ';
    protected static $range          = 'data';
    protected static $params         = [
        'valueInputOption' => 'RAW'
    ];
    protected static $insert         = [
        'insertDataOption' => 'INSERT_ROWS'
    ];

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


    }

    /**
     * Returns an authorized API client.
     * @return \Google_Client the authorized client object
     * @throws \Google\Exception
     */
    protected static function get_client()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(PLUGIN_DIR.'/credentials.json');

        return $client;
    }

    /**
     * @param $values
     * @return \Google\Service\Sheets\AppendValuesResponse
     * @throws \Google\Exception
     */
    public static function add_row($values)
    {
        require PLUGIN_DIR.'/vendor/autoload.php';

        $client  = self::get_client();
        $service = new \Google_Service_Sheets($client);
        $body    = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        return $service->spreadsheets_values->append(self::$spreadsheet_id, self::$range, $body, [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS',
        ]);
    }


}


