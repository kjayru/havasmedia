<pre><?php //print_r($data)?></pre>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    //load the Google Visualization API and the chart
    google.load('visualization', '1', {'packages':['columnchart','piechart']});
</script>
<div class="wrap">
    <div id="icon-page" class="icon32"><br/></div>
    <h2><?php echo $data['quiz']['title'];?> <a href="?page=<?php echo $_REQUEST['page']?>&&action=statistic&wp_quiz_id=<?php echo $_REQUEST['quiz_id']?>" class="add-new-h2">Back</a></h2>

	<div id="accordion">
	<?php
		foreach ($data['questions'] as $q) {
	?>
		<h3><?php echo strip_tags($q['title']);?></h3>
		<div style="min-height: 420px;">
			<?php
				if(isset($data['statistic'][$q['id']])):
					$chartData  = array();
					$ans = array();
					foreach ($data['statistic'][$q['id']] as $s) {
						$ansID = $s['answer_id'];
						$ans[$ansID]++;
			?>
						<div style="text-align:center" id="PieChart<?php echo $q['id'];?>"></div>
			<?php
					}

					foreach ($ans as $ans_id => $numOfAnswers) {
						$chartData[] = array($data['answers'][$ans_id]['answer'], $numOfAnswers);
					}
					$chartData = json_encode($chartData);
			?>
					<script>
					    //set callback
					    google.setOnLoadCallback (function(){
					        //create data table object
					        var dataTable = new google.visualization.DataTable();

					        //define columns for first example
					        dataTable.addColumn('string');
					        dataTable.addColumn('number');

					        //define rows of data for first example
					        dataTable.addRows(<?php echo $chartData;?>);

					        //instantiate our chart objects
					        var pchart = new google.visualization.PieChart (document.getElementById('PieChart<?php echo $q['id'];?>'));


					        //define options for visualization
					        var options = {width: 600, height: 400, is3D: true, title: ''};

					        //draw our chart charts
					        pchart.draw(dataTable, options);

					    });
    			</script>
			<?php
				endif;
			?>
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