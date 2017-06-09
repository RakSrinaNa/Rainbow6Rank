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
    <script type="text/javascript" src="js/libs/amcharts/amcharts.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/serial.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/themes/light.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/plugins/responsive/responsive.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
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
                    elseif(isset($_GET['detailled']))
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
                    elseif(isset($_GET['detailled']))
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
<button class="accordion level1">Ranked</button>
<div class="panel">
	<?php
		if(isset($_GET['all']))
		{
			?>
            <button class="accordion">Season 5</button>
            <div class="chartHolder panel" id="chartHolderRanked5">
                <div class="chartDiv" id="chartDivRanked5"></div>
            </div>
			<?php
		}
	?>
    <button class="accordion">Season 6</button>
    <div class="chartHolder panel" id="chartHolderRanked6">
        <div class="chartDiv" id="chartDivRanked6"></div>
    </div>
    <button class="accordion">Ratio K/D Ranked</button>
    <div class="chartHolder panel" id="chartHolderKDR">
        <div class="chartDiv" id="chartDivKDR"></div>
    </div>
    <button class="accordion">Ration W/L Ranked</button>
    <div class="chartHolder panel" id="chartHolderWLR">
        <div class="chartDiv" id="chartDivWLR"></div>
    </div>
    <button class="accordion">Playtime Ranked</button>
    <div class="chartHolder panel" id="chartHolderPTR">
        <div class="chartDiv" id="chartDivPTR"></div>
    </div>
</div>
<button class="accordion level1">Casual</button>
<div class="panel">
    <button class="accordion">Ratio K/D Casual</button>
    <div class="chartHolder panel" id="chartHolderKDC">
        <div class="chartDiv" id="chartDivKDC"></div>
    </div>
    <button class="accordion">Ratio W/L Casual</button>
    <div class="chartHolder panel" id="chartHolderWLC">
        <div class="chartDiv" id="chartDivWLC"></div>
    </div>
    <button class="accordion">Playtime Casual</button>
    <div class="chartHolder panel" id="chartHolderPTC">
        <div class="chartDiv" id="chartDivPTC"></div>
    </div>
</div>
<button class="accordion level1">Other</button>
<div class="panel">
    <button class="accordion">Accuracy</button>
    <div class="chartHolder panel" id="chartHolderACC">
        <div class="chartDiv" id="chartDivACC"></div>
    </div>
    <button class="accordion">Assists</button>
    <div class="chartHolder panel" id="chartHolderASS">
        <div class="chartDiv" id="chartDivASS"></div>
    </div>
    <button class="accordion">Headshots</button>
    <div class="chartHolder panel" id="chartHolderHDS">
        <div class="chartDiv" id="chartDivHDS"></div>
    </div>
</div>
<?php
	require_once dirname(__FILE__) . '/graphs/AccuracyGraph.php';
	require_once dirname(__FILE__) . '/graphs/AssistsGraph.php';
	require_once dirname(__FILE__) . '/graphs/HeadshotsGraph.php';
	require_once dirname(__FILE__) . '/graphs/KillDeathCasualGraph.php';
	require_once dirname(__FILE__) . '/graphs/KillDeathRankedGraph.php';
	require_once dirname(__FILE__) . '/graphs/PlayTimeCasualGraph.php';
	require_once dirname(__FILE__) . '/graphs/PlayTimeRankedGraph.php';
	require_once dirname(__FILE__) . '/graphs/RankedSeason6Graph.php';
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

	$plot = new PlayTimeCasualGraph();
	$plot->plot();

	$plot = new PlayTimeRankedGraph();
	$plot->plot();

	if(isset($_GET['all']))
	{
		$plot = new RankedSeason5Graph();
		$plot->plot();
	}

	$plot = new RankedSeason6Graph();
	$plot->plot();

	$plot = new WinLossCasualGraph();
	$plot->plot();

	$plot = new WinLossRankedGraph();
	$plot->plot();
?>
</body>
</html>