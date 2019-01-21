<?php
/*
Plugin Name: Wordpress Quiz
Plugin URI: http://codecanyon.net/item/wordpress-quiz/5057356
Description: Powerful solution for creating interactive quizzes
Author: Vu Khanh Truong
Version: 2.0.1
Author URI:
*/
error_reporting(0);
// ini_set('display_errors',1);
//Our class extends the WP_List_Table class, so we need to make sure that it's there
define('WP_QUIZ_PATH', dirname(__FILE__));

/*--------------------------
Install Data
--------------------------*/
global $wpdb;
global $wp_quiz_db_version;
$wp_quiz_db_version = "2.0";

$charset_collate = '';

if ( ! empty( $wpdb->charset ) ) {
  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
}

if ( ! empty( $wpdb->collate ) ) {
  $charset_collate .= " COLLATE {$wpdb->collate}";
}

function quiz_install()
{
	global $wpdb;
	global $wp_quiz_db_version;

	$table_name = $wpdb->prefix . "quiz";

	$quiz_table_sql = "
	CREATE TABLE `".$wpdb->prefix."quiz` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(255) NOT NULL,
		`instruction` mediumtext,
		`randomized` tinyint(1) NOT NULL DEFAULT '1',
		`questions_count` int(11) NOT NULL DEFAULT '0',
		`created` datetime DEFAULT NULL,
	    `show_instruction` tinyint(1) NOT NULL DEFAULT '0',
	    `show_contact_form` tinyint(1) NOT NULL DEFAULT '0',
		`contact_redirect` mediumtext,
		`hint` int(11) NOT NULL DEFAULT '0',
		`limit` int(11) NULL,
	    `effect`  enum('slide','fade') NULL DEFAULT 'slide',
		`published` tinyint(1) NOT NULL DEFAULT '0',
		UNIQUE KEY (`id`)
		) $charset_collate;
	";

	$quiz_question_sql = "
	CREATE TABLE `".$wpdb->prefix."quiz_questions` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`quiz_id` int(11) NOT NULL,
		`title` text NOT NULL,
		`explain` text NULL,
		`published` tinyint(1) NOT NULL DEFAULT '0',
		UNIQUE KEY (`id`)
		) $charset_collate;
	";
	$quiz_answers_sql = "
	CREATE TABLE `".$wpdb->prefix."quiz_answers` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`question_id` int(11) NOT NULL,
		`answer` varchar(255) NOT NULL,
		`weight` float NOT NULL DEFAULT 0 ,
		UNIQUE KEY (`id`)
		) $charset_collate;
	";

	$quiz_statistic_sql = "
	CREATE TABLE `".$wpdb->prefix."quiz_statistic` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user_id`  bigint(20) NOT NULL DEFAULT 0,
		`quiz_id`  int(11) NOT NULL ,
		`ip_address`  varchar(255) NOT NULL ,
		`score`  float NOT NULL DEFAULT 0 ,
		`created`  datetime NOT NULL ,
		UNIQUE KEY (`id`)
		) $charset_collate;
	";

	$quiz_questions_statistic_sql = "
	CREATE TABLE `".$wpdb->prefix."quiz_questions_stat` (
		`id`  int NOT NULL AUTO_INCREMENT,
		`quiz_stats_id`  int NOT NULL ,
		`question_id`  int NOT NULL ,
		`answer_id`  int NOT NULL ,
		`score` float NOT NULL DEFAULT 0 ,
		`created`  datetime NOT NULL ,
		UNIQUE KEY (`id`)
		) $charset_collate;
	";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $quiz_table_sql );
	dbDelta( $quiz_question_sql );
	dbDelta( $quiz_answers_sql );
	dbDelta( $quiz_statistic_sql );
	dbDelta( $quiz_questions_statistic_sql );

	add_option( "wp_quiz_db_version", $wp_quiz_db_version );


	/*---------------------------------
	* Update for new version
	*---------------------------------*/
	$installed_ver = get_option( "wp_quiz_db_version" );

	if ( $installed_ver != $wp_quiz_db_version ) {


	    //Update column limit for table quiz
	    $wpdb->query("ALTER TABLE  `".$wpdb->prefix."quiz` ADD  `limit` INT NULL DEFAULT NULL AFTER  `hint` ;");

		update_option( "wp_quiz_db_version", $wp_quiz_db_version );
	}
}

//Calling the hook function
register_activation_hook( __FILE__, 'quiz_install' );

//Check the plugin db change
function wp_quiz_update_db_check() {
    global $wp_quiz_db_version;
    if ( get_site_option( 'wp_quiz_db_version' ) != $wp_quiz_db_version ) {
        quiz_install();
    }
}
add_action( 'plugins_loaded', 'wp_quiz_update_db_check' );


/*---------------------------------
* load backend neccessary features
*---------------------------------*/
if(is_admin() && (isset($_GET['page']) && ($_GET['page'] == 'wordpress-quiz' || $_GET['page'] == 'config-wp-quiz') )){
	//editor
	add_action('init', 'wp_quiz_output_buffer');
	// add_action('admin_init', 'wp_quiz_editor_admin_init');
	// add_action('admin_head', 'wp_quiz_editor_admin_head');
	//flash session
	add_action('init', 'quizStartSession', 1);
	add_action('wp_logout', 'quizEndSession');
	add_action('wp_login', 'quizEndSession');
	//flush session
	add_action('wp_footer', 'wp_quiz_output_buffer_end');
}
/*---------------------------------
* load native tinymce
*---------------------------------*/
// function wp_quiz_editor_admin_init() {
// 	wp_enqueue_script('word-count');
// 	wp_enqueue_script('post');
// 	wp_enqueue_script('editor');
// 	wp_enqueue_script('media-upload');
// }
// function wp_quiz_editor_admin_head() {
// 	wp_tiny_mce();
// }

/*---------------------------------
//session manager
*---------------------------------*/

function quizStartSession()
{
	if(!session_id()) {
		session_start('quiz_session');
	}
}
function quizEndSession()
{
	session_destroy ();
}

/*------------------------------------------
//Allow redirection, even if the
theme starts to send output to the browser
*------------------------------------------*/
function wp_quiz_output_buffer()
{
	ob_start();
}
function wp_quiz_output_buffer_end()
{
	ob_end_flush();
}

/*---------------------------------
//Create administration menu
*---------------------------------*/
function wp_quiz_plugin_actions()
{
	add_menu_page("Wordpress Quiz", "Quiz", 10, "wordpress-quiz", "wp_quiz_controller");
	add_submenu_page( "wordpress-quiz", "Configuration", "Config", 10, "config-wp-quiz", "wp_quiz_config_controller");
}
add_action('admin_menu', 'wp_quiz_plugin_actions');

/*
* Extract particular fields from an array
* @http://stackoverflow.com/questions/5103640/how-to-extract-particular-fields-from-an-array
*/
function wp_quiz_custom_extract_array ($item, $field='id') {
  return $item[$field];
}

require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'load.php';

/*---------------------------------
* MVC Manage list of quiz
*---------------------------------*/
function wp_quiz_controller()
{
	$controller = (isset($_GET['controller'])) ? $_GET['controller'] : '';
	switch ($controller) {
		case 'questions':
			require 'controller/questions_controller.php';
			new QuestionsController();
		break;

		default:
			require 'controller/quiz_controller.php';
			new QuizController();
		break;
	}
}

/*---------------------------------
* Quiz Configuration
*---------------------------------*/
function wp_quiz_config_controller(){
	//include 'configuration.php';
	require 'controller/quiz_config_controller.php';
	new QuizConfigController();
}


/*---------------------------------
* Shortcode
*---------------------------------*/
include('ajax.php');

/*---------------------------------
* Shortcode
*---------------------------------*/
include('shortcodes.php');
?>