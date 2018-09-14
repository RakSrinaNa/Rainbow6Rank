<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class BarricadesGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Barricades built';
			}

			function getID()
			{
				return 'BB';
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
				return "/api/overall/barricades";
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
				return "Barricades: {value}";
			}
		}
	}
