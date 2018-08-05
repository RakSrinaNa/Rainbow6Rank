<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

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
	}
