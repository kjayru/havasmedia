<?php

class Load {
	function view( $file_name, $data = null , $loadCSS=true)
	{
		if( is_array($data) ) {
			extract($data);
		}

		if($loadCSS){
			$pluginURL = plugins_url('wp_quiz');
			echo '<link rel="stylesheet" href="'.$pluginURL.'/assets/css/backend.css">';
		}

		include WP_QUIZ_PATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR. $file_name;
		//if(isset($_SESSION['quiz_flash'])){ unset($_SESSION['quiz_flash']); }
	}
}