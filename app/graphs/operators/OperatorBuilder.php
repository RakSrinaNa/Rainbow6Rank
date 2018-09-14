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
		require_once __DIR__ . '/../../api/v1/model/DBConnection.class.php';
		require_once __DIR__ . '/OperatorSpecialGraph.php';
		require_once __DIR__ . '/OperatorWinLossGraph.php';
		require_once __DIR__ . '/OperatorKillDeathGraph.php';
		require_once __DIR__ . '/OperatorPlaytimeGraph.php';

		class OperatorBuilder extends GraphSupplier
		{
			private $graphs = array();
			private $name;
			private $ctu;
			private $imageURL;

			public function __toString()
			{
				return "Operator graph [$this->name]";
			}

			public function __construct($ctu, $name)
			{
				$this->ctu = $ctu;
				$this->name = $name;
				$prepared = DBConnection::getConnection()->prepare("SELECT ImageBadge FROM R6_Operator WHERE CTU=:ctu AND Name=:operator");
				$prepared->execute(array(":ctu" => $ctu, ":operator" => $name));
				$result = $prepared->fetch();
				if($result)
				{
					$this->imageURL = $result['ImageBadge'];
				}
				$this->graphs[] = new OperatorKillDeathGraph($ctu, $name);
				$this->graphs[] = new OperatorPlaytimeGraph($ctu, $name);
				$this->graphs[] = new OperatorWinLossGraph($ctu, $name);

				$prepared = DBConnection::getConnection()->prepare("SELECT Name, DisplayName FROM R6_Operator_Special WHERE Operator=:operator");
				$prepared->execute(array(":operator" => $name));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$this->graphs[] = new OperatorSpecialGraph($ctu, $name, $row['Name'], $row['DisplayName']);
				}
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