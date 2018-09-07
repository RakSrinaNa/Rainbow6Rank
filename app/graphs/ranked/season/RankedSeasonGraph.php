<?php

	namespace R6
	{
		require_once __DIR__ . '/../../../model/GraphSupplier.php';
		require_once __DIR__ . '/../../../api/v1/model/DBConnection.class.php';

		abstract class RankedSeasonGraph extends GraphSupplier
		{
			abstract function getSeasonID();

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
				$js = '';
				$prepared = DBConnection::getConnection()->prepare("SELECT RankValue, RankName FROM `R6_Ranks` LEFT JOIN R6_Season_Ranks ON R6_Season_Ranks.RankID = R6_Ranks.RankID WHERE Season=:season");
				$prepared->execute(array(':season' => $this->getSeasonID()));
				$result = $prepared->fetchAll();
				foreach($result as $index => $row)
				{
					$value = $row['RankValue'];
					$name = $row['RankName'];
					$js .= "let range = yAxis.axisRanges.create();";
					$js .= "range.value = $value;";
					$js .= "range.grid.stroke = am4core.color('#396478');";
					$js .= "range.grid.strokeWidth = 4;";
					$js .= "range.grid.strokeOpacity = 1;";
					$js .= "range.label.inside = false;";
					$js .= "range.label.text = '$name';";
					$js .= "range.label.fill = range.grid.stroke;";
					$js .= "range.label.verticalCenter = 'bottom';";
				}
				return $js;
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

			protected function getBalloonTooltip()
			{
				return "Points: {value}\\nRank: {rank}\\nMean: {mean}\\nStDev: {stdev}";
			}
		}
	}
