<?php
	require_once __DIR__ . '/../model/GraphSupplier.php';

	class AccuracyGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0, 'total' => 0);
			$point['stat'] = $player['player']['stats']['overall']['bullets_hit'];
			$point['total'] = $player['player']['stats']['overall']['bullets_fired'];
			return $point;
		}

		function getTitle()
		{
			return 'Accuracy';
		}

		function getID()
		{
			return 'ACC';
		}
	}
