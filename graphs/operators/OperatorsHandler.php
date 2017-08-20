<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphUtils.php';
		require_once __DIR__ . '/OperatorGraph.php';

		class OperatorsHandler extends GraphSupplier
		{
			private $operatorGraphs = array();

			function plot()
			{
				foreach($this->operatorGraphs as $ctuIndex => $ctu)
					foreach($ctu as $graphIndex => $graph)
						/** @noinspection PhpUndefinedMethodInspection */
						$graph->plot();
			}

			function processPoint($player, $timestamp)
			{
				if(isset($player['operators']))
					foreach($player['operators'] as $operator)
					{
						$name = $operator['operator']['name'];
						$ctu = $operator['operator']['ctu'];
						if(!isset($this->operatorGraphs[$ctu]))
							$this->operatorGraphs[$ctu] = array();
						if(!isset($this->operatorGraphs[$ctu][$name]))
							$this->operatorGraphs[$ctu][$name] = new OperatorGraph($name, $operator['operator']['images']['badge']);
						/** @noinspection PhpUndefinedMethodInspection */
						$this->operatorGraphs[$ctu][$name]->processPoint($player, $timestamp, $operator['stats']);
					}
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

			public function buildDivs()
			{
				echo '<button class="accordion level1">Operators</button>';
				echo '<div class="panel">';
				foreach($this->operatorGraphs as $ctuIndex => $ctu)
				{
					echo '<button class="accordion level2">' . $ctuIndex . '</button>';
					echo '<div class="panel">';
					foreach($ctu as $graphIndex => $graph)
						/** @noinspection PhpUndefinedMethodInspection */
						$graph->buildDivs();
					echo '</div>';
				}
				echo '</div>';
			}
		}
	}