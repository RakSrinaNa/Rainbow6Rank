<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class BarricadesGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['overall']['barricades_built'];
				return $point;
			}

			function getTitle()
			{
				return 'Barricades built';
			}

			function getID()
			{
				return 'BB';
			}
		}
	}
