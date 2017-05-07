<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require_once __DIR__ . '/model/DBConnection.php';

	function logg($message, $fpLog = null)
	{
		var_dump($message);
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
		logg('HTTP Response: ' . curl_getinfo($cURL, CURLINFO_HTTP_CODE) . "\n", $fpLog);
		if(!$content)
			logg('Error getting from API (' . curl_errno($cURL) . ')' . curl_error($cURL) . "\n", $fpLog);
		curl_close($cURL);
		return $content;
	}

	function array_flat($array, $prefix = '')
	{
		$result = array();
		foreach($array as $key => $value)
		{
			$new_key = $prefix . (empty($prefix) ? '' : '.') . $key;
			if(is_array($value))
				$result = array_merge($result, array_flat($value, $new_key));
			else
				$result[$new_key] = $value;
		}
		return $result;
	}

	function getLastUpdate($user) use (&$conn)
	{
		$query = $this->conn->query('SELECT MAX(`ValueDate`) AS `LastDate` FROM  `Rainbow6` WHERE `Username`="' . $user . '";');
		if(!$query)
			return 0;
		if($query->num_rows > 0)
			if($row = $query->fetch_assoc())
				return $row['LastDate'];
		return 0;
	}

	$rootDirectory = 'www/subdomains/rainbow/';
	$timeFormat = 'Y-m-d\TH:i:s+';

	$players = array('MrCraftCod' => 'uplay', 'LokyDogma' => 'uplay', 'PhoenixRS666' => 'uplay');

	$fpLog = fopen('log.log', 'w');

	logg('Working directory: ' . getcwd() . "\n\n", $fpLog);

	{
		$fp = fopen($rootDirectory . 'players/last.update', 'w');
		fwrite($fp, '-');
		fclose($fp);
	}

	/** @noinspection SqlNoDataSourceInspection */
	/** @noinspection SqlResolve */
	$conn = DBConnection::getConnection();

	foreach($players as $player => $platform)
	{
		logg('Doing player ' . $player . ':' . "\n", $fpLog);
		$json = array();
		$c1 = readAPI($fpLog, $player . '?platform=' . $platform);
		$c2 = readAPI($fpLog, $player . '/seasons?platform=' . $platform);
		if(!$c1 || !$c2)
		{
			continue;
		}
		$json['player'] = json_decode($c1, true)['player'];
		$json['seasons'] = json_decode($c2, true)['seasons'];

		$temp = $json['player']['updated_at'];
		$date = date_create_from_format($timeFormat, $temp);
		if($date)
		{
			$time = $date->getTimestamp() * 1000;

			logg('Time ' . $time . "\n", $fpLog);

			$flat = array_flat($json);
			foreach($flat as $key => $value)
			{
				$conn->query('INSERT INTO Rainbow6(`Username`, `ValueKey`, `ValueDate`, `Value`) VALUES("' . $player . '", "' . $key . '", FROM_UNIXTIME(' . $date->getTimestamp() . '), "' . $value . '");');
			}
			$lastUpdate = getLastUpdate($player);
			logg($lastUpdate);

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

	logg('Done' . "\n", $fpLog);
	fclose($fpLog);
