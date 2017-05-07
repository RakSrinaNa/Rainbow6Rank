<?php
	require_once __DIR__ . '/../model/GraphSupplier.php';

	class HeadshotsGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['overall']['headshots'];
			return $point;
		}

		function getTitle()
		{
			return 'Headshots';
		}

		function getID()
		{
			return 'HDS';
		}
	}
