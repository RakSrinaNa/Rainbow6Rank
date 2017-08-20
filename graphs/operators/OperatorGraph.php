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

			public function __construct($name, $imageURL)
			{
				$this->name = $name;
				$this->imageURL = $imageURL;
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
				echo '<button class="accordion level3">' . $this->name . '<img src="' . $this->imageURL . '"/></button>';
				echo '<div class="panel">';
				foreach($this->graphs as $graphValue => $graph)
				{
					echo '<button class="accordion level4">' . $graph->getTitle() . '</button>';
					echo '<div class="chartHolder panel" id="chartHolder' . $graph->getID() . '"><div class="chartDiv" id="chartDiv' . $graph->getID() . '"></div></div>';
				}
				echo '</div>';
			}

			function plot()
			{
				foreach($this->graphs as $graphIndex => $graph)
					$graph->plot();
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