<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class KillDeathRankedGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0, 'total' => 0);
				$point['stat'] = $player['player']['stats']['ranked']['kills'];
				$point['total'] = $player['player']['stats']['ranked']['deaths'];
				return $point;
			}

			function getTitle()
			{
				return 'K/D Ratio Ranked';
			}

			function getID()
			{
				return 'KDR';
			}

			function getAdditionalBalloon()
			{
				return array('stat' => 'Kills: ', 'total' => 'Deaths: ');
			}
		}
	}
