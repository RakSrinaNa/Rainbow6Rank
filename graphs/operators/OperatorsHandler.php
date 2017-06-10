<?php
	require_once __DIR__ . '/../../model/GraphUtils.php';
	require_once __DIR__ . '/OperatorGraph.php';

	class OperatorsHandler extends GraphSupplier
	{
		private $operatorGraphs = array();

		function plot()
		{
			foreach($this->operatorGraphs as $graphIndex => $graph)
				$graph->plot();
		}

		function processPoint($player, $timestamp)
		{
			foreach($player['operators'] as $operator)
			{
				$name = $operator['operator']['name'];
				if(!isset($this->operatorGraphs[$name]))
					$this->operatorGraphs[$name] = new OperatorGraph($name);
				$this->operatorGraphs[$name]->processPoint($player, $timestamp, $operator['stats']);
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
			foreach($this->operatorGraphs as $graphIndex => $graph)
				$graph->buildDivs();
			echo '</div>';
		}
	}