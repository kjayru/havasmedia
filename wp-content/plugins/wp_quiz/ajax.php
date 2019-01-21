<?php
/*---------------------------------
* AJAX: load stats by question
*---------------------------------*/
function load_stats_by_question_callback() {
	if(isset($_GET['question_id']) && !empty($_GET['question_id'])){

		require 'model/question_model.php';
		$QuestionModel = new QuestionModel();

		$question_id = $_GET['question_id'];
		$question_id_list = array($question_id);

		$list_answers = $QuestionModel->get_answers_by_array_question_id($question_id_list);
		$answers = array();
		foreach ($list_answers as $answer) {
			$answers[$answer['id']] = array('answer'=>$answer['answer'], 'weight'=>$answer['weight']);
		}
		$data['answers'] = $answers;		

		$statistic = $QuestionModel->get_questions_statistic($question_id_list);

		if(!empty($statistic)):
?>
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<script type="text/javascript">
		    //load the Google Visualization API and the chart
		    google.load('visualization', '1', {'packages':['columnchart','piechart']});
		</script>
<?php			
			$chartData  = array();
			$ans = array();
			foreach ($statistic as $s) {
				$ansID = $s['answer_id'];
				$ans[$ansID]++;
?>
				<div style="text-align:center" id="PieChart<?php echo $question_id;?>"></div>
<?php
			}

			foreach ($ans as $ans_id => $numOfAnswers) {
				$chartData[] = array($data['answers'][$ans_id]['answer'], $numOfAnswers);
			}
			$chartData = json_encode($chartData);
?>
			<script>
				    //set callback
				    google.setOnLoadCallback (function(){
				        //create data table object
				        var dataTable = new google.visualization.DataTable();

				        //define columns for first example
				        dataTable.addColumn('string');
				        dataTable.addColumn('number');

				        //define rows of data for first example
				        dataTable.addRows(<?php echo $chartData;?>);

				        //instantiate our chart objects
				        var pchart = new google.visualization.PieChart (document.getElementById('PieChart<?php echo $question_id;?>'));


				        //define options for visualization
				        var options = {width: 600, height: 400, is3D: true, title: ''};

				        //draw our chart charts
				        pchart.draw(dataTable, options);

				    });
			</script>
<?php
		endif;
		exit;
	}

}
add_action('wp_ajax_load_stats_by_question', 'load_stats_by_question_callback');
/*---------------------------------
* AJAX: load answers by question
*---------------------------------*/
function load_answers_by_question_callback() {
	if(isset($_POST['question_id']) && !empty($_POST['question_id'])){
		require 'model/question_model.php';
		$QuestionModel = new QuestionModel();
		$answers = $QuestionModel->get_answers_by_id($_POST['question_id']);
		$answersList = array();
		foreach ($answers as $answer) {
			$answersList[] = array('id'=>$answer['id'], 'text'=>$answer['answer'], 'weight'=>$answer['weight']);
		}
		$result = json_encode($answersList);
		echo $result;
		exit;
	}

	echo '[]'; exit;
}
add_action('wp_ajax_load_answers_by_question', 'load_answers_by_question_callback');


/*---------------------------------
* AJAX: read database and return json like sliding quiz format
*---------------------------------*/
function load_quiz_json_callback() {
	header('Content-Type: application/javascript');

	require 'model/json_quiz_model.php';
	$json_quiz = new JsonQuizModel($_REQUEST['quiz_id']);

	$script = 'jQuery(document).ready(function() { jQuery.noConflict(); jQuery("#quiz-%s").sliding_quiz (%s); });';
	echo sprintf($script, $_REQUEST['quiz_id'], $json_quiz->get_json_quiz());
	die();
}
add_action('wp_ajax_nopriv_load_quiz_json', 'load_quiz_json_callback');
add_action('wp_ajax_load_quiz_json', 'load_quiz_json_callback');


/*---------------------------------
* AJAX: save score
*---------------------------------*/
function quiz_submit_score_callback() {
	//print_r($_REQUEST);
	$user_id = (get_current_user_id()) ? get_current_user_id() : 0;
	$quiz_id = (isset($_REQUEST['quiz_id'])) ? $_REQUEST['quiz_id'] : array();
	$user_score = (isset($_REQUEST['user_score'])) ? $_REQUEST['user_score'] : 0;
	$results = (isset($_REQUEST['json_results'])) ? $_REQUEST['json_results'] : array();

	//unset($_COOKIE['wp_quiz_'.$quiz_id]);
	if(!isset($_COOKIE['wp_quiz_'.$quiz_id])){
		$_COOKIE['wp_quiz_'.$quiz_id] = $quiz_id;
		setcookie('wp_quiz_'.$quiz_id, $quiz_id);

		require 'model/statistic_model.php';
		$statistic_model = new StatisticModel();
		$statistic_model->insert_data($results,$quiz_id, $user_score, $user_id);
	}else{
		echo 'nope';
	}

	die();
}
add_action('wp_ajax_nopriv_quiz_submit_score', 'quiz_submit_score_callback');
add_action('wp_ajax_quiz_submit_score', 'quiz_submit_score_callback');

/*---------------------------------
* AJAX: send email to owner
*---------------------------------*/
function quiz_send_contact_mail_callback() {
	require 'vendors/PHPMailer/class.phpmailer.php';
	$mail = new PHPMailer;

	$quiz_mailer = (get_option('quiz_mailer_config')) ? unserialize(get_option('quiz_mailer_config')) : array();
	if( isset($quiz_mailer['host']) && !empty($quiz_mailer['host'])
		&& isset($quiz_mailer['username']) && !empty($quiz_mailer['username'])
		&& isset($quiz_mailer['password']) && !empty($quiz_mailer['password'])
	){
		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->Host     = $quiz_mailer['host'];  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $quiz_mailer['username'];                            // SMTP username
		$mail->Password = $quiz_mailer['password'];                           // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
	}

	$quiz_id = $_POST['quiz_id'];
	$name = $_POST['name'];
        $apellido = $_POST['apellido'];
	$email = ($_POST['email']) ? $_POST['email'] : 'test@gmail.com';
	$phone = $_POST['phone'];
	$message_post = $_POST['message'];

	//get ip
	require 'model/statistic_model.php';
	$statistic_model = new StatisticModel();
	$ip_address = $statistic_model->getRealIpAddr();

	$results = $_POST['json_results'];
	$score_table = '<table width="100%" border="1" cellspacing="0" cellpadding="0">';
	$score_table .= '<tr><th style="text-align:center; padding: 5px;"><strong>ID</strong></th><th style="text-align:center; padding: 5px;"><strong>Question</strong></th><th style="text-align:center; padding: 5px;"><strong>User Answer</strong></th><th style="text-align:center; padding: 5px;"><strong>Score</strong></th></tr>';
	foreach ($results as $res) {
		$score  = ($res['score'] > 0) ? 'Right' : 'Wrong';
		$score_table .= '<tr>';
		$score_table .= '<td style="text-align:center; padding: 5px;">'.$res['question_id'].'</td>';
		$score_table .= '<td style="text-align:center; padding: 5px;">'.$res['question'].'</td>';
		$score_table .= '<td style="text-align:center; padding: 5px;">'.$res['answer'].'</td>';
		$score_table .= '<td style="text-align:right; padding: 5px;">'.$score.'</td>';
		$score_table .= '</tr>';
	};
	$score_table .= '<tr>';
	$score_table .= '<td colspan="3" style="text-align:right; padding: 5px;font-weight:bold;">Total</td>';
	$score_table .= '<td style="text-align:right; padding: 5px;">'.$_POST['user_score'].'%</td>';
	$score_table .= '</tr>';
	$score_table .= '</table>';
	$message = '';
	$message .= '<table width="100%" border="0" cellpadding="0" cellspacing="10">';
	$message .= '<tr><td width="1%" nowrap="">IP Address:</td><td>&nbsp;&nbsp;'.$ip_address.'</td></tr>';
	$message .= '<tr><td width="1%" nowrap="">Name:</td><td>&nbsp;&nbsp;'.$name.'</td></tr>';
	$message .= '<tr><td width="1%" nowrap="">Email:</td><td>&nbsp;&nbsp;'.$email.'</td></tr>';
	$message .= '<tr><td width="1%" nowrap="">Phone:</td><td>&nbsp;&nbsp;'.$phone.'</td></tr>';
	$message .= '<tr><td width="1%" nowrap="">Message:</td><td>&nbsp;&nbsp;'.$message_post.'</td></tr>';
	$message .= '</table><br>'.$score_table;

	$mail->From = $email;
	$mail->FromName = 'WP Quiz';
	$sendto = (isset($quiz_mailer['sendto']) && !empty($quiz_mailer['sendto'])) ? $quiz_mailer['sendto'] : get_bloginfo( 'admin_email' );
	$mail->AddAddress($sendto, '');  // Add a recipient
	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Quiz #'.$quiz_id;
	$mail->Body    = $message;

	//echo $message;

	if(!$mail->Send()) {
	   echo 'Message could not be sent.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   //exit;
	}
else{
$conexion = mysql_connect("localhost", "havasmed_wrdp1","VPhbFuPB3J1Y3");
		mysql_select_db('havasmed_wrdp1') or die('No se pudo seleccionar la base de datos');

		$sql="insert into usuarios (nombre, apellidos, email, telefono,empresa) values ('$name', '$apellido', '$email', '$phone', '$message_post')";
		$result = mysql_query($sql) or die('Consulta fallida: ' . mysql_error());
		mysql_close($conexion);
}
        
	die();
}
add_action('wp_ajax_nopriv_quiz_send_contact_mail', 'quiz_send_contact_mail_callback');
add_action('wp_ajax_quiz_send_contact_mail', 'quiz_send_contact_mail_callback');
?>