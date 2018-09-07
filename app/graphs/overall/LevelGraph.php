<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class LevelGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Level';
			}

			function getID()
			{
				return 'LVL';
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return "/api/progression/players";
			}
			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return "/api/progression/level";
			}

			/**
			 * @return string
			 */
			function getWeeklyDataProvider()
			{
				return $this->getAllDataProvider();
			}

			protected function getBalloonTooltip()
			{
				return "Level: {value}\\nExperience: {xp}";
			}
		}
	}
