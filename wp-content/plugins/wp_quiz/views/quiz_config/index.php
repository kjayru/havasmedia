<?php $pluginURL = plugins_url('wp_quiz');?>
<div class="wrap" ng-app="question_answers">
	<h2>Configuration</h2>
	<?php  if(isset($_SESSION['quiz_flash'])){ echo $_SESSION['quiz_flash'];  } ?>
	<div id="ajax-response"></div>
	<form method="post" name="myForm" id="myForm" class="configuration-form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="resetAction" id="resetAction" value="no">
		<p class="submit">
			<input type="button" name="save" onclick="document.getElementById('resetAction').value = ''; document.myForm.submit();" class="button button-primary" value="Save">
			<input type="button" name="reset2default" onclick="if(confirm('Are you sure?')){ document.getElementById('resetAction').value='reset'; document.myForm.submit(); }" class="button" value="Reset to default">
		</p>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-2">Interface</a></li>
				<li><a href="#tabs-1">Localization</a></li>
				<li><a href="#tabs-3">Email</a></li>
			</ul>
			<div id="tabs-2">
				<table class="form-table">
					<tbody>
						<td colspan="2"><h3>General</h3></td>
						<tr class="form-field form-required">
							<th scope="row"><label for="background">Background</label></th>
							<td><input name="data[interface][background]" class="interface_picker" type="text" value="<?php echo $data['interface']['background'];?>" id="background"><span class="colorSelector" rel="#<?php echo $data['interface']['background'];?>" style="background: #<?php echo $data['interface']['background'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="color">Color</label></th>
							<td><input name="data[interface][color]" class="interface_picker" type="text" value="<?php echo $data['interface']['color'];?>" id="color"><span class="colorSelector" rel="#<?php echo $data['interface']['color'];?>" style="background: #<?php echo $data['interface']['color'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="border">Border</label></th>
							<td><input name="data[interface][border]" class="interface_picker" type="text" value="<?php echo $data['interface']['border'];?>" id="border"><span class="colorSelector" rel="#<?php echo $data['interface']['border'];?>" style="background: #<?php echo $data['interface']['border'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="transparent">Transparent</label></th>
							<td>
								<select name="data[interface][transparent]"  id="transparent">
									<option <?php if($data['interface']['transparent'] == "yes") echo "selected='selected'";?> value="yes">Yes</option>
									<option <?php if($data['interface']['transparent'] == "no") echo "selected='selected'";?> value="no">No</option>
								</select>
							</td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="footer_bg">Navigation Background</label></th>
							<td><input name="data[interface][navigation_bg]" class="interface_picker" type="text" value="<?php echo $data['interface']['navigation_bg'];?>" id="navigation_bg"><span class="colorSelector" rel="#<?php echo $data['interface']['navigation_bg'];?>" style="background: #<?php echo $data['interface']['navigation_bg'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="footer_bg">Footer Background</label></th>
							<td><input name="data[interface][footer_bg]" class="interface_picker" type="text" value="<?php echo $data['interface']['footer_bg'];?>" id="footer_bg"><span class="colorSelector" rel="#<?php echo $data['interface']['footer_bg'];?>" style="background: #<?php echo $data['interface']['footer_bg'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="progress_bar">Progress Bar</label></th>
							<td><input name="data[interface][progress_bar]" class="interface_picker" type="text" value="<?php echo $data['interface']['progress_bar'];?>" id="progress_bar"><span class="colorSelector" rel="#<?php echo $data['interface']['progress_bar'];?>" style="background: #<?php echo $data['interface']['progress_bar'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="pop_up_border">Review Question Popup Border</label></th>
							<td><input name="data[interface][pop_up_border]" class="interface_picker" type="text" value="<?php echo $data['interface']['pop_up_border'];?>" id="pop_up_border"><span class="colorSelector" rel="#<?php echo $data['interface']['pop_up_border'];?>" style="background: #<?php echo $data['interface']['pop_up_border'];?>;">&nbsp;</span></td>
						</tr>
						<td colspan="2"><h3>Question</h3></td>
						<tr class="form-field form-required">
							<th scope="row"><label for="question_bg">Background</label></th>
							<td><input name="data[interface][question_bg]"  class="interface_picker" type="text" value="<?php echo $data['interface']['question_bg'];?>" id="question_bg"><span class="colorSelector" rel="#<?php echo $data['interface']['question_bg'];?>" style="background: #<?php echo $data['interface']['question_bg'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="question_color">Color</label></th>
							<td><input name="data[interface][question_color]" class="interface_picker" type="text" value="<?php echo $data['interface']['question_color'];?>" id="question_color"><span class="colorSelector" rel="#<?php echo $data['interface']['question_color'];?>" style="background: #<?php echo $data['interface']['question_color'];?>;">&nbsp;</span></td>
						</tr>
						<td colspan="2"><h3>Answers</h3></td>
						<tr class="form-field form-required">
							<th scope="row"><label for="answer_bg">Background</label></th>
							<td><input name="data[interface][answer_bg]"  class="interface_picker" type="text" value="<?php echo $data['interface']['answer_bg'];?>" id="answer_bg"><span class="colorSelector" rel="#<?php echo $data['interface']['answer_bg'];?>" style="background: #<?php echo $data['interface']['answer_bg'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="answer_selected_bg">Selected Background</label></th>
							<td><input name="data[interface][answer_selected_bg]" class="interface_picker" type="text" value="<?php echo $data['interface']['answer_selected_bg'];?>" id="answer_selected_bg"><span class="colorSelector" rel="#<?php echo $data['interface']['answer_selected_bg'];?>" style="background: #<?php echo $data['interface']['answer_selected_bg'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="answer_color">Color</label></th>
							<td><input name="data[interface][answer_color]" class="interface_picker" type="text" value="<?php echo $data['interface']['answer_color'];?>" id="answer_color"><span class="colorSelector" rel="#<?php echo $data['interface']['answer_color'];?>" style="background: #<?php echo $data['interface']['answer_color'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="answer_selected_color">Selected Color</label></th>
							<td><input name="data[interface][answer_selected_color]" class="interface_picker" type="text" value="<?php echo $data['interface']['answer_selected_color'];?>" id="answer_selected_color"><span class="colorSelector" rel="#<?php echo $data['interface']['answer_selected_color'];?>" style="background: #<?php echo $data['interface']['answer_selected_color'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="answer_border">Border Color</label></th>
							<td><input name="data[interface][answer_border]" class="interface_picker" type="text" value="<?php echo $data['interface']['answer_border'];?>" id="answer_border"><span class="colorSelector" rel="#<?php echo $data['interface']['answer_border'];?>" style="background: #<?php echo $data['interface']['answer_border'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="answer_selected_border">Selected Border Color</label></th>
							<td><input name="data[interface][answer_selected_border]" class="interface_picker" type="text" value="<?php echo $data['interface']['answer_selected_border'];?>" id="answer_selected_border"><span class="colorSelector" rel="#<?php echo $data['interface']['answer_selected_border'];?>" style="background: #<?php echo $data['interface']['answer_selected_border'];?>;">&nbsp;</span></td>
						</tr>
						<td colspan="2"><h3>Button</h3></td>
						<tr class="form-field form-required">
							<th scope="row"><label for="button_bg">Background</label></th>
							<td><input name="data[interface][button_bg]" class="interface_picker" type="text" value="<?php echo $data['interface']['button_bg'];?>" id="button_bg"><span class="colorSelector" rel="#<?php echo $data['interface']['button_bg'];?>" style="background: #<?php echo $data['interface']['button_bg'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="button_bg_hover">MouserOver Background</label></th>
							<td><input name="data[interface][button_bg_hover]" class="interface_picker" type="text" value="3597c5" id="button_bg_hover"><span class="colorSelector" rel="#3597c5" style="background: #3597c5;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="button_color">Color</label></th>
							<td><input name="data[interface][button_color]" class="interface_picker" type="text" value="<?php echo $data['interface']['button_color'];?>" id="button_color"><span class="colorSelector" rel="#<?php echo $data['interface']['button_color'];?>" style="background: #<?php echo $data['interface']['button_color'];?>;">&nbsp;</span></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="button_color_hover">MouseOver Color</label></th>
							<td><input name="data[interface][button_color_hover]" class="interface_picker" type="text" value="<?php echo $data['interface']['button_color_hover'];?>" id="button_color_hover"><span class="colorSelector" rel="#<?php echo $data['interface']['button_color_hover'];?>" style="background: #<?php echo $data['interface']['button_color_hover'];?>;">&nbsp;</span></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="tabs-1">
				<table class="form-table">
					<tbody>
						<td colspan="2"><h3>General</h3></td>
						<tr class="form-field form-required">
							<th scope="row"><label for="not_found">No Question <span class="description"></span></label></th>
							<td><input name="data[locale][msg_not_found]" type="text" value="<?php echo $data['locale']['msg_not_found'];?>" id="not_found"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="select_an_option">Select Option <span class="description"></span></label></th>
							<td><input name="data[locale][msg_please_select_an_option]" type="text" value="<?php echo $data['locale']['msg_please_select_an_option'];?>" id="select_an_option"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="question">Question <span class="description"></span></label></th>
							<td><input name="data[locale][msg_question]" type="text" value="<?php echo $data['locale']['msg_question'];?>" id="question"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="share_scored">Share Message <span class="description"></span></label></th>
							<td><input name="data[locale][msg_share_scored]" type="text" value="<?php echo $data['locale']['msg_share_scored'];?>" id="share_scored"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="click_to_review">Click To Review<span class="description"></span></label></th>
							<td><input name="data[locale][msg_click_to_review]" type="text" value="<?php echo $data['locale']['msg_click_to_review'];?>" id="click_to_review"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="hint">Hint <span class="description"></span></label></th>
							<td><input name="data[locale][hint]" type="text" value="<?php echo $data['locale']['hint'];?>" id="hint"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="bt_start">Start Button <span class="description"></span></label></th>
							<td><input name="data[locale][bt_start]" type="text" value="<?php echo $data['locale']['bt_start'];?>" id="bt_start"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="bt_next">Next Button <span class="description"></span></label></th>
							<td><input name="data[locale][bt_next]" type="text" value="<?php echo $data['locale']['bt_next'];?>" id="bt_next"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="bt_back">Back Button <span class="description"></span></label></th>
							<td><input name="data[locale][bt_back]" type="text" value="<?php echo $data['locale']['bt_back'];?>" id="bt_back"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="bt_finish">Finish Button <span class="description"></span></label></th>
							<td><input name="data[locale][bt_finish]" type="text" value="<?php echo $data['locale']['bt_finish'];?>" id="bt_finish"></td>
						</tr>
						<tr class="form-field form-required">
							<td colspan="2"><h3>Result Comments</h3></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="you_scored">You Scored <span class="description"></span></label></th>
							<td><input name="data[locale][msg_you_scored]" type="text" value="<?php echo $data['locale']['msg_you_scored'];?>" id="you_scored"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_perfect">Highest score (100%) <span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_perfect]" type="text" value="<?php echo $data['locale']['result_comment_perfect'];?>" id="result_comment_perfect"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_excellent">Score > 90%<span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_excellent]" type="text" value="<?php echo $data['locale']['result_comment_excellent'];?>" id="result_comment_excellent"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_good">Score > 70% <span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_good]" type="text" value="<?php echo $data['locale']['result_comment_good'];?>" id="result_comment_good"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_average">Score > 50% <span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_average]" type="text" value="<?php echo $data['locale']['result_comment_average'];?>" id="result_comment_average"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_bad">Score > 30% <span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_bad]" type="text" value="<?php echo $data['locale']['result_comment_bad'];?>" id="result_comment_bad"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_poor">Score > 20% <span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_poor]" type="text" value="<?php echo $data['locale']['result_comment_poor'];?>" id="result_comment_poor"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="result_comment_worst">Score < 20% <span class="description"></span></label></th>
							<td><input name="data[locale][result_comment_worst]" type="text" value="<?php echo $data['locale']['result_comment_worst'];?>" id="result_comment_worst"></td>
						</tr>
						<tr class="form-field form-required">
							<td colspan="2"><h3>Contact Form</h3></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_show_form_button">Show Contact Form Button <span class="description"></span></label></th>
							<td><input name="data[locale][contact_show_form_button]" type="text" value="<?php echo $data['locale']['contact_show_form_button'];?>" id="contact_show_form_button"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_heading">Heading <span class="description"></span></label></th>
							<td><input name="data[locale][contact_heading]" type="text" value="<?php echo $data['locale']['contact_heading'];?>" id="contact_heading"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_name">Name <span class="description"></span></label></th>
							<td><input name="data[locale][contact_name]" type="text" value="<?php echo $data['locale']['contact_name'];?>" id="contact_name"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_email">Email <span class="description"></span></label></th>
							<td><input name="data[locale][contact_email]" type="text" value="<?php echo $data['locale']['contact_email'];?>" id="contact_email"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_phone">Phone <span class="description"></span></label></th>
							<td><input name="data[locale][contact_phone]" type="text" value="<?php echo $data['locale']['contact_phone'];?>" id="contact_phone"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_message">Message <span class="description"></span></label></th>
							<td><input name="data[locale][contact_message]" type="text" value="<?php echo $data['locale']['contact_message'];?>" id="contact_message"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_submit_button">Submit Button<span class="description"></span></label></th>
							<td><input name="data[locale][contact_submit_button]" type="text" value="<?php echo $data['locale']['contact_submit_button'];?>" id="contact_submit_button"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="contact_thankyou">Thanks Message <span class="description"></span></label></th>
							<td><input name="data[locale][contact_thankyou]" type="text" value="<?php echo $data['locale']['contact_thankyou'];?>" id="contact_thankyou"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="tabs-3">
				<table class="form-table">
					<tbody>
						<tr class="form-field form-required">
							<th scope="row"><label for="mail_sendto">Send To <span class="description"></span></label></th>
							<td><input name="data[quiz_mailer][sendto]" type="text" value="<?php echo $data['quiz_mailer']['sendto'];?>" id="sendto"></td>
						</tr>
						<tr class="form-field form-required">
							<td colspan="2"><h3>SMTP Config (optional)</h3></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="host">Host <span class="description"></span></label></th>
							<td><input name="data[quiz_mailer][host]" type="text" value="<?php echo $data['quiz_mailer']['host'];?>" id="host"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="username">Username <span class="description"></span></label></th>
							<td><input name="data[quiz_mailer][username]" type="text" value="<?php echo $data['quiz_mailer']['username'];?>" id="username"></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row"><label for="assword">Password <span class="description"></span></label></th>
							<td><input name="data[quiz_mailer][password]" type="text" value="<?php echo $data['quiz_mailer']['password'];?>" id="password"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $pluginURL."/";?>assets/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo $pluginURL."/";?>assets/js/colorpicker.js"></script>
<script>
$(function() {
	//tabs
	$( "#tabs" ).tabs();

	//color picker
	$('.interface_picker').ColorPicker({
		livePreview : true,
		onSubmit: function(hsb, hex, rgb, el) {
			console.log(el);
			$(el).val(hex);
			$(el).ColorPickerHide();
			$(el).next('span').css('backgroundColor', '#' + hex);
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});

	$('.colorSelector').bind('click', function(){
		$(this).prev('input').trigger('click');
	});
});
</script>