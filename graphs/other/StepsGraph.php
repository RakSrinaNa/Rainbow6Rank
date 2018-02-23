<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class StepsGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				$point = array('stat' => 0);
				$point['stat'] = $player['player']['stats']['overall']['steps_moved'];
				if($point['stat'] >= 808581577)
					$point['stat'] -= 796066108;
				if($player['player']['username'] === GraphUtils::remapUsername('MrCraftCod'))
					$point['stat'] -= 11935086;
				return $point;
			}

			function getTitle()
			{
				return 'Steps moved';
			}

			function getID()
			{
				return 'SM';
			}
		}
	}
