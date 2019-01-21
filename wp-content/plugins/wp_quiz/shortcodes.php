<?php
function high_priority_style() {
    wp_register_style('slidingquiz_css', plugins_url('/assets/css/wp.quiz.min.css', __FILE__));
    wp_enqueue_style('slidingquiz_css');
}
add_action('wp_enqueue_scripts', 'high_priority_style', '999');
/*---------------------------------
* Shortcode
*---------------------------------*/
function wp_quiz_shortcode($atts, $content=null)
{
    $pluginURL   = plugins_url('wp_quiz');

    // Use the latest jQuery version from Google
    wp_deregister_script('jquery');
    wp_register_script('jquery', $pluginURL.'/assets/js/jquery.min.js');
    wp_enqueue_script('jquery');

    wp_enqueue_script( 'jquery_base64', $pluginURL.'/assets/js/jquery.base64.min.js', array('jquery'));

    //register sliding quiz
    wp_register_script('slidingquiz', $pluginURL.'/assets/js/sliding.quiz.min.js', array('jquery') );
    wp_localize_script('slidingquiz', 'wpQuiz', array( 'pluginURL' => $pluginURL, 'ajaxURL' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('slidingquiz');

    $quiz_id = $atts['id'];
    wp_enqueue_script('slidingquiz_'.$quiz_id, admin_url( 'admin-ajax.php' )."?action=load_quiz_json&quiz_id=".$quiz_id, array('jquery'), false, true);
    return '<div id="quiz-'.$quiz_id.'"></div>';
}
add_shortcode('wp_quiz', 'wp_quiz_shortcode');


/*---------------------------------
// check the current post for the existence of a short code
*---------------------------------*/
function check_shortcode( $shortcode = NULL ) {

    $post_to_check = get_post( get_the_ID() );

    // false because we have to search through the post content first
    $found = false;

    // if no short code was provided, return false
    if ( ! $shortcode ) {
        return $found;
    }
    // check the post content for the short code
    if ( stripos( $post_to_check->post_content, '[' . $shortcode) !== FALSE ) {
        // we have found the short code
        $found = TRUE;
    }

    // return our final results
    return $found;
}
/*---------------------------------
* load config and paste to hidden field,
* then jquery read data from this field
*---------------------------------*/
function include_wp_quiz_settings(){
	//if(check_shortcode('wp_quiz')) {
    if ( shortcode_exists( 'wp_quiz' ) ) {
		$interface = ( get_option('quiz_interface_config') ) ? json_encode(unserialize(get_option('quiz_interface_config'))) : '';
		echo '<input type="hidden" value="'.base64_encode($interface).'" id="wp_quiz_interface_config" /></div>';
	}
}
add_action('wp_footer', 'include_wp_quiz_settings');

?>