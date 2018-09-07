<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class HeadshotsGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Headshots';
			}

			function getID()
			{
				return 'HDS';
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
				return "/api/overall/headshots";
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
				return "Headshots: {value}";
			}
		}
	}
