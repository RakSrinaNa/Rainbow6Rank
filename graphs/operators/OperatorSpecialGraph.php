<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:37
	 */
	require_once __DIR__ . '/SimpleOperatorGraph.php';

	class OperatorSpecialGraph extends SimpleOperatorGraph
	{
		function getPoint($operator)
		{
			$point = array('stat' => 0);
			$point['stat'] = $operator['specials'][$this->id];
			return $point;
		}

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