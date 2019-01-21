<?php $pluginURL = plugins_url('wp_quiz');?>
<div class="wrap" ng-app="question_answers">
  <h2 id="add-new-user"> Edit Question</h2>
  <?php  if(isset($_SESSION['quiz_flash'])){ echo $_SESSION['quiz_flash'];  } ?>
  <div id="ajax-response"></div>
  <form method="post" name="myForm" id="myForm" class="validate" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="data[quiz_id]" value="<?php echo $data['quiz_id'];?>">
    <input type="hidden" name="data[id]" value="<?php echo $data['id'];?>">

    <p class="submit">
      <input type="button" onclick="document.myForm.setAttribute('novalidate', 'true');document.myForm.submit();" class="button button-primary" value="Update">
      <a href="admin.php?page=wordpress-quiz&controller=questions&action=duplicate&question_id=<?php echo $data['id'];?>&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id'];?>" class="button">Duplicate Question</a>
      <a href="admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id'];?>" class="button">Cancel</a>
    </p>
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Question</a></li>
        <li><a href="#tabs-2">Answers</a></li>
      </ul>
      <div id="tabs-1">
        <table class="form-table">
          <tbody>
            <tr class="form-field form-required">
              <th scope="row"><label for="title">Title <span class="description">(required)</span></label></th>
              <td><?php wp_editor(stripslashes($data['title']), "title");?></td>
            </tr>
            <!-- <tr class="form-field form-required">
              <th scope="row"><label for="embed_code">Embed Code <span class="description"></span></label></th>
              <td><textarea name="data[embed_code]" id="embed_code" style="width:25em;" rows="5"><?php echo $data['embed_code'];?></textarea></td>
            </tr> -->
            <tr class="form-field form-required">
              <th scope="row"><label for="explain">Explanation <span class="description"></span></label></th>
              <td>
                <?php wp_editor(stripslashes($data['explain']), "explain");?>
                <!-- <textarea name="data[explain]" id="explain" style="width:100%;" rows="5"><?php //echo $data['explain'];?></textarea> -->
              </td>
            </tr>
            <tr class="form-field">
              <th scope="row"><label for="role">Status</label></th>
              <td>
                <select name="data[published]" id="published">
                  <option <?php if($data['published']==0) echo 'selected="selected"';?> value="0">Draft</option>
                  <option <?php if($data['published']==1) echo 'selected="selected"';?> value="1">Publish</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div id="tabs-2">
        <div ng-view></div>
      </div>
    </div>
  </form>
</div>
<script>
var baseURL = "<?php echo $pluginURL;?>";
var blogURL = "<?php echo get_site_url();?>";
</script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $pluginURL."/";?>assets/js/angular.min.js"></script>
<script type="text/javascript" src="<?php echo $pluginURL."/";?>assets/js/questions/app.js"></script>
<script type="text/javascript" src="<?php echo $pluginURL."/";?>assets/js/questions/controller.js"></script>
<script>
$(function() {
  $( "#tabs" ).tabs();
});
</script>