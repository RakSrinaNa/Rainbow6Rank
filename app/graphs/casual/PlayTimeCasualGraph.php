<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class PlayTimeCasualGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Playtime Casual';
			}

			function getID()
			{
				return 'PTC';
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return '/api/casual/players';
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return '/api/casual/playtime';
			}

			/**
			 * @return string
			 */
			function getWeeklyDataProvider()
			{
				return $this->getAllDataProvider();
			}

			function getBalloonTooltip()
			{
				return "Playtime: {value.formatDuration(\\\"dd\'d\' hh\'h\' mm\'m\' ss\'s\'\\\")}";
			}

			protected function getLegendText()
			{
				return "{value.formatDuration(\\\"dd\'d\' hh\'h\' mm\'m\' ss\'s\'\\\")}";
			}

			protected function isDurationGraph()
			{
				return true;
			}
		}
	}
