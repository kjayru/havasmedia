<div class="aptf-single-board-wrapper" id="aptf-settings-board">
    <h3><?php _e('Settings', APTF_TD_PRO); ?></h3>
    <div class="aptf-option-wrapper">
        <label>Twitter Consumer Key</label>
        <div class="aptf-option-field">
            <input type="text" name="consumer_key" value="<?php echo esc_attr($aptf_pro_settings['consumer_key']); ?>"/>
            <div class="aptf-option-note"><?php _e('Please create an app on Twitter through this link:', APTF_TD_PRO); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a><?php _e(' and get this information.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label>Twitter Consumer Secret</label>
        <div class="aptf-option-field">
            <input type="text" name="consumer_secret" value="<?php echo esc_attr($aptf_pro_settings['consumer_secret']); ?>"/>
            <div class="aptf-option-note"><?php _e('Please create an app on Twitter through this link:', APTF_TD_PRO); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a><?php _e(' and get this information.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label>Twitter Access Token</label>
        <div class="aptf-option-field">
            <input type="text" name="access_token" value="<?php echo esc_attr($aptf_pro_settings['access_token']); ?>"/>
            <div class="aptf-option-note"><?php _e('Please create an app on Twitter through this link:', APTF_TD_PRO); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a><?php _e(' and get this information.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label>Twitter Access Token Secret</label>
        <div class="aptf-option-field">
            <input type="text" name="access_token_secret" value="<?php echo esc_attr($aptf_pro_settings['access_token_secret']); ?>"/>
            <div class="aptf-option-note"><?php _e('Please create an app on Twitter through this link:', APTF_TD_PRO); ?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a><?php _e(' and get this information.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Twitter Username',APTF_TD_PRO);?></label>
        <div class="aptf-option-field">
            <input type="text" name="twitter_username" value="<?php echo isset($aptf_pro_settings['twitter_username']) ? $aptf_pro_settings['twitter_username'] : ''; ?>" placeholder="e.g: @apthemes"/>
            <div class="aptf-option-note"><?php _e('Please enter the username of twitter account from which the feeds need to be fetched.For example:@apthemes', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label>Cache Period</label>
        <div class="aptf-option-field">
            <input type="text" name="cache_period" value="<?php echo esc_attr($aptf_pro_settings['cache_period']); ?>" placeholder="e.g: 60"/>
            <div class="aptf-option-note"><?php _e('Please enter the time period in minutes in which the feeds should be fetched.Default is 60 Minutes', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Total Number of Feed', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="number" name="total_feed" value="<?php echo isset($aptf_pro_settings['total_feed']) ? esc_attr($aptf_pro_settings['total_feed']) : ''; ?>" placeholder="e.g: 5"/>
            <div class="aptf-option-note"><?php _e('Please enter the number of feeds to be fetched.Default number of feeds is 5.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Feeds Template', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <select  name="feed_template" id="aptf-themeTemplateSelection" data-theme-image-dir="<?php echo APTF_PRO_IMAGE_DIR ?>/themePreview/">
                <?php for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <option value="template-<?php echo $i;?>" <?php selected($aptf_pro_settings['feed_template'],'template-'.$i);?>>Template <?php echo $i;?></option>
                    <?php
                }
                ?>
            </select>
            <br />
            <img id="aptf-themeImagePreview" class="aptf-theme-preview" src="<?php echo APTF_PRO_IMAGE_DIR ?>/themePreview/<?php echo $aptf_pro_settings['feed_template'] ?>.jpg" alt="<?php echo $aptf_pro_settings['feed_template'] ?>" />
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Time Format', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <label><input type="radio" name="time_format" value="full_date" <?php checked($aptf_pro_settings['time_format'],'full_date');?>/><?php _e('Full Date and Time: <span>e.g March 10, 2001, 5:16 pm</span>', APTF_TD_PRO); ?></label>
            <label><input type="radio" name="time_format" value="date_only" <?php checked($aptf_pro_settings['time_format'],'date_only');?>/><?php _e('Date only: <span>e.g March 10, 2001</span>', APTF_TD_PRO); ?></label>
            <label><input type="radio" name="time_format" value="elapsed_time" <?php checked($aptf_pro_settings['time_format'],'elapsed_time');?>/><?php _e('Elapsed Time: <span>e.g 12 hours ago</span>', APTF_TD_PRO); ?></label>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Display Username', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="checkbox" name="display_username" value="1" <?php checked($aptf_pro_settings['display_username'],true);?>/>
            <div class="aptf-option-note"><?php _e('Check if you want to show your username in each tweet', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Display Twitter Actions(Reply, Retweet, Favorite)', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="checkbox" name="display_twitter_actions" value="1" <?php checked($aptf_pro_settings['display_twitter_actions'],true);?>/>
            <div class="aptf-option-note"><?php _e('Check if you want to display twitter actions', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Fallback Unavailable Message', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="text" name="fallback_message" value="<?php echo isset($aptf_pro_settings['fallback_message']) ? esc_attr($aptf_pro_settings['fallback_message']) : ''; ?>"/>
            <div class="aptf-option-note"><?php _e('Please enter the message to display if the twitter is unavailable sometime.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Display Twitter Follow Button', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="checkbox" name="display_follow_button" value="1" <?php checked($aptf_pro_settings['display_follow_button'],true);?>/>
            <div class="aptf-option-note"><?php _e('Check if you want to display twitter follow button at the end of the feeds', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Exclude Lightbox JS and CSS', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="checkbox" name="exclude_lightbox" value="1" <?php checked($aptf_pro_settings['exclude_lightbox'],true);?>/>
            <div class="aptf-option-note"><?php _e('Check only if you already have lightbox integrated in your theme and for preventing any conflicts regarding the lighbox with your theme.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    <div class="aptf-option-wrapper">
        <label><?php _e('Exclude BX Slider JS and CSS', APTF_TD_PRO); ?></label>
        <div class="aptf-option-field">
            <input type="checkbox" name="exclude_slider" value="1" <?php checked($aptf_pro_settings['exclude_slider'],true);?>/>
            <div class="aptf-option-note"><?php _e('Check only if you already have bxslider integrated in your theme and for preventing any conflicts regarding the slider with your theme.', APTF_TD_PRO); ?></div>
        </div>
    </div>
    

</div>