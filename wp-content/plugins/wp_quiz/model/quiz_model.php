<?php
require_once 'app_model.php';

class QuizModel extends AppModel{

	public function get_published_quiz_by_id($id)
	{
		global $wpdb;
		$res = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."quiz"."` WHERE id = ".$id." AND published = 1", ARRAY_A);
		return $res;
	}

	public function get_data_by_id($id)
	{
		global $wpdb;
		$res = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."quiz"."` WHERE id = ".$id, ARRAY_A);
		return $res;
	}

	public function update_data($post)
	{
		global $wpdb;
		$post['randomized'] = (isset($post['randomized']) && $post['randomized']) ? 1 : 0;
		$post['show_instruction'] = (isset($post['show_instruction']) && $post['show_instruction']) ? 1 : 0;
		$post['show_contact_form'] = (isset($post['show_contact_form']) && $post['show_contact_form']) ? 1 : 0;
		$wpdb->update($wpdb->prefix."quiz", $post, array("id" => $post['id']));
		return $wpdb->num_rows;
	}

	public function insert_data($post)
	{
		global $wpdb;
		$post['randomized'] = (isset($post['randomized']) && $post['randomized']) ? 1 : 0;
		$post['show_instruction'] = (isset($post['show_instruction']) && $post['show_instruction']) ? 1 : 0;
		$post['show_contact_form'] = (isset($post['show_contact_form']) && $post['show_contact_form']) ? 1 : 0;
		$post['created']    = date('Y-m-d H:i:s');
		$wpdb->insert($wpdb->prefix."quiz", $post);
		//debug sql
		// echo $GLOBALS['wp_query']->request; exit;
		return $wpdb->insert_id;
	}

	public function delete_data($id)
	{
		global $wpdb;
		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".$wpdb->prefix."quiz` WHERE id = %d",$id)
		);

		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".$wpdb->prefix."quiz_statistic` WHERE quiz_id = %d",$id)
		);

		$questions = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_questions"."` WHERE quiz_id = ".$id, ARRAY_A);
		//$question_id_list = array_map(function($item){ return $item['id']; }, $questions);
		$question_id_list = array_map('wp_quiz_custom_extract_array', $questions);

		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".$wpdb->prefix."quiz_questions` WHERE quiz_id = %d",$id)
		);
		$wpdb->query("DELETE FROM `".$wpdb->prefix."quiz_answers` WHERE  question_id IN (".implode(",", $question_id_list).")");
		$wpdb->query("DELETE FROM `".$wpdb->prefix."quiz_questions_stat` WHERE  question_id IN (".implode(",", $question_id_list).")");
	}

	public function get_quiz_statistic($quiz_id){
		global $wpdb;
		$res = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."quiz_statistic"."` WHERE quiz_id=".$quiz_id, ARRAY_A);
		return $res;
	}

	public function data2export($quiz_id){
		global $wpdb;
		$res = $wpdb->get_results("SELECT user_id, ip_address, score, created FROM `".$wpdb->prefix."quiz_statistic"."` WHERE quiz_id=".$quiz_id. " ORDER BY created DESC", ARRAY_A);
		return $res;
	}
}

?>