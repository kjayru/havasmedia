<div class="wrap">
  <h2 id="add-new-user"> Delete Question</h2>

  <div id="ajax-response"></div>

  <form method="post" name="createquiz" id="createuser" class="validate" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="data[id]" value="<?php echo $data['id'];?>">
    <table class="form-table">
    <tbody>
      <tr class="form-field form-required">
        <td><?php echo __('Are you sure to delete');?> &quot;<em><?php echo strip_tags($data['title']);?></em>&quot; ?</td>
      </tr>
    </tbody>
  </table>

  <p class="submit">
    <input type="submit" name="createquiz" id="createquizsub" class="button button-primary" value="Delete">
    <a href="admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id'];?>" class="button">Cancel</a>
  </p>
</form>
</div>