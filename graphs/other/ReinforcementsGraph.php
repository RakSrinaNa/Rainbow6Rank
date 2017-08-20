<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class ReinforcementsGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['overall']['reinforcements_deployed'];
				return $point;
			}

			function getTitle()
			{
				return 'Reinforcements deployed';
			}

			function getID()
			{
				return 'RD';
			}
		}
	}
