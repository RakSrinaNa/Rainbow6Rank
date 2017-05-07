<?php
	require_once dirname(__FILE__) . '/model/GraphSupplier.php';

	class AssistsGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['overall']['assists'];
			return $point;
		}

		function getTitle()
		{
			return 'Assists';
		}

		function getID()
		{
			return 'ASS';
		}
	}
