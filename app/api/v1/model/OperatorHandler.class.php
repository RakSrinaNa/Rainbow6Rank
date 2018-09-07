<?php

	namespace R6
	{
		include_once __DIR__ . "/DBConnection.class.php";

		class OperatorHandler
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

			public function getPlayers($ctu, $operator)
			{
				$players = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DISTINCT Username FROM R6_Stats_Operator LEFT JOIN R6_Player ON R6_Stats_Operator.UID = R6_Player.UID LEFT JOIN R6_Operator ON R6_Stats_Operator.Operator = R6_Operator.Name WHERE DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND CTU=:ctu AND R6_Operator.Name=:operator");
				$prepared->execute(array(":ctu" => $ctu, ":operator" => $operator));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}

			public function getKD($ctu, $operator,$player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Kills, Deaths FROM R6_Stats_Operator LEFT JOIN R6_Operator ON R6_Stats_Operator.Operator = R6_Operator.Name WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND CTU=:ctu AND R6_Operator.Name=:operator");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player), ":ctu" => $ctu, ":operator" => $operator));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$value = $row['Kills'] / ($row['Deaths'] == 0 ? 1 : $row['Deaths']);
					$data[] = array('date' => $row['DataDate'], 'value' => $value, 'kills' => $row['Kills'], 'deaths' => $row['Deaths']);
				}
				return $data;
			}

			public function getWL($ctu, $operator,$player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Wins, Losses FROM R6_Stats_Operator LEFT JOIN R6_Operator ON R6_Stats_Operator.Operator = R6_Operator.Name WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND CTU=:ctu AND R6_Operator.Name=:operator");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player), ":ctu" => $ctu, ":operator" => $operator));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$value = $row['Wins'] / ($row['Losses'] == 0 ? 1 : $row['Losses']);
					$data[] = array('date' => $row['DataDate'], 'value' => $value, 'wins' => $row['Wins'], 'losses' => $row['Losses']);
				}
				return $data;
			}

			public function getPlaytime($ctu, $operator,$player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Playtime FROM R6_Stats_Operator LEFT JOIN R6_Operator ON R6_Stats_Operator.Operator = R6_Operator.Name WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND CTU=:ctu AND R6_Operator.Name=:operator");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player), ":ctu" => $ctu, ":operator" => $operator));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Playtime']);
				}
				return $data;
			}
		}
	}
