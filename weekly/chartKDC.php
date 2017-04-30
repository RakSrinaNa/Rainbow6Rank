<?php
	$divName = 'KDC';
	$title = 'K/D Ratio Casual';

	$guides = function()
	{
		return json_encode(array());
	};

	$datas = function() use (&$monthRange)
	{
		$datas = array();
		$files = glob('players/*/*.json', GLOB_BRACE);
		foreach($files as $file)
		{
			$timestamp = (explode('.', array_values(array_slice(explode('/', $file), -1))[0])[0] / 1000);
			if(!isset($_GET['all']) && time() - $timestamp > $monthRange)
				continue;
			$player = json_decode(file_get_contents($file), true);
			if(!isset($player['player']['username']) || $player['player']['username'] === '')
				continue;
			$username = $player['player']['username'];
			if(!isset($datas[$username]))
				$datas[$username] = array();
			$dateID = date("W-Y", $timestamp);
			if(!$datas[$username][$dateID])
				$datas[$username][$dateID] = array('stat' => 0, 'count' => 0);
			$datas[$username][$dateID]['stat'] += $player['player']['stats']['casual']['kd'];
			$datas[$username][$dateID]['count']++;
		}
		$goodData = array();
		foreach($datas as $user => $userData)
		{
			if(!$goodData[$user])
				$goodData[$user] = array();
			foreach($userData as $date => $dateDatas)
			{
				$weekDate = new DateTime();
				$weekDate->setISODate(explode('-', $date)[1], explode('-', $date)[0]);
				$weekDate->setTime(0, 0);

				$stat = $dateDatas['stat'] / $dateDatas['count'];
				$fullDate = $weekDate->format('Y-m-d\TH:i:s');
				$goodData[$user][$fullDate] = $stat;
			}
		}
		return json_encode($goodData);
	};

	include 'graph.php';