<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class WinLossCasualGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0, 'total' => 0);
				$point['stat'] = $player['player']['stats']['casual']['wins'];
				$point['total'] = $player['player']['stats']['casual']['losses'];
				$point['played'] = $player['player']['stats']['casual']['wins'] + $player['player']['stats']['casual']['losses'];
				return $point;
			}

			function getTitle()
			{
				return 'W/L Ratio Casual';
			}

			function getID()
			{
				return 'WLC';
			}

			function getAdditionalBalloon()
			{
				return array('played' => 'Played: ', 'stat' => 'Wins: ', 'total' => 'Losses: ');
			}
		}
	}
