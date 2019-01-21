<?php

class AppController {
	public $load;

	protected function __construct()
	{
		$this->load = new Load();

		// determine what page you're on
		$action = (isset($_GET['action']) && $_GET['action']) ? $_GET['action'] : 'index';

		$this->$action();
	}


	/**
	* set flash message
	* @type: error, success, info
	* find out more here: http://twitter.github.com/bootstrap/components.html#alerts
	*/
	protected function set_flash($value='', $status='updated')
	{
		//$mess = '<div class="alert alert-%s">%s</div>';
		$mess = '<div id="message" class="'.$status.' below-h2"><p>%s</p></div>';
		$mess = sprintf($mess, $value);
		if(isset($_SESSION['quiz_flash'])){ unset($_SESSION['quiz_flash']); }
		$_SESSION['quiz_flash'] = $mess;
	}
}
?>