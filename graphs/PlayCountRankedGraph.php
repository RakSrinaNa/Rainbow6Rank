<?php
	require_once dirname(__FILE__) . '/model/GraphSupplier.php';

	class PlayCountRankedGraph extends GraphSupplier
	{
		function getPoint($player)
		{
			$point = array('stat' => 0);
			$point['stat'] = $player['player']['stats']['ranked']['wins'] + $player['player']['stats']['ranked']['losses'];
			return $point;
		}

		function getTitle()
		{
			return 'Match played Ranked';
		}

		function getID()
		{
			return 'PLR';
		}
	}
