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

		function getBalloonFunction()
		{
			return 'var date = graphDataItem.category; return username + \'<br>\' + ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + \'<br/><b><span style="font-size:14px;">\' + 100 * graphDataItem.values.value + \'%</span></b>\';';
		}
	}
