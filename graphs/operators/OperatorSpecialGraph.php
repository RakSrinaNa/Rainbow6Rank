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
	}