<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:37
	 */

	namespace R6
	{
		require_once __DIR__ . '/SimpleOperatorGraph.php';

		class OperatorKillDeathGraph extends SimpleOperatorGraph
		{
			public function __construct($ctu, $operator)
			{
				parent::__construct($ctu, $operator, "KD");
			}

			function getTitle()
			{
				return 'K/D Ratio ' . $this->operator;
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return "/api/operator/$this->ctu/$this->operator/players";
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return "/api/operator/$this->ctu/$this->operator/kd";
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
				return "KD: {value}\\nKills: {kills}\\nDeaths: {deaths}";
			}
		}
	}