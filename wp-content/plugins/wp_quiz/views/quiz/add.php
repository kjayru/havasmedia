<div class="wrap">
  <h2 id="add-new-user"> New Quiz</h2>

  <div id="ajax-response"></div>

  <form method="post" name="createquiz" id="createuser" class="validate" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input name="action" type="hidden" value="createquiz">
    <table class="form-table">
      <tbody>
        <tr class="form-field form-required">
          <th scope="row"><label for="title">Title <span class="description">(required)</span></label></th>
          <td><input name="data[title]" type="text" id="title" value="<?php //echo $data['title'];?>" aria-required="true"></td>
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="instruction">Instruction <span class="description"></span></label></th>
          <td><textarea name="data[instruction]" id="instruction" style="width:25em;" rows="5"><?php //echo $data['instruction'];?></textarea></td>
        </tr>
        <tr>
          <th scope="row"><label for="randomized">Random?</label></th>
          <td><label for="randomized"><input type="checkbox" name="data[randomized]" id="randomized" <?php //if($data['randomized']) echo 'checked';?>> Checked if you want generate random questions.</label></td>
        </tr>
        <tr>
          <th scope="row"><label for="show_instruction">Show Instruction?</label></th>
          <td><label for="show_instruction"><input type="checkbox" name="data[show_instruction]" id="show_instruction" <?php //if($data['show_instruction']) echo 'checked';?>> Checked if you want show instruction.</label></td>
        </tr>
        <tr>
          <th scope="row"><label for="show_contact_form">Show Contact Form?</label></th>
          <td><label for="show_contact_form"><input type="checkbox" name="data[show_contact_form]" id="show_contact_form" <?php //if($data['show_contact_form']) echo 'checked';?>> Checked if you want show contact form.</label></td>
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="limit">Limit <span class="description"></span></label></th>
          <td><input name="data[limit]" type="text" id="limit" value="<?php echo "";?>" aria-required="true">
            <br><span class="description">Set the number of questions will show on your quiz</span>
          </td>
        </tr>
        <tr class="form-field form-required">
          <th scope="row"><label for="hint">Hint <span class="description"></span></label></th>
          <td><input name="data[hint]" type="text" id="hint" value="<?php echo 0;?>" aria-required="true">
            <br><span class="description">Set the number of hints will show on your quiz</span>
          </td>
        </tr>
        <input type="hidden" name="data[effect]" id="effect" value="fade">
        <!--
        <tr class="form-field">
          <th scope="row"><label for="role">Effect</label></th>
          <td>
            <select name="data[effect]" id="effect">
              <option value="slide">Slide</option>
              <option value="fade">Fade</option>
            </select>
          </td>
        </tr> -->

        <tr class="form-field form-required">
              <th scope="row"><label for="contact_redirect">Take them to a particular webpage </label></th>
              <td>
                <input name="data[contact_redirect]" type="text" value="<?php //echo $data['contact_redirect'];?>" id="contact_redirect">
                <br><span class="description">When users submit their scores they will be taken to the web page you type here. Leave blank if you want to use the Thanks Message.</span>
              </td>
        </tr>
        <tr class="form-field">
          <th scope="row"><label for="role">Status</label></th>
          <td>
            <select name="data[published]" id="published">
              <option <?php //if($data['published']==0) echo 'selected="selected"';?> value="0">Draft</option>
              <option <?php //if($data['published']==1) echo 'selected="selected"';?> value="1">Publish</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="submit">
      <input type="submit" name="createquiz" id="createquizsub" class="button button-primary" value="Add New">
      <a href="admin.php?page=wordpress-quiz" class="button">Cancel</a>
    </p>
  </form>
</div>