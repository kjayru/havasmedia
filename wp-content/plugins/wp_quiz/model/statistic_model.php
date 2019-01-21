<?php
require_once 'app_model.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'vendors'.DIRECTORY_SEPARATOR.'flatfile.php';
class StatisticModel extends AppModel{
	public function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
  			//check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
  			//to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	private function checkExistIP($id, $ip){
		//initial flatfile database
		$ff = new Flatfile();
		$wp_upload_dir = wp_upload_dir();
		$ff->datadir = $wp_upload_dir['basedir'].DIRECTORY_SEPARATOR;
		$ip_file = 'wp_quiz_'.$id.'_ip_list.txt';

		//check ip already access this page?
		$ip_result = $ff->selectUnique($ip_file, 0, $ip);
		//if the first time visit this page -> save in the list

		if (empty($ip_result)) {
		    $ff->insert($ip_file, $ip);
	    	return false;
		}

		return true;
	}

	public function insert_data($post, $quiz_id = null, $score=0, $user_id=0)
	{
		global $wpdb;

		if(empty($post)){
			return false;
		}

		//insert new answers
		$values = array();
		$place_holders = array();
		$created   = date('Y-m-d H:i:s');
		$ip_address = $this->getRealIpAddr();

		//check exist ip
		if(!$this->checkExistIP($quiz_id, $ip_address)){
			if($user_id>0){
				//check current user is already do this quiz
				$userCheck = $wpdb->get_var( "SELECT COUNT(id) FROM `".$wpdb->prefix."quiz_statistic` WHERE user_id={$user_id} AND quiz_id={$quiz_id}" );
				if($userCheck > 0){
					return false;
				}
			}

			$query = "INSERT INTO `".$wpdb->prefix."quiz_statistic` (user_id, quiz_id, ip_address, score, created) VALUES ({$user_id}, {$quiz_id}, '".$ip_address."', ".$score.", '".$created."');";
			$wpdb->query($query);
			$quiz_stats_id = $wpdb->insert_id;

			$query = "INSERT INTO `".$wpdb->prefix."quiz_questions_stat` (quiz_stats_id, question_id, answer_id, score, created) VALUES ";
			foreach ($post as $p) {
				$question_id = $p['question_id'];
				$answer_id = $p['answer_id'];
				$score  = $p['score'];

				array_push($values, $quiz_stats_id, $question_id, $answer_id, $score, $created);
				$place_holders[] = "(%d, %d, %d, %d, '%s')";
			}
			$query .= implode(', ', $place_holders);

			return $wpdb->query( $wpdb->prepare("$query ", $values));
		}

		return null;
	}
}
?>