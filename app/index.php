<?php
	if(true)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	session_start();
	date_default_timezone_set('Europe/Paris');

	$_SESSION['menuStyle'] = 'pill';

	if(!isset($_GET['section']))
		$_GET['section'] = 'casual';
	if(!isset($_GET['range']))
		$_GET['range'] = '7';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//momentjs.com/downloads/moment-with-locales.js"></script>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <script type="text/javascript" src="js/libs/amcharts4/core.js"></script>
    <script type="text/javascript" src="js/libs/amcharts4/charts.js"></script>
    <script type="text/javascript" src="js/libs/amcharts4/themes/animated.js"></script>
    <script type="text/javascript" src="js/libs/amcharts4/themes/material.js"></script>
    <script type="text/javascript" src="js/libs/amcharts4/themes/dark.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/load6.css"/>
    <script type="text/javascript" src="js/main.js"></script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>Rainbow6 stats</title>
</head>

<body>
<?php
	include __DIR__ . '/header.php';

	/**
	 * @var array
	 */
	$plots = array();
?>
<div class="container-fluid" style="margin-top:80px">
    <ul id="mainPills" class="nav nav-<?php echo $_SESSION['menuStyle']; ?>s nav-justified">
        <li class="nav-item"><a class="nav-link <?php echo $_GET['section'] === 'casual' ? 'active' : ''; ?>" href="?section=casual&range=<?php echo $_GET['range']; ?>">Casual</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $_GET['section'] === 'ranked' ? 'active' : ''; ?>" href="?section=ranked&range=<?php echo $_GET['range']; ?>">Ranked</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $_GET['section'] === 'seasons' ? 'active' : ''; ?>" href="?section=seasons&range=<?php echo $_GET['range']; ?>">Seasons</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $_GET['section'] === 'overall' ? 'active' : ''; ?>" href="?section=overall&range=<?php echo $_GET['range']; ?>">Overall</a></li>
    </ul>
    <hr/>
	<?php
		switch($_GET['section'])
		{
			case 'casual':
				?>
                <div id="menuCasual"><?php
				foreach(glob("graphs/casual/*.php") as $filename)
					/** @noinspection PhpIncludeInspection */
					require_once __DIR__ . '/' . $filename;

				$plots[] = new R6\KillDeathCasualGraph();
				$plots[] = new R6\PlayTimeCasualGraph();
				$plots[] = new R6\WinLossCasualGraph();
				include __DIR__ . "/sections/casual.php";
				?></div><?php
				break;
			case 'ranked':
				?>
                <div id="menuRanked"><?php
				foreach(glob("graphs/ranked/*.php") as $filename)
					/** @noinspection PhpIncludeInspection */
					require_once __DIR__ . '/' . $filename;
				require_once __DIR__ . '/graphs/ranked/season/RankedSeason12Graph.php';

				$plots[] = new R6\KillDeathRankedGraph();
				$plots[] = new R6\PlayTimeRankedGraph();
				$plots[] = new R6\WinLossRankedGraph();
				$plots[] = new R6\RankedSeason12Graph();
				include __DIR__ . "/sections/ranked.php";
				?></div><?php
				break;
			case 'seasons':
				?>
                <div id="menuSeasons"><?php
				foreach(glob("graphs/ranked/season/*.php") as $filename)
					/** @noinspection PhpIncludeInspection */
					require_once __DIR__ . '/' . $filename;

				$plots[] = new R6\RankedSeason13Graph();
				$plots[] = new R6\RankedSeason12Graph();
				$plots[] = new R6\RankedSeason11Graph();
				$plots[] = new R6\RankedSeason10Graph();
				$plots[] = new R6\RankedSeason9Graph();
				$plots[] = new R6\RankedSeason8Graph();
				$plots[] = new R6\RankedSeason7Graph();
				$plots[] = new R6\RankedSeason6Graph();
				$plots[] = new R6\RankedSeason5Graph();
				include __DIR__ . "/sections/seasons.php";
				?></div><?php
				break;
			case 'overall':
				?>
                <div id="menuOverall">
				<?php
				foreach(glob("graphs/overall/*.php") as $filename)
					/** @noinspection PhpIncludeInspection */
					require_once __DIR__ . '/' . $filename;

				$plots[] = new R6\AccuracyGraph();
				$plots[] = new R6\AssistsGraph();
				$plots[] = new R6\BarricadesGraph();
				$plots[] = new R6\HeadshotsGraph();
				$plots[] = new R6\LevelGraph();
				$plots[] = new R6\MeleeGraph();
				$plots[] = new R6\PenetrationKillsGraph();
				$plots[] = new R6\ReinforcementsGraph();
				$plots[] = new R6\RevivesGraph();
				$plots[] = new R6\StepsGraph();
				$plots[] = new R6\SuicidesGraph();
				$plots[] = new R6\DBNOGraph();
				$plots[] = new R6\DBNOAssistsGraph();
				$plots[] = new R6\GadgetsDestroyedGraph();
				include __DIR__ . "/sections/overall.php";
				?>
                </div><?php
				break;
		}
	?>
</div>
<?php
	$plots = array_filter($plots, function($plot){
		/**
		 * @var $plot \R6\GraphSupplier
		 */
		return $plot->shouldPlot();
	});

	foreach($plots as $plotIndex => $plot)
	{
		/**
		 * @var $plot \R6\GraphSupplier
		 */
		$name = $plot->getID();
		echo "<!-- $name -->";
		$plot->plot();
	}
?>
<script src="js/last.js"></script>
</body>
</html>