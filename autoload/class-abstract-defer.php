<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

namespace AjaxSystems;

abstract class Defer
{

    protected static $assets = [];

    protected static $enqueued_assets = [];


    /**
     * TT_Admin constructor.
     */
    function __construct()
    {
    }

    /**
     * Assets passed in the array below will be registered for further including
     */
    public static function register()
    {
        static::$assets = [];
    }

    /**
     * @param string/array $name
     * @param string $type
     * @return string
     */
    public static function enqueue($name, $type = '__echo')
    {
        $content = '';

        if (is_array($name)) :
            foreach ($name as $single_name) :
                $content .= static::enqueue_singular($single_name, $type);
            endforeach;
        else :
            $content .= static::enqueue_singular($name, $type);;
        endif;

        return $content;
    }

    /**
     * @param $name
     * @param string $type
     * @return string
     */
    protected static function enqueue_singular($name, $type = '__echo')
    {
    }

    /**
     * @param string $str
     * @return bool
     */
    protected static function is_url($str = '')
    {
        return is_string($str) && ((bool)(explode('://', $str)[0] === 'https' || explode('://', $str)[0] === 'http'));
    }

    /**
     * @param string $name
     * @param bool $once
     * @return string
     */
    protected static function get_content($name = '', $once = true)
    {
        $content = '';

        if (array_key_exists($name,
                static::$enqueued_assets) && (! $once || ! static::$enqueued_assets[$name]['is_inserted'])) :
            $path       = static::$enqueued_assets[$name]['path'];
            $styles_dir = PLUGIN_URL.'/assets/css/';

            if (explode('/', $path)[0] === 'wp-includes') :
                $path = realpath(WP_CONTENT_DIR.'/..')."/$path";

                $content .= self::file_get_contents($name, $path);
            elseif (static::is_url($path)) :
                $content .= self::file_get_contents($name, $path);
            else :
                $path = get_template_directory()."/$path";

                if (file_exists($path)) :
                    $content .= self::file_get_contents($name, $path);
                endif;
            endif;

            static::$enqueued_assets[$name]['is_inserted'] = true;
        endif;

        $re = '/url\((\'|")?((?!data|http|\'|"|\/wp-content|\/\/).+)\)/mU';
        preg_match_all($re, $content, $matches, PREG_SET_ORDER, 0);
        if (is_array($matches) && ! empty($matches)) {
            foreach ($matches as $match) {
                $url     = $match[count($match) - 1];
                $url     = strpos($url, '/') === 0 ? substr($url, 1, strlen($url) - 1) : $url;
                $content = str_replace($match[count($match) - 1], $styles_dir.$url, $content);
            }
        }

        return $content;
    }

    protected static function file_get_contents($name, $path)
    {
        $cached = wp_cache_get($name, 'cache');

        if ($cached !== false) :
            $result = $cached;
        else :
            $result = file_get_contents($path);

            wp_cache_set($name, $result, 'cache');
        endif;

        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected static function is_enqueued($name = '')
    {
        return array_key_exists($name, static::$assets) && ! array_key_exists($name, static::$enqueued_assets);
    }

}


