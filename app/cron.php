<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include_once __DIR__ . "/R6StatsParser.php";

	function logg($message, $fpLog = null)
	{
		echo $message;
		if($fpLog !== null)
			fwrite($fpLog, $message);
	}

	function readAPI($fpLog, $path)
	{
		$ENDPOINT = 'https://api.r6stats.com/api/v1/players/';
		$url = $ENDPOINT . $path;

		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_HTTPGET, true);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
		$content = curl_exec($cURL);
		logg($path . ' => HTTP Response: ' . curl_getinfo($cURL, CURLINFO_HTTP_CODE) . "<br/>\n", $fpLog);
		if(!$content)
			logg('Error getting from API (' . curl_errno($cURL) . ')' . curl_error($cURL) . "<br/>\n", $fpLog);
		curl_close($cURL);
		return $content;
	}

	$rootDirectory = __DIR__ . "/";
	$timeFormat = 'Y-m-d\TH:i:s+';

	$players = array('LokyDogma' => 'uplay', 'Fuel_Rainbow' => 'uplay', 'Fuel_Velvet' => 'uplay', 'DevilDuckYT' => 'uplay', 'RakSrinaNa' => 'uplay');

	$fpLog = fopen('log.log', 'w');

	foreach($players as $player => $platform)
	{
		logg('Doing player ' . $player . ':' . "<br/>\n", $fpLog);
		$json = array();
		$c1 = readAPI($fpLog, $player . '?platform=' . $platform);
		$c2 = readAPI($fpLog, $player . '/seasons?platform=' . $platform);
		$c3 = readAPI($fpLog, $player . '/operators?platform=' . $platform);
		if(!$c1 || !$c2 || !$c3)
		{
			continue;
		}
		$json['player'] = json_decode($c1, true)['player'];
		$json['seasons'] = json_decode($c2, true)['seasons'];
		$json['operators'] = json_decode($c3, true)['operator_records'];

		$parser =new \R6\R6StatsParser(json_encode($json));
		$parser->putInDB();
	}

	{
		$fp = fopen($rootDirectory . 'players/last.update', 'w');
		fwrite($fp, '-');
		fclose($fp);
	}

	logg('Done' . "<br/>\n", $fpLog);
	fclose($fpLog);
