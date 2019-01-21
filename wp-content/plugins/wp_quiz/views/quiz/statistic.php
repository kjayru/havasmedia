<?php
    $statisticData = array();
    foreach ($data['statistic'] as $idx => $c) {
    	if(isset($statisticData[intval($c['score'])])){
        	$statisticData[intval($c['score'])] += 1;
    	}else{
    		$statisticData[intval($c['score'])] = 1;
    	}
    }

    $numOfSubmitScore = 0;
    $chartData  = array();
    foreach ($statisticData as $key => $value) {
    	$chartData[] = array((string)$key, $value);
    	$numOfSubmitScore += $value;
    }
	$chartData = json_encode($chartData);
?>

<div class="wrap">
    <div id="icon-page" class="icon32"><br/></div>
    <h2>Quiz Stats <a href="?page=<?php echo $_REQUEST['page']?>&controller=questions&action=statistic&quiz_id=<?php echo $_REQUEST['wp_quiz_id']?>" class="add-new-h2">Questions Stats</a></h2>
	<div style="text-align:center" id="PollPieChart"></div>
	<p style="text-align:center; font-weight: bold;">Total <?php echo $numOfSubmitScore;?> people finish this quiz</p>
	<p style="text-align:center;"><a href="?page=<?php echo $_REQUEST['page']?>&action=export&wp_quiz_id=<?php echo $_REQUEST['wp_quiz_id']?>" class="button button-primary button-large">Export CSV</a></p>
	<br>
	<?php $wp_list_table->display(); ?>
</div>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    //load the Google Visualization API and the chart
    google.load('visualization', '1', {'packages':['columnchart','piechart']});

    //set callback
    google.setOnLoadCallback (createChart);

    //callback function
    function createChart() {

        //create data table object
        var dataTable = new google.visualization.DataTable();

        //define columns for first example
        dataTable.addColumn('string');
        dataTable.addColumn('number');

        //define rows of data for first example
        dataTable.addRows(<?php echo $chartData;?>);

        //instantiate our chart objects
        var pchart = new google.visualization.PieChart (document.getElementById('PollPieChart'));
        //var bchart = new google.visualization.BarChart (document.getElementById('PollBarChart'));


        //define options for visualization
        var options = {width: 600, height: 400, is3D: true, title: '<?php echo $data['quiz']['title'];?>'};

        //draw our chart charts
        pchart.draw(dataTable, options);
        //bchart.draw(dataTable, options);
    }
</script>