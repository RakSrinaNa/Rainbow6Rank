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

		class OperatorWinLossGraph extends SimpleOperatorGraph
		{
			public function __construct($ctu, $operator)
			{
				parent::__construct($ctu, $operator, "WL");
			}

			function getTitle()
			{
				return 'W/L Ratio ' . $this->operator;
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
				return "/api/operator/$this->ctu/$this->operator/wl";
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