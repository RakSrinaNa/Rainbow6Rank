<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class PenetrationKillsGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['overall']['penetration_kills'];
				return $point;
			}

			function getTitle()
			{
				return 'Penetration kills';
			}

			function getID()
			{
				return 'PK';
			}
		}
	}
