<?php

	namespace R6
	{
		include_once __DIR__ . "/DBConnection.class.php";

		class DBHandler
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

			public function casualPlayers()
			{
				$players = array();
				$stmt = DBConnection::getConnection()->query("SELECT DISTINCT Username FROM R6_Stats_Casual LEFT JOIN R6_Player ON R6_Stats_Casual.UID = R6_Player.UID WHERE DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$result = $stmt->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}

			public function casualKD($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, KD FROM R6_Stats_Casual WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['KD']);
				}
				return $data;
			}

			public function casualWL($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, WLR FROM R6_Stats_Casual WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['WLR']);
				}
				return $data;
			}

			public function casualPlaytime($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Playtime FROM R6_Stats_Casual WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Playtime']);
				}
				return $data;
			}

			public function rankedPlayers()
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

			public function rankedKD($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, KD FROM R6_Stats_Ranked WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['KD']);
				}
				return $data;
			}

			public function rankedWL($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, WLR FROM R6_Stats_Ranked WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['WLR']);
				}
				return $data;
			}

			public function rankedPlaytime($player)
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
