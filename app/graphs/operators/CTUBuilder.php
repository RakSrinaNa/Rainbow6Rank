<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 24/12/2017
	 * Time: 21:47
	 */

	namespace R6
	{
		require_once __DIR__ . '/OperatorBuilder.php';
		require_once __DIR__ . '/../../model/GraphSupplier.php';
		require_once __DIR__ . '/../../api/v1/model/DBConnection.class.php';

		class CTUBuilder extends GraphSupplier
		{
			private $operatorGraphs = array();
			private $ctu;

			/**
			 * CTUBuilder constructor.
			 *
			 * @param string $ctu
			 */
			public function __construct($ctu)
			{
				$this->ctu = $ctu;
				$stmt = DBConnection::getConnection()->prepare("SELECT Name FROM R6_Operator WHERE CTU=:ctu");
				$stmt->execute(array(":ctu" => $ctu));
				$result = $stmt->fetchAll();
				foreach($result as $key => $row)
				{
					$this->operatorGraphs[$row['Name']] = new OperatorBuilder($ctu, $row['Name']);
				}
			}

			public function __toString()
			{
				$res = "CTU: $this->ctu\n";
				foreach($this->operatorGraphs as $operatorName => $operatorGraph)
					$res .= "\t" . (string) $operatorGraph . "\n";
				return $res;
			}

			/**
			 * @return string
			 */
			public function getCTU() : string
			{
				return $this->ctu;
			}

			function plot()
			{
				foreach($this->operatorGraphs as $operator => $operatorGraph)
				{
					/**
					 * @var $operatorGraph OperatorBuilder
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
					 * @var $operatorGraph OperatorBuilder
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
					 * @var $operatorGraph OperatorBuilder
					 */
					echo "<div id='menuOperator$operator' class='tab-pane fade'>";
					$operatorGraph->buildDivs();
					echo "</div>";
				}
				echo "</div>";
			}

			/**
			 * @return string
			 */
			function getID()
			{
				return $this->getCTU();
			}

			/**
			 * @return string
			 */
			function getTitle()
			{
				return $this->getAllDataProvider();
			}

			/**
			 * @return string
			 */
			function getPlayersURL()
			{
				return null;
			}

			/**
			 * @return string
			 */
			function getAllDataProvider()
			{
				return null;
			}

			/**
			 * @return string
			 */
			function getWeeklyDataProvider()
			{
				return null;
			}
		}
	}