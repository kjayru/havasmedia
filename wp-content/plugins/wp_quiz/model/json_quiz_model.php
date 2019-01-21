<?php
require_once 'quiz_model.php';
require_once 'question_model.php';

class JsonQuizModel{
	private $QuizId;
	private $QuizModel;
	private $QuestionModel;
	public function __construct($quiz_id)
	{
		if(!$quiz_id){
			return null;
		}

		$this->QuizId = $quiz_id;

		$this->QuizModel = new QuizModel();
		$this->QuestionModel = new QuestionModel();
	}

	private function array_random($arr, $num = 1) {
	    shuffle($arr);

	    $r = array();
	    for ($i = 0; $i < $num; $i++) {
	        $r[] = $arr[$i];
	    }
	    return $num == 1 ? $r[0] : $r;
	}

	public function get_json_quiz(){
		//quiz info
		$quiz      = $this->QuizModel->get_published_quiz_by_id($this->QuizId);
		//list question by quiz
		$questions = $this->QuestionModel->get_questions_by_quiz_id($this->QuizId, 1, $quiz['randomized'], $quiz['limit']);
		//extract id from questions list
		//$question_id_list = array_map(function($item){ return $item['id']; }, $questions);
		$question_id_list = array_map('wp_quiz_custom_extract_array', $questions);
		//random question
		if($quiz['randomized']){
			$question_id_list = $this->array_random($question_id_list, count($question_id_list));
		}

		//get answers by question_id list
		$answers   = $this->QuestionModel->get_answers_by_array_question_id($question_id_list, 1);
		// print_r($question_id_list);
		// print_r($answers);

		if(empty($answers)){
			return null;
		}


		//re-format answers list: question_id => array(answer)
		$answersList = null;
		foreach ($answers as $ans) {
			$qid = $ans['question_id'];
			$answersList[$qid][] = $ans;
		}

		/*Format data match with sliding quiz*/
		list($quiz, $questions, $answers) = array($quiz, $questions, $answersList);

		$json_quiz = array();
		$json_quiz['quiz_id'] = $this->QuizId;
		$json_quiz['effect']  = $quiz['effect'];
		//show instruction
		if($quiz['show_instruction']){
			$json_quiz['instruction']['title']       = stripslashes($quiz['title']);
			$json_quiz['instruction']['description'] = $quiz['instruction'];
		}
		//show contact form
		$json_quiz['show_contact_form']  = ($quiz['show_contact_form']) ? true : false;
		$json_quiz['hint']  	 = intval($quiz['hint']);
		if (filter_var($quiz['contact_redirect'], FILTER_VALIDATE_URL)) {
			$json_quiz['contact_redirect']  = $quiz['contact_redirect'];
		}

		$json_quiz['questions'] = array();
		foreach ($questions as $q) {
			$question = array();
			$question['id']           =  $q['id'];
			$question['question']     =  $q['title'];
			$question['explanation']  =  ($q['explain']) ? $q['explain'] : "";
			$answer = array();
			$answerIdList = array();
			$weight = array();
			foreach ($answers[$q['id']] as $idx => $ans) {

				$answer[] = $ans['answer'];
				$answerIdList[] = $ans['id'];
				$weight[] = floatval($ans['weight']);
			}
			$question['answers'] = $answer;
			$question['answerIdList'] = $answerIdList;
			$question['weight']  = $weight;

			$json_quiz['questions'][] = $question;
		}

		//load locale
		if(get_option( 'quiz_locale_config' )){
			$json_quiz['locale'] = unserialize(get_option('quiz_locale_config'));
			$json_quiz['resultComments'] = unserialize(get_option('quiz_result_comments_config'));
		}

		//load locale result comments
		if(get_option( 'quiz_locale_config' )){
			$json_quiz['locale'] = unserialize(get_option('quiz_locale_config'));
		}
		//print_r($json_quiz);exit;
		return json_encode($json_quiz);
	}
}
?>