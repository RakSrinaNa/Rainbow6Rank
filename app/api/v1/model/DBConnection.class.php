<?php

	namespace R6
	{

		use PDO;

		final class DBConnection
		{
			/**
			 * @var \PDO
			 */
			private static $conn;

			/**
			 * @return \PDO
			 */
			public static function getConnection()
			{
				if(!DBConnection::$conn || !is_resource(DBConnection::$conn))
				{
					$infos = include __DIR__ . '/../../../../../configs/database.config.php';
					DBConnection::$conn = $pdo = new PDO("mysql:host=" . $infos['host'] . ";dbname=" . $infos['database'] . ";charset=utf8", $infos['username'], $infos['password']);
					$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					$pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
				}
				return DBConnection::$conn;
			}
		}
	}
