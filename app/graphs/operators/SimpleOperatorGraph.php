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
			protected $ctu;
			protected $operator;

			/**
			 * SimpleOperatorGraph constructor.
			 *
			 * @param string $ctu
			 * @param string $operator
			 * @param string $id
			 */
			public function __construct($ctu, $operator, $id)
			{
				$this->ctu = $ctu;
				$this->operator = $operator;
				$this->id = $id;
			}

			/**
			 * @return string
			 */
			function getID()
			{
				return $this->ctu . $this->operator . $this->id;
			}

			/**
			 * @return string
			 */
			function getTitle()
			{
				return $this->id . ' ' . $this->operator;
			}
		}
	}