<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class LevelGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['progression']['level'];
				return $point;
			}

			function getTitle()
			{
				return 'Level';
			}

			function getID()
			{
				return 'LVL';
			}
		}
	}
