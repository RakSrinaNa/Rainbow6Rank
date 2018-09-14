<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class MeleeGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Melee kills';
			}

			function getID()
			{
				return 'MK';
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
				return "/api/overall/melee";
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
