<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		abstract class RankedSeasonGraph extends GraphSupplier
		{
			function getPoint($player)
			{
				if(!isset($player['seasons']) || !isset($player['seasons'][$this->getSeasonID()]))
					return null;
				$date = $date = date_create_from_format('Y-m-d\TH:i:s+', $player['player']['updated_at']);
				if($this->getEndDate() > 0 && $date->getTimestamp() >= $this->getEndDate())
					return null;
				$point = array('stat' => 0);
				$point['stat'] = $player['seasons'][$this->getSeasonID()]['emea']['ranking']['rating'];
				$point['rank'] = $this->getRank($player);
				$point['wins'] = $player['seasons'][$this->getSeasonID()]['emea']['wins'];
				$point['losses'] = $player['seasons'][$this->getSeasonID()]['emea']['losses'];
				$point['abandons'] = $player['seasons'][$this->getSeasonID()]['emea']['abandons'];
				return $point;
			}

			abstract function getSeasonID();

			abstract function getEndDate();

			function getRank($player)
			{
				$score = $player['seasons'][$this->getSeasonID()]['emea']['ranking']['rating'];
				foreach($this->getRanks() as $index => $value)
				{
					if($score >= $value['from'] && $score < $value['to'])
						return ($player['seasons'][$this->getSeasonID()]['emea']['ranking']['rank'] <= 0 ? 'Unranked: ' : '') . $index;
				}
				return 'Unranked';
			}

			abstract function getRanks();

			function getTitle()
			{
				return 'Ranked points - Season ' . $this->getSeasonID();
			}

			function getID()
			{
				return 'Ranked' . $this->getSeasonID();
			}

			function getGuides()
			{
				$i = 0;
				$guideColors = array('#555555', '#aaaaaa');

				$guides = array();
				foreach($this->getRanks() as $rankName => $rankDatas)
				{
					$guides[] = array('fillAlpha' => 0.3, 'lineAlpha' => 1, 'lineThickness' => 1, 'value' => $rankDatas['from'], 'toValue' => $rankDatas['to'], 'valueAxis' => 'pointsAxis', 'label' => $rankName, 'inside' => true, 'position' => 'right', 'fillColor' => $guideColors[$i++ % count($guideColors)]);
				}
				return json_encode($guides);
			}

			function getAdditionalBalloon()
			{
				return array('rank' => 'Rank: ', 'wins' => 'Wins: ', 'losses' => 'Losses: ', 'abandons' => 'Abandons: ');
			}

			function isOnlyAllView()
			{
				return $this->getEndDate() > 0;
			}
		}
	}
