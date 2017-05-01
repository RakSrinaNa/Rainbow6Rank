<?php
	$divName = 'KDR';
	$title = 'K/D Ratio Ranked';

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
			if(!isset($datas[$username][$dateID]))
				$datas[$username][$dateID] = array('stat' => 0, 'total' => 0);
			$datas[$username][$dateID]['stat'] += $player['player']['stats']['ranked']['kills'];
			$datas[$username][$dateID]['total'] += $player['player']['stats']['ranked']['deaths'];
		}
		$goodData = array();
		foreach($datas as $user => $userData)
		{
			$previousStat = 0;
			$previousTotal = 0;
			if(!isset($goodData[$user]))
				$goodData[$user] = array();
			uksort($userData, function($a, $b){
				$weekDateA = new DateTime();
				$weekDateA->setISODate(explode('-', $a)[1], explode('-', $a)[0]);
				$weekDateA->setTime(0, 0);

				$weekDateB = new DateTime();
				$weekDateB->setISODate(explode('-', $b)[1], explode('-', $b)[0]);
				$weekDateB->setTime(0, 0);

				return $a - $b;
			});
			foreach($userData as $date => $dateDatas)
			{
				$weekDate = new DateTime();
				$weekDate->setISODate(explode('-', $date)[1], explode('-', $date)[0]);
				$weekDate->setTime(0, 0);

				$stat = ($dateDatas['stat'] - $previousStat) / ($dateDatas['total'] - $previousTotal + 1);
				$previousStat = $dateDatas['stat'];
				$previousTotal = $dateDatas['total'];
				$fullDate = $weekDate->format('Y-m-d\TH:i:s');
				$goodData[$user][$fullDate] = $stat;
			}
		}
		return json_encode($goodData);
	};

	include 'graph.php';