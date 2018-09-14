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

		class OperatorSpecialGraph extends SimpleOperatorGraph
		{
			private $title;
			private $special;

			public function __construct($ctu, $operator, $id, $title = null)
			{
				parent::__construct($ctu, $operator, $id);
				$this->special = $id;
				$this->title = $title ? $title : $id;
			}

			function getTitle()
			{
				return $this->title;
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return "/api/special/$this->ctu/$this->operator/$this->special/players";
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return "/api/special/$this->ctu/$this->operator/$this->special/special";
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