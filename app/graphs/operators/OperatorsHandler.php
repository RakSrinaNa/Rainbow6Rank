<?php

	namespace R6
	{
		require_once __DIR__ . '/../../model/GraphUtils.php';
		require_once __DIR__ . '/OperatorGraph.php';

		class OperatorsHandler extends GraphSupplier
		{
			private $ctuGraphs = array();

			function plot()
			{
				foreach($this->ctuGraphs as $ctuIndex => $ctu)
				{
					/**
					 * @var $ctu CTUHandler
					 */
					$name = $ctu->getName();
					echo "<!-- $name -->";
					$ctu->plot();
				}
			}

			function processPoint($player, $timestamp)
			{
				if(isset($player['operators']))
					foreach($player['operators'] as $operator)
					{
						$ctu = $operator['operator']['ctu'];
						if(!isset($this->ctuGraphs[$ctu]))
							$this->ctuGraphs[$ctu] = new CTUHandler($ctu);
						$this->ctuGraphs[$ctu]->processPoint($player, $timestamp, $operator);
					}
			}

			function getID()
			{
				return "OperatorsHandler";
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
				$type = $_SESSION['menuStyle'];
				echo "<ul class='nav nav-${type}s nav-justified'>";
				foreach($this->ctuGraphs as $ctuIndex => $ctu)
				{
					$name = str_replace(" ", "_", $ctuIndex);
					echo "<li class='nav-item'><a class='nav-link' data-toggle='$type' href='#menuCTU$name'>$ctuIndex</a></li>";
				}
				echo "</ul>";
				echo "<hr/>";
				echo "<div class='tab-content'>";
				foreach($this->ctuGraphs as $ctuIndex => $ctu)
				{
					/**
					 * @var $ctu CTUHandler
					 */
					$name = str_replace(" ", "_", $ctuIndex);
					echo "<div id='menuCTU$name' class='tab-pane fade'>";
					$ctu->buildDivs();
					echo "</div>";
				}
				echo "</div>";
			}
		}
	}