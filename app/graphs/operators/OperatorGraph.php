<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:20
	 */

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphSupplier.php';
		require_once __DIR__ . '/OperatorSpecialGraph.php';
		require_once __DIR__ . '/OperatorWinLossGraph.php';
		require_once __DIR__ . '/OperatorKillDeathGraph.php';
		require_once __DIR__ . '/OperatorPlaytimeGraph.php';

		class OperatorGraph extends GraphSupplier
		{
			private $graphs = array();
			private $name;
			private $imageURL;

			public function __toString()
			{
				return "Operator graph [$this->name]";
			}

			public function __construct($name, $imageURL)
			{
				$this->name = $name;
				$this->imageURL = $imageURL;
			}

			/**
			 * @return mixed
			 */
			public function getName()
			{
				return $this->name;
			}

			/**
			 * @return mixed
			 */
			public function getImageURL()
			{
				return $this->imageURL;
			}

			function getID()
			{
				return null;
			}

			function getPoint($player)
			{
				return null;
			}

			function getTitle()
			{
				return null;
			}

			function buildDivs()
			{
				foreach($this->graphs as $graphValue => $graph)
				{
					echo '<div class="chartHolder" id="chartHolder' . $graph->getID() . '"><div class="chartDiv" id="chartDiv' . $graph->getID() . '"></div></div>';
				}
			}

			function plot()
			{
				foreach($this->graphs as $graphIndex => $graph)
				{
					/**
					 * @var $graph GraphSupplier
					 */
					$name = $graph->getID();
					echo "<!-- $name -->";
					$graph->plot();
				}
			}

			function processPoint($player, $timestamp, $operator = array())
			{
				if(!isset($this->graphs['wl']))
					$this->graphs['wl'] = new OperatorWinLossGraph($this->name, 'wl');
				if(!isset($this->graphs['kd']))
					$this->graphs['kd'] = new OperatorKillDeathGraph($this->name, 'kd');
				if(!isset($this->graphs['pt']))
					$this->graphs['pt'] = new OperatorPlaytimeGraph($this->name, 'pt');
				foreach($operator['specials'] as $specialIndex => $specialValue)
					if(!isset($this->graphs[$specialIndex]))
						$this->graphs[$specialIndex] = new OperatorSpecialGraph($this->name, $specialIndex);

				foreach($this->graphs as $graph)
					$graph->processPoint($player, $timestamp, $operator);
			}
		}
	}