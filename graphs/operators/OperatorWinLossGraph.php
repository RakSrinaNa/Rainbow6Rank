<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:37
	 */

	namespace R6
	{
		require_once __DIR__ . '/SimpleOperatorGraph.php';

		class OperatorWinLossGraph extends SimpleOperatorGraph
		{
			function getTitle()
			{
				return 'W/L Ratio ' . $this->operator;
			}

			function getPoint($player)
			{
				$point = array('stat' => 0, 'total' => 0);
				$point['stat'] = $player['wins'];
				$point['total'] = $player['losses'];
				$point['played'] = $player['played'];
				return $point;
			}

			function getAdditionalBalloon()
			{
				return array('played' => 'Played: ', 'stat' => 'Wins: ', 'total' => 'Losses: ');
			}
		}
	}