<?php

if (true) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$dev = isset($_GET['dev']);

function getLastUpdateDate()
{
    $date = 0;
    $files = glob('players/*/*.json', GLOB_BRACE);
    foreach ($files as $file)
    {
        $fDate = filemtime($file);
        $date = $date > $fDate ? $date : $fDate;
    }
    return $date === 0 ? 'UNKNOWN' : date("Y-m-d H:i:s", $date);
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
<header>
    <div>
        Last data from: <?php echo getLastUpdateDate(); ?>
    </div>
</header>
<hr/>
<div style="margin-top: 5px;">
    <?php
    if(!isset($_GET['all']))
    {
    ?>
    <div align="center"">
    <a href="?all=1">See all gathered data</a>
</div>
<?php
}
else
{
    ?>
    <div align="center">
        <a href=".">See current month data</a>
    </div>
    <?php
}
?>
<hr>
</div>
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
<div class="chartHolder" id="chartHolderWLRR">
    <span class="chartName">Ratio W/L Ranked</span>
    <div class="chartDiv" id="chartDivWLRR"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderKDC">
    <span class="chartName">Ratio K/D Casual</span>
    <div class="chartDiv" id="chartDivKDC"></div>
</div>
<hr/>
<div class="chartHolder" id="chartHolderWLRC">
    <span class="chartName">Ratio W/L Casual</span>
    <div class="chartDiv" id="chartDivWLRC"></div>
</div>
<hr/>
<div>
    <a href="https://r6stats.com/" style="text-decoration: none; color: black;" target="_blank">Datas from R6Stats</a>
</div>
<?php include "chartRanked5.php"; ?>
<?php include "chartKDR.php"; ?>
<?php include "chartWLRR.php"; ?>
<?php include "chartKDC.php"; ?>
<?php include "chartWLRC.php"; ?>
</body>
</html>