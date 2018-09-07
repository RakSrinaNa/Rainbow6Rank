<?php

	namespace R6
	{
		include_once __DIR__ . "/DBConnection.class.php";

		class OverallHandler
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

			public function getPlayers()
			{
				$players = array();
				$stmt = DBConnection::getConnection()->query("SELECT DISTINCT Username FROM R6_Stats_Overall LEFT JOIN R6_Player ON R6_Stats_Overall.UID = R6_Player.UID WHERE DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$result = $stmt->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}

			public function getAccuracy($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, BulletsFired, BulletsHit FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$value = $row['BulletsHit'] / ($row['BulletsFired'] == 0 ? 1 : $row['BulletsFired']);
					$data[] = array('date' => $row['DataDate'], 'value' => $value, 'fired' => $row['BulletsFired'], 'hits' => $row['BulletsHit']);
				}
				return $data;
			}

			public function getAssists($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Assists FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Assists']);
				}
				return $data;
			}

			public function getBarricades($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, BarricadesBuilt FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['BarricadesBuilt']);
				}
				return $data;
			}

			public function getHeadshots($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Headshots FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Headshots']);
				}
				return $data;
			}

			public function getMelee($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, MeleeKills FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['MeleeKills']);
				}
				return $data;
			}

			public function getPenetration($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, PenetrationKills FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['PenetrationKills']);
				}
				return $data;
			}
			public function getReinforcements($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, ReinforcementsDeployed FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['ReinforcementsDeployed']);
				}
				return $data;
			}
			public function getRevives($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Revives FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Revives']);
				}
				return $data;
			}
			public function getSteps($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, StepsMoved FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['StepsMoved']);
				}
				return $data;
			}
			public function getSuicides($player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Suicides FROM R6_Stats_Overall WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player)));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Suicides']);
				}
				return $data;
			}
		}
	}
