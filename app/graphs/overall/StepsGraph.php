<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class StepsGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Steps moved';
			}

			function getID()
			{
				return 'SM';
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
				return "/api/overall/steps";
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
				return "Steps: {value}";
			}
		}
	}
