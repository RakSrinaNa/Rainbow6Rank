<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

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
		logg($path . ' => HTTP Response: ' . curl_getinfo($cURL, CURLINFO_HTTP_CODE) . "\n", $fpLog);
		if(!$content)
			logg('Error getting from API (' . curl_errno($cURL) . ')' . curl_error($cURL) . "\n", $fpLog);
		curl_close($cURL);
		return $content;
	}

	$rootDirectory = __DIR__ . "/";
	$timeFormat = 'Y-m-d\TH:i:s+';

	$players = array('MrCraftCod' => 'uplay', 'LokyDogma' => 'uplay', 'Fuel_Rainbow' => 'uplay', 'Fuel_Velvet' => 'uplay', 'DevilDuckYT' => 'uplay');

	$fpLog = fopen('log.log', 'w');

	logg('Working directory: ' . getcwd() . "\n\n", $fpLog);

	foreach($players as $player => $platform)
	{
		logg('Doing player ' . $player . ':' . "\n", $fpLog);
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

		$temp = $json['player']['updated_at'];
		$date = date_create_from_format($timeFormat, $temp);
		if($date)
		{
			$time = $date->getTimestamp() * 1000;

			logg('Time ' . $time . "\n", $fpLog);

			$folder = $rootDirectory . 'players/' . $player . '/';
			$file = $folder . $time . '.json';

			if(!file_exists($folder))
				mkdir($folder, 0777, true);

			if(!file_exists($file))
			{
				logg('Writing file ' . $file . "\n", $fpLog);
				$fp = fopen($file, 'w');
				if(!$fp)
				{
					logg('Error opening file ' . $file . "\n", $fpLog);
				}
				else
				{
					fwrite($fp, json_encode($json));
					fclose($fp);
					logg('Writing file done' . "\n", $fpLog);
				}
			}
			else
			{
				logg("File " . $file . ' already exists, skipping' . "\n", $fpLog);
			}
			logg("\n", $fpLog);
		}
		else
		{
			echo DateTime::getLastErrors();
		}
	}

	{
		$fp = fopen($rootDirectory . 'players/last.update', 'w');
		fwrite($fp, '-');
		fclose($fp);
	}

	logg('Done' . "\n", $fpLog);
	fclose($fpLog);
