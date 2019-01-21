<div class="wrap">
	<h2 id="add-new-user"> Delete Questions</h2>

	<div id="ajax-response"></div>

	<form method="post" name="createquiz" id="createuser" class="validate" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="action" value="agree_delete_all">
		<ol>
			<?php foreach ($data as $q) {?>
			<input type="hidden" name="questions[]" value="<?php echo $q['id'];?>">
			<li>
				<?php echo strip_tags($q['title']);?>
			</li>
			<?php } ?>
		</ol>

		<p class="submit">
			<?php echo __('Are you sure to delete ?');?>
			<input type="submit" name="deleteBtn" id="createquizsub" class="button button-primary" value="Delete">
			<a href="admin.php?page=wordpress-quiz&controller=questions&action=index&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id'];?>" class="button">Cancel</a>
		</p>
	</form>
</div>