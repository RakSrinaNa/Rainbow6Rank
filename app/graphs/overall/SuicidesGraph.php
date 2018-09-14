<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class SuicidesGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Suicides';
			}

			function getID()
			{
				return 'SC';
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
				return "/api/overall/suicides";
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
				return "Suicides: {value}";
			}
		}
	}
