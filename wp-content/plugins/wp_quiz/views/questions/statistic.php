<div class="wrap">
    <div id="icon-page" class="icon32"><br/></div>
    <h2><?php echo $data['quiz']['title'];?> <a href="?page=<?php echo $_REQUEST['page']?>&&action=statistic&wp_quiz_id=<?php echo $_REQUEST['quiz_id']?>" class="add-new-h2">Back</a></h2>

	<div id="accordion">
	<?php
		foreach ($data['questions'] as $q) {
	?>
		<h3><?php echo strip_tags($q['title']);?></h3>
		<div style="min-height:420px" data-id="<?php echo $q["id"];?>" class="loadQuestionStat">
			<iframe src="<?php echo admin_url( 'admin-ajax.php' ).'?action=load_stats_by_question&question_id='.$q["id"]?>" width="100%" height="420px"></iframe>
		</div>
	<?php
		}
	?>
	</div>
</div>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
$(function() {
	$( "#accordion" ).accordion();
});
</script>