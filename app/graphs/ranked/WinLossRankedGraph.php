<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class WinLossRankedGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'W/L Ratio Ranked';
			}

			function getID()
			{
				return 'WLR';
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
				return '/api/ranked/players';
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return '/api/ranked/wl';
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
				return "WLR: {value}\\nWins: {wins}\\nLosses: {losses}";
			}
		}
	}
