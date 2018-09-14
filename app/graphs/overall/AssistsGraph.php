<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class AssistsGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Assists';
			}

			function getID()
			{
				return 'ASS';
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
				return "/api/overall/assists";
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
				return "Assists: {value}";
			}
		}
	}
