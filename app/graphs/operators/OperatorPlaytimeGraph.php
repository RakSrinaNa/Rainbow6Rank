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

		class OperatorPlaytimeGraph extends SimpleOperatorGraph
		{
			public function __construct($ctu, $operator)
			{
				parent::__construct($ctu, $operator, "PT");
			}

			function getTitle()
			{
				return 'Playtime ' . $this->operator;
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
				return "/api/operator/$this->ctu/$this->operator/playtime";
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