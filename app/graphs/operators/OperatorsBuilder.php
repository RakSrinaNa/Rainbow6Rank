<?php

	namespace R6
	{
		require_once __DIR__ . '/CTUBuilder.php';
		require_once __DIR__ . '/../../model/GraphSupplier.php';
		require_once __DIR__ . '/../../api/v1/model/DBConnection.class.php';

		class OperatorsBuilder extends GraphSupplier
		{
			private $ctuGraphs = array();

			function __construct(){
				$stmt = DBConnection::getConnection()->query("SELECT DISTINCT CTU FROM R6_Operator");
				$result = $stmt->fetchAll();
				foreach($result as $key => $row)
				{
					$this->ctuGraphs[] = new CTUBuilder($row['CTU']);
				}
			}

			function plot()
			{
				foreach($this->ctuGraphs as $ctuIndex => $ctu)
				{
					/**
					 * @var $ctu CTUBuilder
					 */
					$name = $ctu->getCTU();
					echo "<!-- $name -->";
					$ctu->plot();
				}
			}

			function getID()
			{
				return "OperatorsBuilder";
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
					 * @var $ctu CTUBuilder
					 */
					$name = str_replace(" ", "_", $ctuIndex);
					echo "<div id='menuCTU$name' class='tab-pane fade'>";
					$ctu->buildDivs();
					echo "</div>";
				}
				echo "</div>";
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return "/api/operator";
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return "/api/operator";
			}

			/**
			 * @return string
			 */
			function getWeeklyDataProvider()
			{
				return $this->getAllDataProvider();
			}
		}
	}