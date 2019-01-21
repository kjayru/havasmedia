<?php
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'app_controller.php';

class QuizConfigController extends AppController{
	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		if(isset($_POST) && !empty($_POST)){
			if(isset($_POST['resetAction']) && !empty($_POST['resetAction']) && $_POST['resetAction'] == 'reset'){
				// echo '<pre>';print_r($_POST);echo '</pre>';exit;
				delete_option('quiz_interface_config');
				delete_option('quiz_locale_config');
				delete_option('quiz_result_comments_config');
				delete_option('quiz_mailer_config');

				$url = admin_url('admin.php?page=config-wp-quiz');
				wp_redirect($url);
				exit();
			}elseif(isset($_POST['data']) && !empty($_POST['data'])){
				update_option('quiz_interface_config', serialize($_POST['data']['interface']));
				update_option('quiz_locale_config', serialize($_POST['data']['locale']));
				update_option('quiz_mailer_config', serialize($_POST['data']['quiz_mailer']));
				$this->set_flash(__('Config Updated!'));

				$url = admin_url('admin.php?page=config-wp-quiz');
				//echo $url;exit;
				wp_redirect($url);
				exit();
			}
		}else{
			$interface = array();
			if(get_option( 'quiz_interface_config' )){
				$interface = unserialize(get_option('quiz_interface_config'));
			}else{
				//default setting
				$interface = array(
					"background" => "FFFFFF",
					"color" => "7e7975",
					"border" => "FFFFFF",
					"transparent" => "yes",
					"question_bg" => "3DAEE3",
					"question_color" => "FFFFFF",
					"answer_bg" => "f4f4f4",
					"answer_selected_bg" => "005375",
					"answer_color" => "000000",
					"answer_selected_color" => "FFFFFF",
					"answer_border" => "AAAAAA",
					"answer_selected_border" => "FFFFFF",
					"button_bg" => "3DAEE3",
					"button_bg_hover" => "3597c5",
					"button_color" => "FFFFFF",
					"button_color_hover" => "F0F0F0",
					"footer_bg" => "3DAEE3",
					"progress_bar" => "FFFFFF",
					"pop_up_border" => "3DAEE3",
					"navigation_bg" => "FFFAF6"
					);
			}

			$locale = array();
			if(get_option( 'quiz_locale_config' )){
				$locale = unserialize(get_option('quiz_locale_config'));
			}else{
				//default setting
				$locale = array(
					"msg_not_found" => "Cannot find questions",
					"msg_please_select_an_option" => "Please select an option",
					"msg_question" => "Question",
					"msg_you_scored" => "Correct: %correct%/%total% questions (%percent%)",
					"msg_share_scored" => "Hurray! I reached high score",
					"msg_click_to_review" => "Click to Question button to review your answers",
					"hint" => "Hints",
					"bt_start" => "Start",
					"bt_next" => "Next",
					"bt_back" => "Back",
					"bt_finish" => "Finish",
					"result_comment_perfect" => "Perfect!",
					"result_comment_excellent" => "Excellent!",
					"result_comment_good" => "Good!",
					"result_comment_average" => "Average!",
					"result_comment_bad" => "Bad!",
					"result_comment_poor" => "Poor!",
					"result_comment_worst" => "Worst!",
					"contact_show_form_button" => "Submit Your Score",
					"contact_heading" => "Submit Your Score",
					"contact_name" => "Name",
					"contact_email" => "Email",
					"contact_phone" => "Phone",
					"contact_message" => "Message",
					"contact_submit_button" => "Submit",
					"contact_thankyou" => "Thank you for your submission",
					"contact_redirect" => ""
					);
			}

			$quiz_mailer = array();
			if(get_option( 'quiz_mailer_config' )){
				$quiz_mailer = unserialize(get_option('quiz_mailer_config'));
			}else{
				//default setting
				$quiz_mailer = array(
					"sendto"=> get_bloginfo( 'admin_email' ),
					"host"=> '',
					"username"=> '',
					"password"=> ''
					);
			}
			$this->load->view('quiz_config/index.php', array('interface'=>$interface, 'locale'=>$locale, 'quiz_mailer' => $quiz_mailer));
		}
	}
}
?>