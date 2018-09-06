<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		class KillDeathCasualGraph extends GraphSupplier
		{
			function getTitle()
			{
				return 'K/D Ratio Casual';
			}

			function getID()
			{
				return 'KDC';
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
				return '/api/casual/players';
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return '/api/casual/kd';
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
