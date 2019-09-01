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
		$ENDPOINT = 'http://mrcraftcod.ddns.net/r6/';
		$url = $ENDPOINT . $path . "&appcode=mcc";

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

	$players = array('LokyDogma' => 'b59ac5a1-c97a-4ccc-8a1e-263734ace5a8', //'Fuel_Rainbow' => 'bfcc9958-0bcf-419f-a077-1eadde6fffa9',
		//'Fuel_Velvet' => 'ed779667-8b99-411f-a87d-becb00df4135',
		//'DevilDuckYT' => '7ee006a8-9187-4abc-ae11-4cd29a3580ee',
		'RakSrinaNa' => '3c5d59d2-8367-4af4-b9af-56cd8589100f');

	$fpLog = fopen('log.log', 'w');

	foreach($players as $player => $uid)
	{
		logg('Doing player ' . $player . ':' . "<br/>\n", $fpLog);
		$json = array();
		$responseUser = readAPI($fpLog, "getUser.php?id=$uid");
		$responseStats = readAPI($fpLog, "getStats.php?id=$uid");
		if(!$responseUser || !$responseStats)
		{
			continue;
		}
		$decode1 =  json_decode($responseUser, true);
		$decode2 = json_decode($responseStats, true);

		if(!isset($decode1['players']) || !isset($decode1['players'][$uid]))
		{
			echo "Missing field in json for user $uid : $responseUser<br/>\n";
			continue;
		}
		if(!isset($decode2['players']) || !isset($decode2['players'][$uid]))
		{
			echo "Missing field in json for user $uid : $responseStats<br/>\n";
			continue;
		}
		if(isset($decode1['error']) && $decode1['error'])
		{
			echo "Got error getting infos<br/>\n";
			continue;
		}
		if(isset($decode2['error']) && $decode2['error'])
		{
			echo "Got error getting infos<br/>\n";
			continue;
		}

		$json['player'] = $decode1['players'][$uid];
		$json['stats'] = $decode2['players'][$uid];

		$parser = new \R6\R6StatsParser(json_encode($json));
		$parser->putInDB();
	}

	{
		$fp = fopen($rootDirectory . 'players/last.update', 'w');
		fwrite($fp, '-');
		fclose($fp);
	}

	logg('Done' . "<br/>\n", $fpLog);
	fclose($fpLog);
