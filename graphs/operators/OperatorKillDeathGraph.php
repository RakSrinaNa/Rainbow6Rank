<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:37
	 */
	require_once __DIR__ . '/SimpleOperatorGraph.php';

	class OperatorKillDeathGraph extends SimpleOperatorGraph
	{
		function getTitle()
		{
			return 'K/D Ratio ' . $this->operator;
		}

		function getPoint($player)
		{
			$point = array('stat' => 0, 'total' => 0);
			$point['stat'] = $player['kills'];
			$point['total'] = $player['deaths'];
			return $point;
		}

		function getAdditionalBalloon()
		{
			return array('stat' => 'Kills: ', 'total' => 'Deaths: ');
		}
	}