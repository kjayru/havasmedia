<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );

/**
 * Adds AccessPress Twitter Feed Pro Widget
 */
class APTF_PRO_Slider_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
				'aptf_slider_widget', // Base ID
				__( 'AccessPress Tweets Slider', APTF_TD_PRO ), // Name
				array( 'description' => __( 'AccessPress Tweets Slider Widget', APTF_TD_PRO ) ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$controls = isset( $instance['controls'] ) ? $instance['controls'] : false;
		$slide_duration = (isset( $instance['slide_duration'] ) && $instance['slide_duration'] != '') ? $instance['slide_duration'] : '1500';
		$auto_slide = isset( $instance['auto_slide'] ) ? $instance['auto_slide'] : false;
		$template = isset( $instance['template'] ) ? $instance['template'] : 'template-1';
		$follow_button = (isset( $instance['follow_button'] ) && $instance['follow_button'] == 1) ? 'true' : 'false';
		$total_tweets = isset( $instance['total_tweets'] ) ? 'total_tweets = "'.$instance['total_tweets'].'"' : '';
		$username = (isset( $instance['twitter_username'] ) && $instance['twitter_username'] != '') ? 'username = "' . $instance['twitter_username'] . '"' : '';
                $adaptive_height = (isset( $instance['adaptive_height'] ) && $instance['adaptive_height']==1) ? $instance['adaptive_height'] : 'true';
		$slider_mode = (isset( $instance['slider_mode'] )) ? $instance['slider_mode'] : 'horizontal';
		echo do_shortcode( '[ap-twitter-feed-pro-slider auto_slide="' . $auto_slide . '" controls="' . $controls . '" slide_duration="' . $slide_duration . '" follow_button="' . $follow_button . '" template="' . $template . '" '.$total_tweets.' '.$username.' adaptive_height="'.$adaptive_height.'" slider_mode="'.$slider_mode.'"]' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$twitter_username = isset( $instance['twitter_username'] ) ? $instance['twitter_username'] : '';
		$total_tweets = isset($instance['total_tweets'])?$instance['total_tweets']:'';
		$controls = (isset( $instance['controls'] )) ? $instance['controls'] : 0;
		$adaptive_height = (isset( $instance['adaptive_height'] )) ? $instance['adaptive_height'] : 0;
		$slider_mode = (isset( $instance['slider_mode'] )) ? $instance['slider_mode'] : 'horizontal';
		$slide_duration = (isset( $instance['slide_duration'] )) ? $instance['slide_duration'] : '';
		$auto_slide = (isset( $instance['auto_slide'] )) ? $instance['auto_slide'] : 0;
		$template = isset( $instance['template'] ) ? $instance['template'] : 'template-1';
		$follow_button = isset( $instance['follow_button'] ) ? $instance['follow_button'] : 0;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>"><?php _e( 'Twitter Username:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" type="text" value="<?php echo esc_attr( $twitter_username ); ?>"/>
		</p>
		<p><i><?php _e( 'Note: Leave blank if you want to use the default username that is stored in the plugin\'s settings page.', APTF_TD_PRO ); ?></i></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'total_tweets' ); ?>"><?php _e( 'Total Tweets:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'total_tweets' ); ?>" name="<?php echo $this->get_field_name( 'total_tweets' ); ?>" type="number" value="<?php echo esc_attr( $total_tweets ); ?>"/>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'controls' ); ?>"><?php _e( 'Slider Controls:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'controls' ); ?>" name="<?php echo $this->get_field_name( 'controls' ); ?>" type="checkbox" value="1" <?php checked( $controls, true ); ?>/>
		</p>
                <p>
			<label for="<?php echo $this->get_field_id( 'adaptive_height' ); ?>"><?php _e( 'Adaptive Height:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'adaptive_height' ); ?>" name="<?php echo $this->get_field_name( 'adaptive_height' ); ?>" type="checkbox" value="1" <?php checked( $controls, true ); ?>/>
		</p>
                <p><?php _e('Note: Check if you want the slider to adjust height according to the slider content.',APTF_TD_PRO);?></p>
                <p>
			<label for="<?php echo $this->get_field_id( 'slider_mode' ); ?>"><?php _e( 'Slider Mode:', APTF_TD_PRO ); ?></label> 
                        <select class="widefat" id="<?php echo $this->get_field_id( 'slider_mode' ); ?>" name="<?php echo $this->get_field_name( 'slider_mode' ); ?>">
                            <option value="horizontal" <?php selected( $slider_mode, 'horizontal' ); ?>><?php _e('Slide',APTF_TD_PRO);?></option>
                            <option value="fade" <?php selected( $slider_mode, 'fade'); ?>><?php _e('Fade',APTF_TD_PRO);?></option>
                        </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'slide_duration' ); ?>"><?php _e( 'Slide Duration:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'slide_duration' ); ?>" name="<?php echo $this->get_field_name( 'slide_duration' ); ?>" type="text" placeholder="e.g: 1000" value="<?php echo $slide_duration; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'auto_slide' ); ?>"><?php _e( 'Auto Slide:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'auto_slide' ); ?>" name="<?php echo $this->get_field_name( 'auto_slide' ); ?>" type="checkbox" value="1" <?php checked( $auto_slide, true ); ?>/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Template:', APTF_TD_PRO ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'template' ); ?>" name="<?php echo $this->get_field_name( 'template' ); ?>" >
				<?php for ( $i = 1; $i <= 10; $i++ ) {
					?>
					<option value="template-<?php echo $i; ?>" <?php selected( $template, 'template-' . $i ); ?>>Template <?php echo $i; ?></option>
					<?php }
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'follow_button' ); ?>"><?php _e( 'Display Follow Button:', APTF_TD_PRO ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'follow_button' ); ?>" name="<?php echo $this->get_field_name( 'follow_button' ); ?>" type="checkbox" value="1" <?php checked( $follow_button, true ); ?>/>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
//        echo "<pre>";
//        die(print_r($new_instance,true));
		$instance = array();
		$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['twitter_username'] = isset( $new_instance['twitter_username'] ) ? $new_instance['twitter_username'] : '';
		$instance['total_tweets'] = isset( $new_instance['total_tweets'] ) ? $new_instance['total_tweets'] : '';
		$instance['slide_duration'] = isset( $new_instance['slide_duration'] ) ? sanitize_text_field( $new_instance['slide_duration'] ) : '';
		$instance['template'] = isset( $new_instance['template'] ) ? $new_instance['template'] : '';
		$instance['controls'] = isset( $new_instance['controls'] ) ? $new_instance['controls'] : 0;
                $instance['adaptive_height'] = (isset( $new_instance['adaptive_height'] )) ? $new_instance['adaptive_height'] : 0;
                $instance['slider_mode'] = (isset( $new_instance['slider_mode'] )) ? $new_instance['slider_mode'] : 'horizontal';
		$slider_mode = (isset( $instance['slider_mode'] )) ? $instance['slider_mode'] : 'horizontal';
		$instance['auto_slide'] = isset( $new_instance['auto_slide'] ) ? $new_instance['auto_slide'] : 0;
		$instance['follow_button'] = isset( $new_instance['follow_button'] ) ? $new_instance['follow_button'] : 0;

		return $instance;
	}

}

// class APS_PRO_Widget
?>