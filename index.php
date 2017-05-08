<?php

	if(true)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	date_default_timezone_set('Europe/Paris');
	$dev = isset($_GET['dev']);

	function getLastCheckDate()
	{
		$date = 0;
		$files = glob('players/last.update', GLOB_BRACE);
		foreach($files as $file)
		{
			$fDate = filemtime($file);
			$date = $date > $fDate ? $date : $fDate;
		}
		return $date === 0 ? 'UNKNOWN' : date("H:i:s", $date);
	}

	function getLastUpdateDate()
	{
		$date = 0;
		$files = glob('players/*/*.json', GLOB_BRACE);
		foreach($files as $file)
		{
			$fDate = filemtime($file);
			$date = $date > $fDate ? $date : $fDate;
		}
		return $date === 0 ? 'UNKNOWN' : date("H:i:s", $date);
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css"/>
    <script type="text/javascript" src="js/libs/jquery/jquery.js"></script>
    <script type="text/javascript" src="js/libs/ElementQueries/ResizeSensor.js"></script>
    <script type="text/javascript" src="js/libs/ElementQueries/ElementQueries.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/amcharts.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/serial.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/themes/light.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/plugins/responsive/responsive.min.js"></script>
    <meta charset="UTF-8">
    <title>Rainbow6 stats</title>
</head>
<body>
<header id="headerContainer">
    <div class="leftNav inline">
        <ul>
            <li><a href="https://r6stats.com/" target="_blank">Datas from R6Stats</a></li>
        </ul>
    </div>
    <div class="inline">
        <ul>
            <li class="centerNav"><a href="#">Last update at: <?php echo getLastCheckDate() ?></a></li>
            <li class="centerNav"><a href="#">Last data from: <?php echo getLastUpdateDate(); ?></a></li>
        </ul>
    </div>
    <div class="rightNav inline">
        <ul>
            <li>
				<?php
					if(isset($_GET['all']))
                    {
	                    ?>
                        <a href=".">See weekly data</a>
	                    <?php
                    }
                    else if(isset($_GET['detailled']))
                    {
	                    ?>
                        <a href=".">See weekly data</a>
	                    <?php
                    }
                    else
                    {
	                    ?>
                        <a href="?detailled=1">See detailled data</a>
	                    <?php
                    }
				?>
            </li>
            <li>
				<?php
					if(isset($_GET['all']))
					{
						?>
                        <a href="?detailled=1">See detailled data</a>
						<?php
					}
					else if(isset($_GET['detailled']))
					{
						?>
                        <a href="?all=1">See all data</a>
						<?php
					}
					else
					{
						?>
                        <a href="?all=1">See all data</a>
						<?php
					}
				?>
            </li>
        </ul>
    </div>
</header>
<div class="chartHolder" id="chartHolderRanked5">
    <span class="chartName">Season 5</span>
    <div class="chartDiv" id="chartDivRanked5"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderKDR">
    <span class="chartName">Ratio K/D Ranked</span>
    <div class="chartDiv" id="chartDivKDR"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderWLR">
    <span class="chartName">Ratio W/L Ranked</span>
    <div class="chartDiv" id="chartDivWLR"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderPLR">
    <span class="chartName">Match played Ranked</span>
    <div class="chartDiv" id="chartDivPLR"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderKDC">
    <span class="chartName">Ratio K/D Casual</span>
    <div class="chartDiv" id="chartDivKDC"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderWLC">
    <span class="chartName">Ratio W/L Casual</span>
    <div class="chartDiv" id="chartDivWLC"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderPLC">
    <span class="chartName">Match played Casual</span>
    <div class="chartDiv" id="chartDivPLC"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderACC">
    <span class="chartName">Accuracy</span>
    <div class="chartDiv" id="chartDivACC"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderASS">
    <span class="chartName">Assists</span>
    <div class="chartDiv" id="chartDivASS"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderHDS">
    <span class="chartName">Assists</span>
    <div class="chartDiv" id="chartDivHDS"></div>
</div>
<?php
	require_once dirname(__FILE__) . '/graphs/AccuracyGraph.php';
	require_once dirname(__FILE__) . '/graphs/AssistsGraph.php';
	require_once dirname(__FILE__) . '/graphs/HeadshotsGraph.php';
	require_once dirname(__FILE__) . '/graphs/KillDeathCasualGraph.php';
	require_once dirname(__FILE__) . '/graphs/KillDeathRankedGraph.php';
	require_once dirname(__FILE__) . '/graphs/PlayCountCasualGraph.php';
	require_once dirname(__FILE__) . '/graphs/PlayCountRankedGraph.php';
	require_once dirname(__FILE__) . '/graphs/RankedSeason5Graph.php';
	require_once dirname(__FILE__) . '/graphs/WinLossCasualGraph.php';
	require_once dirname(__FILE__) . '/graphs/WinLossRankedGraph.php';

	$plot = new AccuracyGraph();
	$plot->plot();

	$plot = new AssistsGraph();
	$plot->plot();

	$plot = new HeadshotsGraph();
	$plot->plot();

	$plot = new KillDeathCasualGraph();
	$plot->plot();

	$plot = new KillDeathRankedGraph();
	$plot->plot();

	$plot = new PlayCountCasualGraph();
	$plot->plot();

	$plot = new PlayCountRankedGraph();
	$plot->plot();

	$plot = new RankedSeason5Graph();
	$plot->plot();

	$plot = new WinLossCasualGraph();
	$plot->plot();

	$plot = new WinLossRankedGraph();
	$plot->plot();
?>
</body>
</html>