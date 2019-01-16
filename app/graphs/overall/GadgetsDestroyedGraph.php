<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class GadgetsDestroyedGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Gadgets destroyed';
			}

			function getID()
			{
				return 'GD';
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
				return "/api/overall/gadgetsdestroyed";
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
				return "Gadgets destroyed: {value}";
			}
		}
	}
