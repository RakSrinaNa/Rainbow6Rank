<?php
	require_once __DIR__ . '/../../model/GraphSupplier.php';

	class RevivesGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['overall']['revives'];
			return $point;
		}

		function getTitle()
		{
			return 'Revives';
		}

		function getID()
		{
			return 'RV';
		}
	}
