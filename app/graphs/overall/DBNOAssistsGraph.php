<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class DBNOAssistsGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'DBNO Assists';
			}

			function getID()
			{
				return 'DBNOASS';
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
				return "/api/overall/dbnoassists";
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
				return "DBNO Assists: {value}";
			}
		}
	}
