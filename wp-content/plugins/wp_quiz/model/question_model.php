<?php
require_once 'app_model.php';
class QuestionModel extends AppModel{

	public function get_data_by_id($id)
	{
		global $wpdb;
		$res = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."quiz_questions"."` WHERE id = ".$id, ARRAY_A);
		return $res;
	}

	public function get_questions_by_array_id($id, $published=0)
	{
		global $wpdb;
		$publishedConditions = ($published) ? " AND published = 1 " : "";
		$res = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_questions"."` WHERE id IN (".implode(",", $id).")".$publishedConditions, ARRAY_A);
		return $res;
	}

	public function get_questions_by_quiz_id($quiz_id, $published=0, $random=false, $limit=0)
	{
		global $wpdb;
		$publishedConditions = ($published) ? " AND published = 1 " : "";
		$orderBy = ($random) ? " ORDER BY RAND() " : "";
		$limit = (intval($limit) > 0) ? " LIMIT ".$limit : "";
		$res = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_questions"."` WHERE quiz_id = ".$quiz_id.$publishedConditions.$orderBy.$limit, ARRAY_A);
		return $res;
	}

	public function get_answers_by_id($id)
	{
		global $wpdb;
		$res = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_answers"."` WHERE question_id = ".$id." ORDER BY id ASC", ARRAY_A);
		return $res;
	}

	public function get_answers_by_array_question_id($question_id_list)
	{
		global $wpdb;
		if(!is_array($question_id_list)){
			$question_id_list = array($question_id_list);
		}
		$orderBy = " ORDER BY FIELD(question_id, ".implode(",", $question_id_list)."), answerTable.id ASC";
		$res = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_answers"."` as answerTable WHERE question_id IN (".implode(",", $question_id_list).")".$orderBy, ARRAY_A);
		return $res;
	}

	private function save_answers($post, $answers)
	{
		global $wpdb;

		//get the list need update and the list need insert
		$updateList = array();
		$insertList = array();
		foreach ($answers['id'] as $idx => $ansId) {
			if(!$ansId){
				$insertList[$idx] = $ansId;
			}else{
				$updateList[$idx] = $ansId;
			}
		}

		//delete old answers
		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".$wpdb->prefix."quiz_answers` WHERE question_id = %d", $post['id'])
		);

		//update answers
		/*
		if(!empty($updateList)){
			//update weight
			$ids = implode(',', array_keys($updateList));
			$sql = "UPDATE `".$wpdb->prefix."quiz_answers` SET weight = CASE id ";
			foreach ($updateList as $idx => $ansId) {
			    $sql .= sprintf("WHEN %d THEN %d ", $ansId, $answers['weight'][$idx]);
			}
			$sql .= "END WHERE id IN ($ids)";
			$wpdb->query($sql);

			//update score
			$sql = "UPDATE `".$wpdb->prefix."quiz_answers` SET answer = CASE id ";
			foreach ($updateList as $idx => $ansId) {
			    $sql .= sprintf("WHEN %d THEN %s ", $ansId, $answers['name'][$idx]);
			}
			$sql .= "END WHERE id IN ($ids)";
			$wpdb->query($sql);
		}
		*/

		//update new answers
		if(!empty($updateList)){
			$values = array();
			$place_holders = array();
			$query = "INSERT INTO `".$wpdb->prefix."quiz_answers` (id,question_id, answer, weight) VALUES ";
			foreach ($updateList as $idx => $ansId) {
				$weight = ($answers['weight'][0] == $idx) ? 1 : 0;
				array_push($values, $ansId, $post['id'], $answers['name'][$idx], $weight);
				$place_holders[] = "(%d, %d, '%s', %d)";
			}
			$query .= implode(', ', $place_holders);

			$wpdb->query( $wpdb->prepare("$query ", $values));
		}
		//insert new answers
		if(!empty($insertList)){
			$values = array();
			$place_holders = array();
			$query = "INSERT INTO `".$wpdb->prefix."quiz_answers` (question_id, answer, weight) VALUES ";
			foreach ($insertList as $idx => $ansId) {
				$weight = ($answers['weight'][0] == $idx) ? 1 : 0;
				array_push($values, $post['id'], $answers['name'][$idx], $weight);
				$place_holders[] = "(%d, '%s', %d)";
			}
			$query .= implode(', ', $place_holders);

			$wpdb->query( $wpdb->prepare("$query ", $values));
		}
	}

	public function update_data($post)
	{
		global $wpdb;
		$post = array_filter($post);
		//echo '<pre>'; print_r($post);echo '</pre>';exit;
		$answers = array();
		if(isset($post['quiz_id'])){
			unset($post['quiz_id']);
		}
		if(isset($post['Answer'])){
			$answers = $post['Answer'];
			unset($post['Answer']);
		}

		$post['title'] = isset($post['title']) ? $post['title'] : null;
		$post['published'] = (isset($post['published']) && $post['published']) ? 1 : 0;

		$updateQuestion = $this->update($wpdb->prefix."quiz_questions", $post, array("id" => $post['id']));
		if(!empty($answers)){
			$this->save_answers($post, $answers);
			return $wpdb->num_rows;
		}else{
			return $wpdb->last_error;
		}
	}

	public function insert_data($post)
	{
		global $wpdb;
		$post = array_filter($post);

		$answers = array();
		if(isset($post['Answer'])){
			$answers = $post['Answer'];
			unset($post['Answer']);
		}

		$post['title'] = isset($post['title']) ? $post['title'] : null;
		$post['published'] = (isset($post['published']) && $post['published']) ? 1 : 0;

		if($this->insert($wpdb->prefix."quiz_questions", $post)){
			$insert_id = $wpdb->insert_id;

			if(!empty($answers)){
				$post['id'] = $insert_id;
				$this->save_answers($post, $answers);
			}

			//update count number of answer
			$question_count = $wpdb->get_var( "SELECT COUNT(*) FROM `".$wpdb->prefix."quiz_questions` WHERE quiz_id = ".$post['quiz_id'] );
			$updateQuestion = $this->update($wpdb->prefix."quiz", array('questions_count'=>$question_count), array("id" => $post['quiz_id']));

			return $insert_id;
		}else{
			return $wpdb->last_error;
		}
	}

	public function delete_data($id)
	{
		global $wpdb;
		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".$wpdb->prefix."quiz_questions` WHERE id = %d",$id)
		);

		//update count number of answer
		if($_REQUEST['wp_quiz_id']){
			$question_count = $wpdb->get_var( "SELECT COUNT(*) FROM `".$wpdb->prefix."quiz_questions` WHERE quiz_id = ".$_REQUEST['wp_quiz_id'] );
			$updateQuestion = $this->update($wpdb->prefix."quiz", array('questions_count'=>$question_count), array("id" => $_REQUEST['wp_quiz_id']));
		}
	}

	public function delete_multi_question($id = array())
	{
		global $wpdb;
		$wpdb->query("DELETE FROM `".$wpdb->prefix."quiz_questions` WHERE id IN (".implode(",", $id).")");

		//update count number of answer
		if($_REQUEST['wp_quiz_id']){
			$question_count = $wpdb->get_var( "SELECT COUNT(*) FROM `".$wpdb->prefix."quiz_questions` WHERE quiz_id = ".$_REQUEST['wp_quiz_id'] );
			$updateQuestion = $this->update($wpdb->prefix."quiz", array('questions_count'=>$question_count), array("id" => $_REQUEST['wp_quiz_id']));
		}
	}

	public function get_questions_statistic($question_id_list){
		global $wpdb;
		$res = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_questions_stat"."` WHERE question_id IN (".implode(",", $question_id_list).")", ARRAY_A);
		return $res;
	}
}

?>