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
		}
	}
