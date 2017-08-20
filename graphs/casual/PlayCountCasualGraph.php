<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class PlayCountCasualGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['casual']['wins'] + $player['player']['stats']['casual']['losses'];
				return $point;
			}

			function getTitle()
			{
				return 'Match played Casual';
			}

			function getID()
			{
				return 'PLC';
			}
		}
	}
