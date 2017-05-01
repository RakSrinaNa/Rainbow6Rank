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
			if(!isset($datas[$username]))
				$datas[$username] = array();
			$datas[$username][$player['player']['updated_at']] = array('stat' => 0, 'total' => 0, 'timestamp' => $timestamp);
			$datas[$username][$player['player']['updated_at']]['stat'] = $player['player']['stats']['ranked']['kills'];
			$datas[$username][$player['player']['updated_at']]['total'] = $player['player']['stats']['ranked']['deaths'];
		}
		$tempDatas = array();
		foreach($datas as $user => $userData)
		{
			if(!isset($tempDatas[$user]))
				$tempDatas[$user] = array();
			foreach($userData as $date => $dateDatas)
			{
				$week = date("W-Y", $dateDatas['timestamp']);
				if(!isset($tempDatas[$user][$week]))
					$tempDatas[$user][$week] = array();
				$tempDatas[$user][$week][] = $dateDatas;
			}
		}
		foreach($tempDatas as $user => $userData)
			foreach($userData as $week => $weekDatas)
				usort($weekDatas, function($a, $b)
				{
					return $a['timestamp'] - $b['timestamp'];
				});
		$goodData = array();
		foreach($tempDatas as $user => $userData)
		{
			if(!isset($goodData[$user]))
				$goodData[$user] = array();
			foreach($userData as $week => $weekDatas)
			{
				$weekDate = new DateTime();
				$weekDate->setISODate(explode('-', $week)[1], explode('-', $week)[0]);
				$weekDate->setTime(0, 0);

				$start = array_values($weekDatas)[0];
				$end = array_values(array_slice($weekDatas, -1))[0];

				if($start['timestamp'] === $end['timestamp'])
					continue;

				$stat = ($end['stat'] - $start['stat']) / ($end['total'] - $start['total'] + 1);
				$fullDate = $weekDate->format('Y-m-d\TH:i:s');
				$goodData[$user][$fullDate] = $stat;
			}
		}
		return json_encode($goodData);
	};

	include 'graph.php';