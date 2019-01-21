<?php
//$this->print_array($atts);
$aptf_pro_settings = $this->aptf_pro_settings;
$username = isset($atts['username']) ? $atts['username'] : $aptf_pro_settings['twitter_username'];
$total_feeds = isset($atts['total_feeds']) ? $atts['total_feeds'] : $aptf_pro_settings['total_feed'];
$tweets = $this->get_twitter_tweets($username, $total_feeds);
//$this->print_array($tweets);die();
if (isset($atts['template'])) {
    $aptf_pro_settings['feed_template'] = $atts['template'];
}
if (isset($atts['follow_button'])) {
    if ($atts['follow_button'] == 'true') {
        $aptf_pro_settings['display_follow_button'] = 1;
    } else {
        $aptf_pro_settings['display_follow_button'] = 0;
    }
}
if (isset($tweets['errors'])) {
    $fallback_message = $aptf_pro_settings['fallback_message'];
    $fallback_message = ($fallback_message != '') ? $fallback_message : __('Something went wrong with the twitter.', APTF_TD_PRO);
    ?>
    <p><?php echo $fallback_message; ?></p>
    <?php
} else {
    ?>
    <div class="aptf-tweets-wrapper aptf-<?php echo $aptf_pro_settings['feed_template'];?>">
    <?php
//var_dump($tweets);
    $template = $aptf_pro_settings['feed_template'] . '.php';
//$this->print_array($tweets);
    include('templates/default/' . $template);
    ?>
        <?php
        if (isset($aptf_pro_settings['display_follow_button']) && $aptf_pro_settings['display_follow_button'] == 1) {
            include(plugin_dir_path(__FILE__) . '/templates/follow-btn.php');
        }
        ?>
    </div><!--aptf-tweets-wrapper-->
        <?php
    }
    ?>

