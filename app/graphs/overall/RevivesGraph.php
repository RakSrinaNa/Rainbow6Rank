<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class RevivesGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Revives';
			}

			function getID()
			{
				return 'RV';
			}
			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return "/api/overall/players";
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return "/api/overall/revives";
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
				return "Revives: {value}";
			}
		}
	}
