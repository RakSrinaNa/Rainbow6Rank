<?php
	require_once __DIR__ . '/../../model/GraphSupplier.php';

	class MeleeGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['overall']['melee_kills'];
			return $point;
		}

		function getTitle()
		{
			return 'Melee kills';
		}

		function getID()
		{
			return 'MK';
		}
	}
