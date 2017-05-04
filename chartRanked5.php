<?php
	$divName = 'Ranked5';
	$title = 'Ranked points';

	$guides = function()
	{
		$ranks = array('Gold I' => array('from' => 3100, 'to' => 3300), 'Gold II' => array('from' => 2900, 'to' => 3100), 'Gold III' => array('from' => 2700, 'to' => 2900), 'Gold IV' => array('from' => 2500, 'to' => 2700), 'Silver I' => array('from' => 2400, 'to' => 2500), 'Silver II' => array('from' => 2300, 'to' => 2400), 'Silver III' => array('from' => 2200, 'to' => 2300), 'Silver IV' => array('from' => 2100, 'to' => 2200), 'Bronze I' => array('from' => 2000, 'to' => 2100), 'Bronze II' => array('from' => 1900, 'to' => 2000), 'Bronze III' => array('from' => 1800, 'to' => 1900), 'Bronze IV' => array('from' => 1700, 'to' => 1800), 'Copper I' => array('from' => 1600, 'to' => 1700), 'Copper II' => array('from' => 1500, 'to' => 1600), 'Copper III' => array('from' => 1400, 'to' => 1500));

		$i = 0;
		$guideColors = array('#555555', '#aaaaaa');

		$guides = array();
		foreach($ranks as $rankName => $rankDatas)
		{
			$guides[] = array('fillAlpha' => 0.3, 'lineAlpha' => 1, 'lineThickness' => 1, 'value' => $rankDatas['from'], 'toValue' => $rankDatas['to'], 'valueAxis' => 'pointsAxis', 'label' => $rankName, 'inside' => true, 'position' => 'right', 'fillColor' => $guideColors[$i++ % count($guideColors)]);
		}
		return json_encode($guides);
	};

	$datas = function() use (&$monthRange)
	{
		$datas = array();
		$files = glob('players/*/*.json', GLOB_BRACE);
		foreach($files as $file)
		{
			if(!isset($_GET['all']) && time() - (explode('.', array_values(array_slice(explode('/', $file), -1))[0])[0] / 1000) > $monthRange)
				continue;
			$player = json_decode(file_get_contents($file), true);
			if(!isset($player['seasons']) || !isset($player['seasons']['5']))
				continue;
			if(!isset($player['player']['username']) || $player['player']['username'] === '')
				continue;
			$username = $player['player']['username'];
			if(!isset($datas[$username]))
				$datas[$username] = array();
			if($player['seasons']['5']['emea']['ranking']['rank'] > 0)
				$datas[$username][$player['player']['updated_at']] = $player['seasons']['5']['emea']['ranking']['rating'];
		}
		return json_encode($datas);
	};

	include 'graph.php';