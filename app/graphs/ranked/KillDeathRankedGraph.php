<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class KillDeathRankedGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'K/D Ratio Ranked';
			}

			function getID()
			{
				return 'KDR';
			}

			function getAdditionalBalloon()
			{
				return array('stat' => 'Kills: ', 'total' => 'Deaths: ');
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
				return '/api/ranked/kd';
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
