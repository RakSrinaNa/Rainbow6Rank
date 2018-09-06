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
		}
	}
