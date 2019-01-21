<?php
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'question_model.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'quiz_model.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'app_controller.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'Question_List_Table.php';

class QuestionsController extends AppController{
	private $QuestionModel;
	private $QuizModel;

	public function __construct()
	{
		$this->QuestionModel = new QuestionModel();
		$this->QuizModel = new QuizModel();
		parent::__construct();
	}

	public function index()
	{
		// check id parameter
		$quiz_id = (isset($_GET['wp_quiz_id'])) ? $_GET['wp_quiz_id'] : false;
		if(!$quiz_id){
			$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'');
			$this->set_flash(__('Invalid Id'));
			wp_redirect($url);
		}

		//Quiz info
		$quiz = $this->QuizModel->get_data_by_id($quiz_id);

		//Prepare Table of elements
		$wp_list_table = new Question_List_Table($quiz_id);
		$wp_list_table->prepare_items();
		$this->load->view('questions/list.php', array('wp_list_table'=>$wp_list_table, 'quiz_info'=>$quiz));
	}

	public function add()
	{
		if(isset($_POST) && !empty($_POST)){
			$_POST = stripslashes_deep($_POST);
			$answers = (isset($_POST['data']['Answer'])) ? array_filter($_POST['data']['Answer']) : null;
			$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'');
			//escape wordpres splash
			$_POST['data']['title'] = stripslashes_deep($_POST['title']);
			$_POST['data']['explain'] = stripslashes_deep($_POST['explain']);
			$question_id = $this->QuestionModel->insert_data($_POST['data']);

			if(is_numeric($question_id)){
				if(empty($answers)){
					$this->set_flash(__('You must create answers for this question!'), 'error');
					$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=edit&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'&question_id='.$question_id.'&/#/question_answers/'.$question_id);
				}else{
					$this->set_flash(__('Data has been saved!'));
				}
			}else{
				//error gone here
				$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=add&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'&question_id='.$question_id.'&/#/question_answers/'.$question_id);
				$this->set_flash($question_id, 'error');
			}

			wp_redirect($url);
		}

		$this->load->view('questions'.DIRECTORY_SEPARATOR.'add.php', array());
	}

	public function edit()
	{
		if(isset($_POST) && !empty($_POST)){
			$_POST = stripslashes_deep($_POST);
			$answers = (isset($_POST['data']['Answer'])) ? array_filter($_POST['data']['Answer']) : null;
			$url = '';
// echo '<pre>';
// print_r($answers);
// echo '</pre>';exit;
			if(isset($answers['weight']) && !empty($answers['weight'])){
				//escape wordpres splash
				$_POST['data']['title'] = stripslashes_deep($_POST['title']);
				$_POST['data']['explain'] = stripslashes_deep($_POST['explain']);
				$upd = $this->QuestionModel->update_data($_POST['data']);
				$this->set_flash(__('Question has been saved!'));
				$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id']);
			}else{
				$this->set_flash(__('You must create answers & select right answer for this question!'), 'error');
				$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=edit&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'&question_id='.$_REQUEST['question_id'].'&/#/question_answers/'.$_REQUEST['question_id']);
			}
			wp_redirect($url);
		}

		// check id parameter
		$id = (isset($_GET['question_id'])) ? $_GET['question_id'] : false;
		if(!$id){
			$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'');
			$this->set_flash(__('Invalid Id'));
			wp_redirect($url);
		}

		// get data by id, then bind to form
		$data = $this->QuestionModel->get_data_by_id($id);

		$this->load->view('questions/edit.php', $data);
	}

	public function delete()
	{
		if(isset($_POST['data']['id']) && !empty($_POST['data']['id'])){
			$upd = $this->QuestionModel->delete_data($_POST['data']['id']);
			$this->set_flash(__('Quiz deleted!'));
			$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'');
			wp_redirect($url);
		}

		$id = (isset($_GET['question_id'])) ? $_GET['question_id'] : false;
		if(!$id){
			$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'');
			$this->set_flash(__('Invalid Id'), 'error');
			wp_redirect($url);
		}

		$data = $this->QuestionModel->get_data_by_id($id);
		$this->load->view('questions/delete.php', $data);
	}

	public function delete_all()
	{
		$listQuestions = null;
		if(isset($_POST) && !empty($_POST)){
			// echo "<pre>";print_r($_POST);echo "</pre>";exit;
			if($_POST['action'] == 'agree_delete_all') {
				$this->QuestionModel->delete_multi_question($_POST['questions']);
				$this->set_flash(__('Questions deleted!'));
			}else{
				$question_id_list = array_filter($_POST['wp_quiz_questions']);
				if(!empty($question_id_list)){
					$listQuestions = $this->QuestionModel->get_questions_by_array_id($question_id_list);
				}
			}
		}
		if(empty($listQuestions)){
			$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'');
			wp_redirect( $url );
		}

		$this->load->view('questions/delete_all.php', $listQuestions);
	}

	public function statistic()
	{
		$quiz_id = (isset($_GET['quiz_id'])) ? $_GET['quiz_id'] : false;
		if(!$quiz_id){
			$url = admin_url('admin.php?page=wordpress-quiz');
			$this->set_flash(__('Invalid Id'), 'error');
			wp_redirect($url);
		}

		//list quiz
		$data['quiz'] = $this->QuizModel->get_data_by_id($quiz_id);

		//list question by quiz
   		$questions = $this->QuestionModel->get_questions_by_quiz_id($quiz_id);
   		//extract id from questions list
   		//$question_id_list = array_map(function($item){ return $item['id']; }, $questions);
   		$question_id_list = array_map('wp_quiz_custom_extract_array', $questions);
		$data['questions'] = $questions;

/*
		//get answers list
		$list_answers = $this->QuestionModel->get_answers_by_array_question_id($question_id_list);
		$answers = array();
		foreach ($list_answers as $answer) {
			$answers[$answer['id']] = array('answer'=>$answer['answer'], 'weight'=>$answer['weight']);
		}
		$data['answers'] = $answers;

		//format stats per question
		$stats = array();
		$statistic = $this->QuestionModel->get_questions_statistic($question_id_list);
		foreach ($statistic as $stat) {
			$stats[$stat['question_id']][] = $stat;
		}
	 	// echo "<pre>";print_r($stats);echo "</pre>";exit;
		$data['statistic'] = $stats;
*/
		$this->load->view('questions/statistic.php', $data);
	}

	public function duplicate(){
		$question_id = $_GET['question_id'];
		$questions = $this->QuestionModel->get_data_by_id($question_id);
		$answers   = $this->QuestionModel->get_answers_by_id($question_id);

		$prepareAns = array();
		foreach ($answers as $key => $ans) {
			$prepareAns['id'][] = null;
			$prepareAns['name'][] = $ans['answer'];
			if($ans['weight'] > 0){
				$prepareAns['weight'][0] = $key;
			}
		}
		$postData['data'] = array(
			'quiz_id' => $questions['quiz_id'],
			'title' => $questions['title'],
			'explain' => $questions['explain'],
			'published' => $questions['published'],
			'Answer' =>$prepareAns
		);

		$question_id = $this->QuestionModel->insert_data($postData['data']);
		$url = admin_url('admin.php?page=wordpress-quiz&controller=questions&action=edit&wp_quiz_id='.$_REQUEST['wp_quiz_id'].'&question_id='.$question_id.'&/#/question_answers/'.$question_id);
		$this->set_flash(__('New question has been duplicated!'));
		wp_redirect($url);
	}
}

?>