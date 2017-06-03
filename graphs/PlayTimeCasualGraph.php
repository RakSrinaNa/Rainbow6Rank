<?php
	require_once __DIR__ . '/../model/GraphSupplier.php';

	class PlayTimeCasualGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['casual']['playtime'];
			return $point;
		}

		function getTitle()
		{
			return 'Playtime Casual';
		}

		function getID()
		{
			return 'PTC';
		}
	}
