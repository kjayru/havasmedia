<?php
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.'quiz_model.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'app_controller.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'Quiz_List_Table.php';
require WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'Quiz_Statistic_List_Table.php';
class QuizController extends AppController{
	private $QuizModel;
	public function __construct()
	{
		$this->QuizModel = new QuizModel();
		parent::__construct();
	}

	public function index()
	{
		//Prepare Table of elements
		$wp_list_table = new Quiz_List_Table();
		$wp_list_table->prepare_items();
		$this->load->view('quiz/list.php', array('wp_list_table'=>$wp_list_table));
	}

	public function add()
	{
		if(isset($_POST['data']) && !empty($_POST['data'])){
			$_POST = stripslashes_deep($_POST);
			if($this->QuizModel->insert_data($_POST['data'])){
				$this->set_flash(__('Data has been saved!'));
			}else{
				$this->set_flash(__('Something went wrong!'), 'error');
			}
			$url = admin_url('admin.php?page=wordpress-quiz');
			wp_redirect($url);
		}
		$this->load->view('quiz/add.php', null);
	}

	public function edit()
	{
		if(isset($_POST['data']) && !empty($_POST['data'])){
			$_POST = stripslashes_deep($_POST);
			$upd = $this->QuizModel->update_data($_POST['data']);
			$this->set_flash(__('Quiz has been saved!'));
			$url = admin_url('admin.php?page=wordpress-quiz');
			wp_redirect($url);
		}

		// check id parameter
		$id = (isset($_GET['wp_quiz_id'])) ? $_GET['wp_quiz_id'] : false;
		if(!$id){
			$url = admin_url('admin.php?page=wordpress-quiz');
			$this->set_flash(__('Invalid Id'), 'error');
			wp_redirect($url);
		}

		// get data by id, then bind to form
		$data = $this->QuizModel->get_data_by_id($id);

		$this->load->view('quiz/edit.php', $data);
	}

	public function delete()
	{
		if(isset($_POST['data']['id']) && !empty($_POST['data']['id'])){
			$upd = $this->QuizModel->delete_data($_POST['data']['id']);
			$this->set_flash(__('Quiz deleted!'));
			$url = admin_url('admin.php?page=wordpress-quiz');
			wp_redirect($url);
		}

		$id = (isset($_GET['wp_quiz_id'])) ? $_GET['wp_quiz_id'] : false;
		if(!$id){
			$url = admin_url('admin.php?page=wordpress-quiz');
			$this->set_flash(__('Invalid Id'), 'error');
			wp_redirect($url);
		}

		$data = $this->QuizModel->get_data_by_id($id);
		$this->load->view('quiz/delete.php', $data);
	}

	public function statistic()
	{
		$id = (isset($_GET['wp_quiz_id'])) ? $_GET['wp_quiz_id'] : false;
		if(!$id){
			$url = admin_url('admin.php?page=wordpress-quiz');
			$this->set_flash(__('Invalid Id'));
			wp_redirect($url);
		}

		$wp_list_table = new Quiz_Statistic_List_Table($id);
		$wp_list_table->prepare_items();
		$data['wp_list_table'] = $wp_list_table;
		$data['quiz'] = $this->QuizModel->get_data_by_id($id);
		$data['statistic'] = $this->QuizModel->get_quiz_statistic($id);
		$this->load->view('quiz/statistic.php', $data);
	}

	private function array2csv(array &$array)
	{
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

	public function export()
	{
		$id = (isset($_GET['wp_quiz_id'])) ? $_GET['wp_quiz_id'] : false;
		if(!$id){
			$url = admin_url('admin.php?page=wordpress-quiz');
			$this->set_flash(__('Invalid Id'));
			wp_redirect($url);
		}

		ob_clean();
	    // disable caching
	    $now = gmdate("D, d M Y H:i:s");
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	    header("Last-Modified: {$now} GMT");

	    // force download
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");

	    // disposition / encoding on response body
	    $filename = "data_export_" . date("Y-m-d") . ".csv";
	    header("Content-Disposition: attachment;filename={$filename}");
	    header("Content-Transfer-Encoding: binary");

	    $data = $this->QuizModel->data2export($id);
	    $exportData = array();
	    foreach ($data as $idx => $d) {
	    	$csv = array();
	    	$csv['user_id'] = $d['user_id'];
	    	if($d['user_id']){
		        $user = get_userdata( $d['user_id'] );

	            $display_name = ($user->display_name) ? $user->display_name : $user->user_login;

	            $d['name'] = $display_name;
	    	}else{
	            $d['name'] = 'Anonymous';
	    	}
	    	$csv['name'] = $d['name'];
	    	$csv['score'] = $d['score'];
	    	$csv['created'] = $d['created'];
	    	$exportData[] = $csv;
	    }
	    //echo '<pre>'; print_r($exportData);echo '</pre>';exit;
	    echo $this->array2csv($exportData);
	    exit;
	}
}

?>