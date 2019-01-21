<?php
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Adds AccessPress Twitter Feed Pro Widget
 */
class APTF_PRO_Ticker_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'aptf_ticker_widget', // Base ID
                __('AccessPress Tweets Ticker', APTF_TD_PRO), // Name
                array('description' => __('AccessPress Tweets Ticker Widget', APTF_TD_PRO)) // Args
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
    public function widget($args, $instance) {

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        //APTF_PRO_Class::print_array( $instance );
        $username = (isset($instance['twitter_username']) && $instance['twitter_username'] != '') ? 'username = "' . $instance['twitter_username'] . '"' : '';
        $ticker_speed = (isset($instance['ticker_speed']) && $instance['ticker_speed'] != '') ? $instance['ticker_speed'] : '6000';
        $mouse_pause = (isset($instance['mouse_pause']) && $instance['mouse_pause'] == 1) ? '1' : '0';
        $template = isset($instance['template']) ? $instance['template'] : 'template-1';
        $follow_button = (isset($instance['follow_button']) && $instance['follow_button'] == 1) ? 'true' : 'false';
        $total_tweets = isset($instance['total_tweets']) ? 'total_tweets = "' . $instance['total_tweets'] . '"' : '';
        $visible_tweets = isset($instance['visible_tweets']) ? $instance['visible_tweets'] : '1';
        $ticker_direction = isset($instance['ticker_direction']) ? $instance['ticker_direction'] : 'up';
        $controls = isset($instance['controls']) ? $instance['controls'] : 0;
        echo do_shortcode('[ap-twitter-feed-pro-ticker ticker_speed="' . $ticker_speed . '" mouse_pause="' . $mouse_pause . '" follow_button="' . $follow_button . '" template="' . $template . '" ' . $username . ' ' . $total_tweets . ' visible_tweets="' . $visible_tweets . '" direction="' . $ticker_direction . '"]');
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $twitter_username = isset($instance['twitter_username']) ? $instance['twitter_username'] : '';
        $ticker_speed = (isset($instance['ticker_speed'])) ? $instance['ticker_speed'] : '';
        $mouse_pause = (isset($instance['mouse_pause'])) ? $instance['mouse_pause'] : 0;
        $template = isset($instance['template']) ? $instance['template'] : 'template-1';
        $follow_button = isset($instance['follow_button']) ? $instance['follow_button'] : 0;
        $total_tweets = isset($instance['total_tweets']) ? $instance['total_tweets'] : '';
        $visible_tweets = isset($instance['visible_tweets']) ? $instance['visible_tweets'] : '';
        $ticker_direction = isset($instance['ticker_direction']) ? $instance['ticker_direction'] : 'up';
        $controls = isset($instance['controls']) ? $instance['controls'] : 0;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter_username'); ?>"><?php _e('Twitter Username:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" type="text" value="<?php echo esc_attr($twitter_username); ?>"/>
        </p>
        <p><i><?php _e('Note: Leave blank if you want to use the default username that is stored in the plugin\'s settings page.', APTF_TD_PRO); ?></i></p>
        <p>
            <label for="<?php echo $this->get_field_id('total_tweets'); ?>"><?php _e('Total Tweets:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('total_tweets'); ?>" name="<?php echo $this->get_field_name('total_tweets'); ?>" type="number" value="<?php echo esc_attr($total_tweets); ?>"/>

        </p>
        <p>
            <label for="<?php echo $this->get_field_id('visible_tweets'); ?>"><?php _e('Visible Tweets:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('visible_tweets'); ?>" name="<?php echo $this->get_field_name('visible_tweets'); ?>" type="number" value="<?php echo esc_attr($visible_tweets); ?>"/>
        </p>
        <p><i><?php _e('Please enter the number of tweets that you want to show in the ticker display area.Default is 1', APTF_TD_PRO); ?></i></p>
        <p>
            <label for="<?php echo $this->get_field_id('ticker_direction'); ?>"><?php _e('Ticker Direction:', APTF_TD_PRO); ?></label> 
            <select name="<?php echo $this->get_field_name('ticker_direction'); ?>">
                <option value="up" <?php selected($ticker_direction, 'up'); ?>>Up</option>
                <option value="down" <?php selected($ticker_direction, 'down'); ?>>Down</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('ticker_speed'); ?>"><?php _e('Ticker Transition Duration:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('ticker_speed'); ?>" name="<?php echo $this->get_field_name('ticker_speed'); ?>" type="text" placeholder="e.g: 6000" value="<?php echo $ticker_speed; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('mouse_pause'); ?>"><?php _e('Pause on Mouse Hover:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('mouse_pause'); ?>" name="<?php echo $this->get_field_name('mouse_pause'); ?>" type="checkbox" value="1" <?php checked($mouse_pause, true); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('controls'); ?>"><?php _e('Display Controls:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('controls'); ?>" name="<?php echo $this->get_field_name('controls'); ?>" type="checkbox" value="1" <?php checked($controls, true); ?>/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e('Template:', APTF_TD_PRO); ?></label> 
            <select class="widefat" id="<?php echo $this->get_field_id('template'); ?>" name="<?php echo $this->get_field_name('template'); ?>" >
        <?php for ($i = 1; $i <= 10; $i++) {
            ?>
                    <option value="template-<?php echo $i; ?>" <?php selected($template, 'template-' . $i); ?>>Template <?php echo $i; ?></option>
                <?php }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('follow_button'); ?>"><?php _e('Display Follow Button:', APTF_TD_PRO); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('follow_button'); ?>" name="<?php echo $this->get_field_name('follow_button'); ?>" type="checkbox" value="1" <?php checked($follow_button, true); ?>/>
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
    public function update($new_instance, $old_instance) {
//        echo "<pre>";
//        die(print_r($new_instance,true));
        $instance = array();
        $instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['twitter_username'] = isset($new_instance['twitter_username']) ? $new_instance['twitter_username'] : '';
        $instance['total_tweets'] = isset($new_instance['total_tweets']) ? $new_instance['total_tweets'] : '';
        $instance['visible_tweets'] = isset($new_instance['visible_tweets']) ? $new_instance['visible_tweets'] : '';
        $instance['ticker_direction'] = isset($new_instance['ticker_direction']) ? $new_instance['ticker_direction'] : 'up';
        $instance['controls'] = isset($new_instance['controls']) ? $new_instance['controls'] : 0;
        $instance['ticker_speed'] = isset($new_instance['ticker_speed']) ? sanitize_text_field($new_instance['ticker_speed']) : '';
        $instance['mouse_pause'] = isset($new_instance['mouse_pause']) ? $new_instance['mouse_pause'] : 0;
        $instance['template'] = isset($new_instance['template']) ? $new_instance['template'] : '';
        $instance['follow_button'] = isset($new_instance['follow_button']) ? $new_instance['follow_button'] : 0;

        return $instance;
    }

}

// class APS_PRO_Widget
?>