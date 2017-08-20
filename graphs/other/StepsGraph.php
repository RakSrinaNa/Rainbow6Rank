<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class StepsGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['overall']['steps_moved'];
				return $point;
			}

			function getTitle()
			{
				return 'Steps moved';
			}

			function getID()
			{
				return 'SM';
			}
		}
	}
