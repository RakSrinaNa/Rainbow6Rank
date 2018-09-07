<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class PlayTimeRankedGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'Playtime Ranked';
			}

			function getID()
			{
				return 'PTR';
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return '/api/ranked/players';
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return '/api/ranked/playtime';
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
