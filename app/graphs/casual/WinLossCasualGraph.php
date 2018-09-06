<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class WinLossCasualGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'W/L Ratio Casual';
			}

			function getID()
			{
				return 'WLC';
			}

			function getAdditionalBalloon()
			{
				return array('played' => 'Played: ', 'stat' => 'Wins: ', 'total' => 'Losses: ');
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
				return '/api/casual/wl';
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
