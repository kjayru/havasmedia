<?php

defined('ABSPATH') or die('No script kiddies please!');
/**
 * Plugin Name: AccessPress Twitter Feed Pro
 * Plugin URI: https://accesspressthemes.com/wordpress-plugins/accesspress-twitter-feed-pro/
 * Description: A plugin to show your twitter feed in your site with various configurable settings
 * Version: 1.0.1
 * Author: AccessPress Themes
 * Author URI: http://accesspressthemes.com
 * Text Domain: ap-twitter-feed-pro
 * Domain Path: /languages/
 * 
 * /
  /**
 * Declartion of necessary constants for plugin
 * */
if (!defined('APTF_PRO_IMAGE_DIR')) {
    define('APTF_PRO_IMAGE_DIR', plugin_dir_url(__FILE__) . 'images');
}
if (!defined('APTF_PRO_JS_DIR')) {
    define('APTF_PRO_JS_DIR', plugin_dir_url(__FILE__) . 'js');
}
if (!defined('APTF_PRO_CSS_DIR')) {
    define('APTF_PRO_CSS_DIR', plugin_dir_url(__FILE__) . 'css');
}
if (!defined('APTF_PRO_VERSION')) {
    define('APTF_PRO_VERSION', '1.0.1');
}

if (!defined('APTF_TD_PRO')) {
    define('APTF_TD_PRO', 'ap-twitter-feed-pro');
}
include_once('inc/backend/widget.php');
include_once('inc/backend/slider-widget.php');
include_once('inc/backend/ticker-widget.php');
include_once("twitteroauth/twitteroauth.php");
if (!class_exists('APTF_PRO_Class')) {

    class APTF_PRO_Class {

        var $aptf_pro_settings;

        /**
         * Initialization of plugin from constructor
         */
        function __construct() {
            $this->aptf_pro_settings = get_option('aptf_pro_settings');
            add_action('init', array($this, 'load_text_domain')); //loads plugin text domain for internationalization
            add_action('admin_init', array($this, 'session_init')); //starts session in admin section
            add_action('admin_menu', array($this, 'add_plugin_admin_menu')); //adds the menu in admin section
            add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts')); //registers scripts and css for admin section
            register_activation_hook(__FILE__, array($this, 'load_default_settings')); //loads default settings for the plugin while activating the plugin
            add_action('admin_post_aptf_form_action', array($this, 'aptf_form_action')); //action to save settings
            add_action('admin_post_aptf_restore_settings', array($this, 'aptf_restore_settings')); //action to restore default settings
            add_action('admin_post_aptf_delete_cache', array($this, 'aptf_delete_cache')); //action to delete cache
            add_shortcode('ap-twitter-feed-pro', array($this, 'feed_shortcode')); //registers shortcode to display the feeds
            add_shortcode('ap-twitter-feed-pro-slider', array($this, 'feed_slider_shortcode')); //registers shortcode to display the feeds as slider
            add_shortcode('ap-twitter-feed-pro-ticker', array($this, 'feed_ticker_shortcode')); //registers shortcode to display the feeds as ticker
            add_action('widgets_init', array($this, 'register_widget')); //registers the widget
            add_action('wp_enqueue_scripts', array($this, 'register_front_assests')); //registers assets for the frontend
        }

        /**
         * Loads Plugin Text Domain
         * 
         */
        function load_text_domain() {
            load_plugin_textdomain(APTF_TD_PRO, false, basename(dirname(__FILE__)) . '/languages');
        }

        /**
         * Starts Session
         */
        function session_init() {
            if (!session_id()) {
                session_start();
            }
        }

        /**
         * Loads Default Settings
         */
        function load_default_settings() {
            $default_settings = $this->get_default_settings();
            if (!get_option('aptf_pro_settings')) {
                update_option('aptf_pro_settings', $default_settings);
            }
            $this->aptf_delete_cache();
        }

        /**
         * Adds plugin's menu in the admin section
         */
        function add_plugin_admin_menu() {
            add_menu_page(__('AccessPress Twitter Feed Pro', APTF_TD_PRO), __('AccessPress Twitter Feed Pro', APTF_TD_PRO), 'manage_options', 'ap-twitter-feed-pro', array($this, 'main_setting_page'), APTF_PRO_IMAGE_DIR . '/icon.png');
        }

        /**
         * Plugin's main setting page
         */
        function main_setting_page() {
            include('inc/backend/settings.php');
        }

        /**
         * Register all the scripts in admin section
         */
        function register_admin_scripts() {
            if (isset($_GET['page']) && $_GET['page'] == 'ap-twitter-feed-pro') {
                wp_enqueue_script('aptf-admin-script', APTF_PRO_JS_DIR . '/backend.js', array('jquery'), APTF_PRO_VERSION);
                wp_enqueue_style('aptf-backend-css', APTF_PRO_CSS_DIR . '/backend.css', array(), APTF_PRO_VERSION);
                wp_enqueue_style('aptf-pro-fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), APTF_PRO_VERSION);
            }
        }

        /**
         * Return default settings array
         * @return array
         */
        function get_default_settings() {
            $default_settings = array('consumer_key' => '',
                'consumer_secret' => '',
                'access_token' => '',
                'access_token_secret' => '',
                'twitter_username' => '',
                'cache_period' => '',
                'total_feed' => '5',
                'feed_template' => 'template-1',
                'time_format' => 'elapsed_time',
                'display_username' => 1,
                'display_twitter_actions' => 1,
                'fallback_message' => '',
                'display_follow_button' => 0,
                'exclude_lightbox' => 0,
                'exclude_slider' => 0
            );
            return $default_settings;
        }

        function get_api_connection($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
            $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
            return $connection;
        }

        /**
         * Prints array in pre format
         */
        function print_array($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

        /**
         * Saves settings in option table
         */
        function aptf_form_action() {
            if (!empty($_POST) && wp_verify_nonce($_POST['aptf_nonce_field'], 'aptf_action_nonce')) {
                include('inc/backend/save-settings.php');
            } else {
                die('No script kiddies please!');
            }
        }

        /**
         * Restores Default Settings
         */
        function aptf_restore_settings() {
            if (!empty($_GET) && wp_verify_nonce($_GET['_wpnonce'], 'aptf-restore-nonce')) {
                $aptf_pro_settings = $this->get_default_settings();
                update_option('aptf_pro_settings', $aptf_pro_settings);
                $_SESSION['aptf_msg'] = __('Restored Default Settings Successfully.', APTF_TD_PRO);
                wp_redirect(admin_url() . 'admin.php?page=ap-twitter-feed-pro');
            } else {
                die('No script kiddies please!');
            }
        }

        /**
         * Registers shortcode to display feed
         */
        function feed_shortcode($atts) {
            ob_start();
            include('inc/frontend/shortcode.php');
            $html = ob_get_contents();
            ob_get_clean();
            return $html;
        }

        /**
         * Register shortcode for feeds slider
         */
        function feed_slider_shortcode($atts) {
            ob_start();
            include('inc/frontend/slider-shortcode.php');
            $html = ob_get_contents();
            ob_get_clean();
            return $html;
        }

        /**
         * 
         * @param varchar $date
         * @param string $format
         * @return type
         */
        function get_date_format($date, $format) {
            switch ($format) {
                case 'full_date':
                    $date = strtotime($date);
                    $date = date('F j, Y, g:i a', $date);
                    break;
                case 'date_only':
                    $date = strtotime($date);
                    $date = date('F j, Y', $date);
                    break;
                case 'elapsed_time':
                    $current_date = strtotime(date('h:i A M d Y'));
                    $tweet_date = strtotime($date);
                    $total_seconds = $current_date - $tweet_date;

                    $seconds = $total_seconds % 60;
                    $total_minutes = $total_seconds / 60;
                    ;
                    $minutes = $total_minutes % 60;
                    $total_hours = $total_minutes / 60;
                    $hours = $total_hours % 24;
                    $total_days = $total_hours / 24;
                    $days = $total_days % 365;
                    $years = $total_days / 365;

                    if ($years >= 1) {
                        if ($years == 1) {
                            $date = $years . __(' year ago', APTF_TD_PRO);
                        } else {
                            $date = $years . __(' year ago', APTF_TD_PRO);
                        }
                    } elseif ($days >= 1) {
                        if ($days == 1) {
                            $date = $days . __(' day ago', APTF_TD_PRO);
                        } else {
                            $date = $days . __(' days ago', APTF_TD_PRO);
                        }
                    } elseif ($hours >= 1) {
                        if ($hours == 1) {
                            $date = $hours . __(' hour ago', APTF_TD_PRO);
                        } else {
                            $date = $hours . __(' hours ago', APTF_TD_PRO);
                        }
                    } elseif ($minutes > 1) {
                        $date = $minutes . __(' minutes ago', APTF_TD_PRO);
                    } else {
                        $date = __("1 minute ago", APTF_TD_PRO);
                    }
                    break;
                default:
                    break;
            }
            return $date;
        }

        /**
         * Registers Widget
         */
        function register_widget() {
            register_widget('APTF_PRO_Widget');
            register_widget('APTF_PRO_Slider_Widget');
            register_widget('APTF_PRO_Ticker_Widget');
        }

        /**
         * Registers Assets for frontend
         */
        function register_front_assests() {
            $aptf_pro_settings = $this->aptf_pro_settings;
            $js_dependencies = array('jquery', 'aptf-pro-easy-ticker');
            /**
             * Frontend JS
             */
            wp_enqueue_script('aptf-pro-easing', APTF_PRO_JS_DIR . '/jquery.easing.min.js', array('jquery'), APTF_PRO_VERSION);
            wp_enqueue_script('aptf-pro-easy-ticker', APTF_PRO_JS_DIR . '/jquery.easy-ticker.min.js', array('jquery', 'aptf-pro-easing'), APTF_PRO_VERSION);
            if ($aptf_pro_settings['exclude_slider'] != 1) {
                wp_enqueue_script('aptf-pro-bxslider-js', APTF_PRO_JS_DIR . '/jquery.bxslider.min.js', array('jquery'), APTF_PRO_VERSION);
                $js_dependencies[] = 'aptf-pro-bxslider-js';
            }
            if ($aptf_pro_settings['exclude_slider'] != 1) {
                wp_enqueue_script('aptf-pro-lightbox-js', APTF_PRO_JS_DIR . '/lightbox.js', array('jquery'), APTF_PRO_VERSION);
                $js_dependencies[] = 'aptf-pro-lightbox-js';
            }
            wp_enqueue_script('aptf-pro-front-js', APTF_PRO_JS_DIR . '/frontend.js', array('jquery', 'aptf-pro-bxslider-js', 'aptf-pro-easy-ticker'), APTF_PRO_VERSION);

            /**
             * Frontend styles
             */
            wp_enqueue_style('aptf-pro-bxslider-css', APTF_PRO_CSS_DIR . '/jquery.bxslider.css', array(), APTF_PRO_VERSION);
            wp_enqueue_style('aptf-pro-front-css', APTF_PRO_CSS_DIR . '/frontend.css', array(), APTF_PRO_VERSION);
            wp_enqueue_style('aptf-pro-font-css', APTF_PRO_CSS_DIR . '/fonts.css', array(), APTF_PRO_VERSION);
            wp_enqueue_style('aptf-pro-fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), APTF_PRO_VERSION);
            wp_enqueue_style('aptf-pro-lightbox-css', APTF_PRO_CSS_DIR . '/lightbox.css', array(), APTF_PRO_VERSION);
        }

        /**
         * Register shortcode for the feed ticker mode
         */
        function feed_ticker_shortcode($atts) {
            ob_start();
            include('inc/frontend/ticker-shortcode.php');
            $html = ob_get_contents();
            ob_get_clean();
            return $html;
        }

        /**
         * Returns abreviated count format
         * @param integer $value
         * @return string
         */
        function abreviateTotalCount($value) {

            $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');

            foreach ($abbreviations as $exponent => $abbreviation) {

                if ($value >= pow(10, $exponent)) {

                    return round(floatval($value / pow(10, $exponent)), 1) . $abbreviation;
                }
            }
        }

        /**
         * Deletes Feeds from cache
         */
        function aptf_delete_cache() {

            global $wpdb;
            $tbl_name = $wpdb->options;
            $results = $wpdb->get_results("SELECT option_name FROM  `$tbl_name` WHERE `option_name` LIKE  '_transient_aptf%'");
            if (count($results) > 0) {
                foreach ($results as $result) {
                    $transient_name = str_replace('_transient_', '', $result->option_name);
                    delete_transient($transient_name);
                }
            }
            $_SESSION['aptf_msg'] = __('Cache Deleted Successfully.', APTF_TD_PRO);
            wp_redirect(admin_url() . 'admin.php?page=ap-twitter-feed-pro');
        }

        /**
         * New Functions
         * */
        function get_oauth_connection($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
            $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
            return $connection;
        }

        function get_twitter_tweets($username, $tweets_number) {
            $transient_variable = 'aptf_tweets_' . $username . '_' . $tweets_number;
            $tweets = get_transient($transient_variable);
            if (false === $tweets) {
                $aptf_pro_settings = $this->aptf_pro_settings;
                $consumer_key = $aptf_pro_settings['consumer_key'];
                $consumer_secret = $aptf_pro_settings['consumer_secret'];
                $access_token = $aptf_pro_settings['access_token'];
                $access_token_secret = $aptf_pro_settings['access_token_secret'];
                $oauth_connection = $this->get_oauth_connection($consumer_key, $consumer_secret, $access_token, $access_token_secret);
                $tweets = $oauth_connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $tweets_number);
                $cache_period = intval($aptf_pro_settings['cache_period']) * 60;
                $cache_period = ($cache_period < 1) ? 3600 : $cache_period;
                if (!isset($tweets->errors)) {
                    set_transient($transient_variable, $tweets, $cache_period);
                }
            }

            return $tweets;
        }

    }

    /**
     * Plugin Initialization
     */
    $aptf_obj = new APTF_PRO_Class();
}

