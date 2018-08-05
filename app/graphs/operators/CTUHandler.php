<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 24/12/2017
	 * Time: 21:47
	 */

	namespace R6
	{
		class CTUHandler
		{
			private $operatorGraphs = array();
			private $name;

			/**
			 * CTUHandler constructor.
			 *
			 * @param string $name
			 */
			public function __construct($name)
			{
				$this->name = $name;
			}

			public function __toString()
			{
				$res = "CTU: $this->name\n";
				foreach($this->operatorGraphs as $operatorName => $operatorGraph)
					$res .= "\t" .(string) $operatorGraph . "\n";
				return $res;
			}


			/**
			 * @return string
			 */
			public function getName() : string
			{
				return $this->name;
			}

			function processPoint($player, $timestamp, $operator)
			{
				$name = $operator['operator']['name'];
				if(!isset($this->operatorGraphs[$name]))
					$this->operatorGraphs[$name] = new OperatorGraph($name, $operator['operator']['images']['badge']);
				$this->operatorGraphs[$name]->processPoint($player, $timestamp, $operator['stats']);
			}

			function plot()
			{
				foreach($this->operatorGraphs as $operator => $operatorGraph)
				{
					/**
					 * @var $operatorGraph OperatorGraph
					 */
					$name = $operatorGraph->getName();
					echo "<!-- $name -->";
					$operatorGraph->plot();
				}
			}

			public function buildDivs()
			{
				$type = $_SESSION['menuStyle'];
				echo "<ul class='nav nav-${type}s nav-justified'>";
				foreach($this->operatorGraphs as $operator => $operatorGraph)
				{
					/**
					 * @var $operatorGraph OperatorGraph
					 */
					$image = $operatorGraph->getImageURL();
					echo "<li class='nav-item'><a class='nav-link' data-toggle='$type' href='#menuOperator$operator'>$operator<img src='$image' style='max-height: 20px;margin-left: 5px;'></a></li>";
				}
				echo "</ul>";
				echo "<hr/>";
				echo "<div class='tab-content'>";
				foreach($this->operatorGraphs as $operator => $operatorGraph)
				{
					/**
					 * @var $operatorGraph OperatorGraph
					 */
					echo "<div id='menuOperator$operator' class='tab-pane fade'>";
					$operatorGraph->buildDivs();
					echo "</div>";
				}
				echo "</div>";
			}
		}
	}