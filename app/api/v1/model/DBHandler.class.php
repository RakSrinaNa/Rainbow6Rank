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
				return array(array("date" => "2011-06-01", "RakSrinaNa" => 10));
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
