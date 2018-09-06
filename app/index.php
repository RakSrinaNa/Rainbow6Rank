<?php
	if(true)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	session_start();
	date_default_timezone_set('Europe/Paris');

	$_SESSION['menuStyle'] = 'pill';
	$_GET['section'] = isset($_GET['section']) ? $_GET['section'] : 'weekly';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/libs/amcharts/amcharts.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/serial.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/themes/light.js"></script>
    <script type="text/javascript" src="js/libs/amcharts/plugins/responsive/responsive.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>Rainbow6 stats</title>

    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/load6.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
<script src="js/init.js"></script>
<?php
	include __DIR__ . "/header.php";

	function getRange()
	{
		return $_GET['section'] === 'weekly' ? 31536000 : (3 * 2592000);
	}

//	foreach(glob("graphs/*/*.php") as $filename)
//		/** @noinspection PhpIncludeInspection */
//		require_once __DIR__ . '/' . $filename;

    require_once __DIR__ . "/graphs/casual/KillDeathCasualGraph.php";
	/**
	 * @var array
	 */
	$plots = array();

	//$plots[] = new R6\AccuracyGraph();
	//	$plots[] = new R6\BulletsHitGraph();
	//	$plots[] = new R6\AssistsGraph();
	//	$plots[] = new R6\BarricadesGraph();
	//	$plots[] = new R6\HeadshotsGraph();
		$plots[] = new R6\KillDeathCasualGraph();
	//	$plots[] = new R6\KillDeathRankedGraph();
	//	$plots[] = new R6\LevelGraph();
	//	$plots[] = new R6\MeleeGraph();
	//	$plots[] = new R6\PenetrationKillsGraph();
	//	$plots[] = new R6\PlayTimeCasualGraph();
	//	$plots[] = new R6\PlayTimeRankedGraph();
	//	$plots[] = new R6\RankedSeason5Graph();
	//	$plots[] = new R6\RankedSeason6Graph();
	//	$plots[] = new R6\RankedSeason7Graph();
	//	$plots[] = new R6\RankedSeason8Graph();
	//	$plots[] = new R6\RankedSeason9Graph();
	//	$plots[] = new R6\RankedSeason10Graph();
	//	$plots[] = new R6\RankedSeason11Graph();
	//	$plots[] = new R6\ReinforcementsGraph();
	//	$plots[] = new R6\RevivesGraph();
	//	$plots[] = new R6\StepsGraph();
	//	$plots[] = new R6\SuicidesGraph();
	//	$plots[] = new R6\WinLossCasualGraph();
	//	$plots[] = new R6\WinLossRankedGraph();
	//	$plots[] = new R6\OperatorsHandler();

	$plots = array_filter($plots, function($plot){
		/**
		 * @var $plot \R6\GraphSupplier
		 */
		return $plot->shouldPlot();
	});
?>
<div class="container-fluid" style="margin-top:80px">
    <ul id="mainPills" class="nav nav-<?php echo $_SESSION['menuStyle']; ?>s nav-justified">
        <li class="nav-item"><a class="nav-link disabled" data-toggle="<?php echo $_SESSION['menuStyle']; ?>" href="#menuCasual">Casual</a>
        </li>
        <li class="nav-item"><a class="nav-link disabled" data-toggle="<?php echo $_SESSION['menuStyle']; ?>" href="#menuRanked">Ranked</a>
        </li>
        <li class="nav-item"><a class="nav-link disabled" data-toggle="<?php echo $_SESSION['menuStyle']; ?>" href="#menuOther">Other</a>
        </li>
        <li class="nav-item"><a class="nav-link disabled" data-toggle="<?php echo $_SESSION['menuStyle']; ?>" href="#menuOperators">Operators</a></li>
    </ul>
    <hr/>
    <div class="tab-content">
        <div id="menuCasual" class="tab-pane fade">
			<?php
				include __DIR__ . "/sections/casual.php";
			?>
        </div>
        <div id="menuRanked" class="tab-pane fade">
			<?php
				include __DIR__ . "/sections/ranked.php";
			?>
        </div>
        <div id="menuOther" class="tab-pane fade">
			<?php
				include __DIR__ . "/sections/other.php";
			?>
        </div>
        <div id="menuOperators" class="tab-pane fade">
			<?php
				include __DIR__ . "/sections/operators.php";
			?>
        </div>
    </div>
</div>
<?php
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