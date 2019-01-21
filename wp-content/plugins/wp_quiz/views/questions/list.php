<div class="wrap">
    <div id="icon-post" class="icon32"><br/></div>
    <h2><?php echo $quiz_info['title'];?> <a href="?page=<?php echo $_REQUEST['page']?>&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id']?>&controller=questions&action=add&/#/question_answers/0" class="add-new-h2">Add New</a></h2>
     <?php if(isset($_SESSION['quiz_flash'])) echo $_SESSION['quiz_flash']; ?>

    <form method="post" action="?page=<?php echo $_REQUEST['page']?>&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id']?>&controller=questions&action=delete_all">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
	     <?php $wp_list_table->display(); ?>
	</form>
</div>
<?php
// remove flash message
if(isset($_SESSION['quiz_flash'])){ unset($_SESSION['quiz_flash']); }
?>