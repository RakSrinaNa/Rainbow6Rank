<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:44
	 */

	require_once __DIR__ . '/../../model/GraphSupplier.php';

	abstract class SimpleOperatorGraph extends GraphSupplier
	{
		protected $id;
		protected $operator;

		public function __construct($operator, $id)
		{
			$this->operator = $operator;
			$this->id = $id;
		}

		function getID()
		{
			return $this->operator . $this->id;
		}

		function getTitle()
		{
			return $this->id . ' ' . $this->operator;
		}
	}