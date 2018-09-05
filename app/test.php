<?php
	if(true)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	session_start();
	date_default_timezone_set('Europe/Paris');

	include_once __DIR__ . "/R6StatsParser.php";

	$_SESSION['menuStyle'] = 'pill';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
	$file = __DIR__ . "/players/RakSrinaNa/1536169100000.json";
	$record = file_get_contents($file);
	$parser = new \R6\R6StatsParser($record);
	$parser->putInDB();
?>
</body>
</html>