<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class BulletsHitGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0, 'total' => 0);
				$point['stat'] = $player['player']['stats']['overall']['bullets_hit'];
				return $point;
			}

			function getTitle()
			{
				return 'Bullet hits';
			}

			function getID()
			{
				return 'ACC';
			}
		}
	}
