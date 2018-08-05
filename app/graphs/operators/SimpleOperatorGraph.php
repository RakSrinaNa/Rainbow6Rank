<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:44
	 */

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';

		abstract class SimpleOperatorGraph extends GraphSupplier
		{
			protected $id;
			protected $operator;

			/**
			 * SimpleOperatorGraph constructor.
			 *
			 * @param string $operator
			 * @param string $id
			 */
			public function __construct($operator, $id)
			{
				$this->operator = $operator;
				$this->id = $id;
			}

			/**
			 * @return string
			 */
			function getID()
			{
				return $this->operator . $this->id;
			}

			/**
			 * @return string
			 */
			function getTitle()
			{
				return $this->id . ' ' . $this->operator;
			}

			/**
			 * @param array $player
			 * @param string $timestamp
			 * @param array $operator
			 */
			function processPoint($player, $timestamp, $operator = array())
			{
				$username = $player['player']['username'];
				if(!isset($this->datas[$username]))
					$this->datas[$username] = array();
				$data = $this->getPoint($operator);
				if($data === null)
					return;
				$data['timestamp'] = $timestamp;
				$this->datas[$username][$player['player']['updated_at']] = $data;
			}
		}
	}