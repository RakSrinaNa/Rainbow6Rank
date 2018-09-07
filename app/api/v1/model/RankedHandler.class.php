<?php

	namespace R6
	{
		include_once __DIR__ . "/DBConnection.class.php";

		class RankedHandler
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

			public function getPlayers($range)
			{
				$players = array();
				$stmt = DBConnection::getConnection()->query("SELECT DISTINCT Username FROM R6_Stats_Ranked LEFT JOIN R6_Player ON R6_Stats_Ranked.UID = R6_Player.UID WHERE DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$result = $stmt->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}

			public function getKD($range, $player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, KD, Kills, Deaths FROM R6_Stats_Ranked WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['KD'], 'kills' => $row['Kills'], 'deaths' => $row['Deaths']);
				}
				return $data;
			}

			public function getWL($range, $player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, WLR, Wins, Losses FROM R6_Stats_Ranked WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['WLR'], 'wins' => $row['Wins'], 'losses' => $row['Losses']);
				}
				return $data;
			}

			public function getPlaytime($range, $player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Playtime FROM R6_Stats_Ranked WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Playtime']);
				}
				return $data;
			}
		}
	}
