<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class PenetrationKillsGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Penetration kills';
			}

			function getID()
			{
				return 'PK';
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
				return "/api/overall/penetration";
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
				return "Kills: {value}";
			}
		}
	}
