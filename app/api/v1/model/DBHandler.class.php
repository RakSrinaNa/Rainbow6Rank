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

			public function casualKD()
			{
//				$data = array();
//				$stmt = DBConnection::getConnection()->query("SELECT KD FROM R6_Stats_Casual");
//				$result = $stmt->fetchAll();
//				foreach($result as $key => $row)
//				{
//					$data[] = $row['Username'];
//				}
//				return $data;
				return array(array("date" => "2011-06-01", "value" => 10));
			}

			public function casualKDPlayers()
			{
				$players = array();
				$stmt = DBConnection::getConnection()->query("SELECT Username FROM R6_Player");
				$result = $stmt->fetchAll();
				foreach($result as $key => $row)
				{
					$players[] = $row['Username'];
				}
				return $players;
			}
		}
	}
