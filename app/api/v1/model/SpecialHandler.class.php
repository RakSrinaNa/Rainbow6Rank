<?php

	namespace R6
	{
		include_once __DIR__ . "/DBConnection.class.php";

		class SpecialHandler
		{
			/**
			 * DBHandler constructor.
			 */
			public function __construct()
			{
			}

			private function getPlayerUID($player)
			{
				$prepared = DBConnection::getConnection()->prepare("SELECT UID FROM R6_Player WHERE Username=:username");
				$prepared->execute(array(':username' => $player));
				$result = $prepared->fetch();
				if($result)
				{
					return $result['UID'];
				}
				return "ERROR";
			}

			public function getPlayers($ctu, $operator, $special)
			{
				$players = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DISTINCT Username FROM R6_Stats_Operator_Special LEFT JOIN R6_Player ON R6_Stats_Operator_Special.UID = R6_Player.UID LEFT JOIN R6_Operator_Special ON R6_Stats_Operator_Special.OperatorSpecial = R6_Operator_Special.Name LEFT JOIN R6_Operator ON R6_Operator_Special.Operator = R6_Operator.Name WHERE DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND CTU=:ctu AND R6_Operator.Name=:operator AND R6_Stats_Operator_Special.OperatorSpecial=:special");
				$prepared->execute(array(":ctu" => $ctu, ":operator" => $operator, ':special' => $special));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}

			public function getSpecial($ctu, $operator, $special, $player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, SpecialValue FROM R6_Stats_Operator_Special LEFT JOIN R6_Operator_Special ON R6_Stats_Operator_Special.OperatorSpecial = R6_Operator_Special.Name LEFT JOIN R6_Operator ON R6_Operator_Special.Operator = R6_Operator.Name WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND CTU=:ctu AND R6_Operator.Name=:operator AND R6_Stats_Operator_Special.OperatorSpecial=:special");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player), ":ctu" => $ctu, ":operator" => $operator, ':special' => $special));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['SpecialValue']);
				}
				return $data;
			}
		}
	}
