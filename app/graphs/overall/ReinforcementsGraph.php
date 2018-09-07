<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class ReinforcementsGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Reinforcements deployed';
			}

			function getID()
			{
				return 'RD';
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
				return "/api/overall/reinforcements";
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
				return "Reinforcements: {value}";
			}
		}
	}
