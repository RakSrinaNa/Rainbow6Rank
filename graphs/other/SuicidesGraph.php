<?php
	require_once __DIR__ . '/../../model/GraphSupplier.php';

	class SuicidesGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['overall']['suicides'];
			return $point;
		}

		function getTitle()
		{
			return 'Suicides moved';
		}

		function getID()
		{
			return 'SC';
		}
	}
