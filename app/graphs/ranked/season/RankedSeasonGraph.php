<?php

	namespace R6
	{
		require_once __DIR__ . '/../../../model/GraphSupplier.php';

		abstract class RankedSeasonGraph extends GraphSupplier
		{
			abstract function getSeasonID();

			abstract function getRanks();

			function getTitle()
			{
				return 'Ranked points - Season ' . $this->getSeasonID();
			}

			function getID()
			{
				return 'Season' . $this->getSeasonID();
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

			/**
			 * @return string
			 */
			public function getPlayersURL()
			{
				$sid = $this->getSeasonID();
				return "/api/season/$sid/players";
			}

			/**
			 * @return string
			 */
			public function getAllDataProvider()
			{
				$sid = $this->getSeasonID();
				return "/api/season/$sid/rank";
			}

			/**
			 * @return string
			 */
			public function getWeeklyDataProvider()
			{
				return $this->getAllDataProvider();
			}

		}
	}
