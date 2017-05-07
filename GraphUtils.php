<?php

	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 01/05/2017
	 * Time: 20:29
	 */
	class GraphUtils
	{
		static function groupWeekly($datas)
		{
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
					if(!isset($start['total']) || !isset($end['total']))
					{
						$start['total'] = 0;
						$end['total'] = 1;
					}
					if($end['stat'] - $start['stat'] == 0 && $end['total'] - $start['total'] == 0)
						continue;

					$det = ($end['total'] - $start['total']);
					$stat = ($end['stat'] - $start['stat']) / ($det === 0 ? 1 : $det);
					$fullDate = $weekDate->format('Y-m-d\TH:i:s');
					$goodData[$user][$fullDate] = $stat;
				}
			}
			return $goodData;
		}

		public static function process($datas)
		{
			if(isset($_GET['weekly']))
				return self::groupWeekly($datas);
			return self::group($datas);
		}

		private static function group($datas)
		{
			$goodData = array();

			foreach($datas as $user => $userData)
			{
				if(!isset($goodData[$user]))
					$goodData[$user] = array();
				foreach($userData as $date => $dateDatas)
				{
					if(!isset($dateDatas['total']))
						$dateDatas['total'] = 1;
					if(!isset($goodData[$user][$date]))
						$goodData[$user][$date] = array();
					$goodData[$user][$date] = $dateDatas['stat'] / (isset($dateDatas['total']) && $dateDatas['total'] !== 0 ? $dateDatas['total'] : 1);
				}
			}

			return $goodData;
		}
	}