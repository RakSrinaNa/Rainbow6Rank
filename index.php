<?php
	$beta = $_SERVER['HTTP_HOST'] === 'rainbowb.mrcraftcod.fr';
    $rootDir = '/homez.2349/mrcraftcgg/www/subdomains/rainbow';

	if($beta)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	date_default_timezone_set('Europe/Paris');

	function getRange()
	{
		return isset($_GET['weekly']) ? 31536000 : 2592000;
	}

	function getLastCheckDate($rootDir)
	{
		$date = 0;
		$files = glob($rootDir . '/players/last.update', GLOB_BRACE);
		foreach($files as $file)
		{
			$fDate = filemtime($file);
			$date = $date > $fDate ? $date : $fDate;
		}
		return $date === 0 ? 'UNKNOWN' : date("H:i:s", $date);
	}

	function getLastUpdateDate($rootDir)
	{
		$date = 0;
		$files = glob($rootDir . '/players/*/*.json', GLOB_BRACE);
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
    <title>Rainbow6 stats<?php if($beta)echo ' BETA'; ?></title>
</head>
<body>
<header id="headerContainer">
    <div class="leftNav inline">
        <ul>
            <li><a href="https://r6stats.com/" target="_blank">Datas from R6Stats</a></li>
            <?php
                if($beta)
                    echo '<li><a href="https://rainbow.mrcraftcod.fr" target="_self">Release version</a></li>';
                else
                    echo '<li><a href="https://rainbowb.mrcraftcod.fr" target="_self">Beta version</a></li>';
            ?>
            <li></li>
        </ul>
    </div>
    <div class="inline">
        <ul>
            <li class="centerNav"><a href="#">Last update at: <?php echo getLastCheckDate($rootDir) ?></a></li>
            <li class="centerNav"><a href="#">Last data from: <?php echo getLastUpdateDate($rootDir); ?></a></li>
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
	foreach(glob("graphs/*/*.php") as $filename)
		/** @noinspection PhpIncludeInspection */
		require_once __DIR__ . '/' . $filename;

	$operatorHandler = new OperatorsHandler();

	$plots = array();

	$plots[] = new AccuracyGraph();
	$plots[] = new AssistsGraph();
	$plots[] = new HeadshotsGraph();
	$plots[] = new KillDeathCasualGraph();
	$plots[] = new KillDeathRankedGraph();
	$plots[] = new PlayTimeCasualGraph();
	$plots[] = new PlayTimeRankedGraph();
	if(isset($_GET['all']))
		$plots[] = new RankedSeason5Graph();
	$plots[] = new RankedSeason6Graph();
	$plots[] = new WinLossCasualGraph();
	$plots[] = new WinLossRankedGraph();
    $plots[] = $operatorHandler;

	$files = glob($rootDir . '/players/*/*.json', GLOB_BRACE);
	foreach($files as $file)
	{
		$timestamp = (explode('.', array_values(array_slice(explode('/', $file), -1))[0])[0] / 1000);
		if(!isset($_GET['all']) && time() - $timestamp > getRange())
			continue;
		$player = json_decode(file_get_contents($file), true);
		if(!isset($player['player']['username']) || $player['player']['username'] === '')
			continue;
		foreach($plots as $plotIndex => $plot)
			$plot->processPoint($player, $timestamp);
	}

	$operatorHandler->buildDivs();

	foreach($plots as $plotIndex => $plot)
		$plot->plot();
?>
</body>
</html>