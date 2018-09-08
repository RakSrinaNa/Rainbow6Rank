<?php

	namespace R6
	{
		include_once __DIR__ . "/DBConnection.class.php";

		class ProgressionHandler
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
				$prepared = DBConnection::getConnection()->prepare("SELECT DISTINCT Username FROM R6_Stats_Progression LEFT JOIN R6_Player ON R6_Stats_Progression.UID = R6_Player.UID WHERE DataDate >= DATE_SUB(NOW(), INTERVAL :days DAY)");
				$prepared->execute(array(':days' => $range));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}

			public function getLevel($range, $player)
			{
				$data = array();
				$prepared = DBConnection::getConnection()->prepare("SELECT DataDate, Level, XP FROM R6_Stats_Progression WHERE UID=:uid AND DataDate >= DATE_SUB(NOW(), INTERVAL :days DAY)");
				$prepared->execute(array(":uid" => $this->getPlayerUID($player), ':days' => $range));
				$result = $prepared->fetchAll();
				foreach($result as $key => $row)
				{
					$data[] = array('date' => $row['DataDate'], 'value' => $row['Level'], 'xp' => $row['XP']);
				}
				return $data;
			}
		}
	}
