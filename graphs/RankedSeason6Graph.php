<?php
	require_once __DIR__ . '/../model/GraphSupplier.php';

	class RankedSeason6Graph extends GraphSupplier
	{
		private $endDate = -1;

		private $ranks = array('Gold I' => array('from' => 3100, 'to' => 3300), 'Gold II' => array('from' => 2900, 'to' => 3100), 'Gold III' => array('from' => 2700, 'to' => 2900), 'Gold IV' => array('from' => 2500, 'to' => 2700), 'Silver I' => array('from' => 2400, 'to' => 2500), 'Silver II' => array('from' => 2300, 'to' => 2400), 'Silver III' => array('from' => 2200, 'to' => 2300), 'Silver IV' => array('from' => 2100, 'to' => 2200), 'Bronze I' => array('from' => 2000, 'to' => 2100), 'Bronze II' => array('from' => 1900, 'to' => 2000), 'Bronze III' => array('from' => 1800, 'to' => 1900), 'Bronze IV' => array('from' => 1700, 'to' => 1800), 'Copper I' => array('from' => 1600, 'to' => 1700), 'Copper II' => array('from' => 1500, 'to' => 1600), 'Copper III' => array('from' => 1400, 'to' => 1500));

		function getPoint($player)
		{
			if(!isset($player['seasons']) || !isset($player['seasons']['6']) )
				return null;
			$date = $date = date_create_from_format('Y-m-d\TH:i:s+', $player['player']['updated_at']);
			if($this->endDate > 0 && $date->getTimestamp() >= $this->endDate)
				return null;
			$point = array('stat' => 0);
			$point['stat'] = $player['seasons']['6']['emea']['ranking']['rating'];
			$point['rank'] = $this->getRank($player);
			return $point;
		}

		function getRank($player)
		{
			$score = $player['seasons']['6']['emea']['ranking']['rating'];
			foreach($this->ranks as $index => $value)
			{
				if($score >= $value['from'] && $score < $value['to'])
					return ($player['seasons']['6']['emea']['ranking']['rank'] <= 0 ? 'Unranked: ' : '') . $index;
			}
			return 'Unranked';
		}

		function getTitle()
		{
			return 'Ranked points - Season 6';
		}

		function getID()
		{
			return 'Ranked6';
		}

		function getGuides()
		{
			$i = 0;
			$guideColors = array('#555555', '#aaaaaa');

			$guides = array();
			foreach($this->ranks as $rankName => $rankDatas)
			{
				$guides[] = array('fillAlpha' => 0.3, 'lineAlpha' => 1, 'lineThickness' => 1, 'value' => $rankDatas['from'], 'toValue' => $rankDatas['to'], 'valueAxis' => 'pointsAxis', 'label' => $rankName, 'inside' => true, 'position' => 'right', 'fillColor' => $guideColors[$i++ % count($guideColors)]);
			}
			return json_encode($guides);
		}

		function getAdditionalBalloon()
		{
			return array('rank' => 'Rank: ');
		}
	}
