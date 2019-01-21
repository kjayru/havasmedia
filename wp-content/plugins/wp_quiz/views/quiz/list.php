<div class="wrap">
    <div id="icon-page" class="icon32"><br/></div>
    <h2>Quiz <a href="?page=<?php echo $_REQUEST['page']?>&action=add" class="add-new-h2">Add New</a></h2>
     <?php if(isset($_SESSION['quiz_flash'])) echo $_SESSION['quiz_flash']; ?>

    <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
	     <?php $wp_list_table->display(); ?>
	</form>
</div>
<script type="text/javascript">
    function selectText(containerid) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().addRange(range);
        }
    }
</script>
<?php
// remove flash message
if(isset($_SESSION['quiz_flash'])){ unset($_SESSION['quiz_flash']); }
?>