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
	$rootDir = '/homez.2349/mrcraftcgg/www/subdomains/rainbow';
	$files = glob($rootDir . '/players/*/*.json', GLOB_BRACE);
	foreach($files as $file)
	{
		$record = file_get_contents($file);
		$parser = new \R6\R6StatsParser($record);
		$parser->putInDB();
		rename($file, $file . ".done");
	}
?>
</body>
</html>