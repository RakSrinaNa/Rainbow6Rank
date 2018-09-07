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
					$js .= "let range$index = yAxis.axisRanges.create();\n";
					$js .= "range$index.value = $value;\n";
					$js .= "range$index.grid.stroke = am4core.color('#396478');\n";
					$js .= "range$index.grid.strokeWidth = 4;\n";
					$js .= "range$index.grid.strokeOpacity = 1;\n";
					$js .= "range$index.label.inside = false;\n";
					$js .= "range$index.label.text = '$name';\n";
					$js .= "range$index.label.fill = range$index.grid.stroke;\n";
					$js .= "range$index.label.verticalCenter = 'bottom';\n\n";
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
