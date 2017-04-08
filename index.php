<?php
if(false)
{
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$dev = isset($_GET['dev']);
$customPeriodDisplayed = isset($_GET['startPeriod']) && isset($_GET['endPeriod']);
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
        <div style="margin-bottom: 10px;">

        </div>
        <div class="chartHolder" id="chartHolderRanked5">
            <span class="chartName">Season 5</span>
            <div class="chartDiv" id="chartDivRanked5"></div>
        </div>
        <?php include "chartRanked5.php"; ?>
    </body>
</html>