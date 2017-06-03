<?php
	require_once __DIR__ . '/../model/GraphSupplier.php';

	class PlayTimeRankedGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['ranked']['playtime'];
			return $point;
		}

		function getTitle()
		{
			return 'Playtime Ranked';
		}

		function getID()
		{
			return 'PTR';
		}
	}
