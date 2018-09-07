<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 05/09/2018
	 * Time: 18:51
	 */

	namespace R6
	{

		use DateTime;

		include_once __DIR__ . "/api/v1/model/DBConnection.class.php";

		class R6StatsParser
		{
			private $json;
			private $uid;
			private $date;

			/**
			 * R6StatsParser constructor.
			 *
			 * @param string $json
			 */
			function __construct($json)
			{
				$this->json = json_decode($json, true);
				$this->uid = $this->json['player']['ubisoft_id'];
				$this->date = $this->getTimestamp($this->json['player']['updated_at']);
			}

			private function getTimestamp($date_str)
			{
				$timeFormat = 'Y-m-d\TH:i:s+';
				$date = DateTime::createFromFormat($timeFormat, $date_str);
				if(!$date)
				{
					echo 'BAD DATE: ' . $date_str;
					return null;
				}
				return $date->getTimestamp();
			}

			public function putInDB()
			{
				if(!$this->date)
				{
					$this->updatePlayer();

					if($this->json['player']['stats'])
					{
						$this->updateCasual();
						$this->updateRanked();
						$this->updateOverall();
						$this->updateProgression();
					}

					$this->updateRankedSeason();

					$this->updateOperators();
				}
				else
				{
					echo 'BAD Object!';
					print_r($this);
				}
			}

			private function updatePlayer()
			{
				$player = $this->json['player'];

				$this->sendRequest("INSERT INTO R6_Player(UID, Username, Platform, Indexed) VALUES(:uid, :username, :platform, FROM_UNIXTIME(:timeindexed)) ON DUPLICATE KEY UPDATE Updated=FROM_UNIXTIME(:timeupdated)", array(':uid' => $this->uid, ':username' => $player['username'], ':platform' => $player['platform'], ':timeindexed' => $this->getTimestamp($player['indexed_at']), ':timeupdated' => $this->date));
			}

			private function sendRequest($statement, $args = array())
			{
				$conn = DBConnection::getConnection();

				$prepared = $conn->prepare($statement);
				$result = $prepared->execute($args);
				if(!$result)
				{
					print_r($prepared->errorInfo());
				}
				return $result;
			}

			private function updateCasual()
			{
				$stats = $this->json['player']['stats']['casual'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Casual(UID, DataDate, Played, Wins, Losses, WLR, Kills, Deaths, KD, Playtime) VALUES(:uid, FROM_UNIXTIME(:datadate), :played, :wins, :losses, :wlr, :kills, :deaths, :kd, :playtime)", array(":uid" => $this->uid, ":datadate" => $this->date, ":played" => $stats['has_played'], ":wins" => $stats['wins'], ":losses" => $stats['losses'], ":wlr" => $stats['wlr'], ":kills" => $stats['kills'], ":deaths" => $stats['deaths'], ":kd" => $stats['kd'], ":playtime" => $stats['playtime']));
			}

			private function updateRanked()
			{
				$stats = $this->json['player']['stats']['ranked'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Ranked(UID, DataDate, Played, Wins, Losses, WLR, Kills, Deaths, KD, Playtime) VALUES(:uid, FROM_UNIXTIME(:datadate), :played, :wins, :losses, :wlr, :kills, :deaths, :kd, :playtime)", array(":uid" => $this->uid, ":datadate" => $this->date, ":played" => $stats['has_played'], ":wins" => $stats['wins'], ":losses" => $stats['losses'], ":wlr" => $stats['wlr'], ":kills" => $stats['kills'], ":deaths" => $stats['deaths'], ":kd" => $stats['kd'], ":playtime" => $stats['playtime']));
			}

			private function updateOverall()
			{
				$stats = $this->json['player']['stats']['overall'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Overall(UID, DataDate, Revives, Suicides, ReinforcementsDeployed, BarricadesBuilt, StepsMoved, BulletsFired, BulletsHit, Headshots, MeleeKills, PenetrationKills, Assists) VALUES(:uid, FROM_UNIXTIME(:datadate), :revives, :suicides, :reinforcements, :barricades, :steps, :fired, :hit, :headshots, :melee, :penetration, :assists)", array(":uid" => $this->uid, ":datadate" => $this->date, ":revives" => $stats['revives'], ":suicides" => $stats['suicides'], ":reinforcements" => $stats['reinforcements_deployed'], ":barricades" => $stats['barricades_built'], ":steps" => $stats['steps_moved'], ":fired" => $stats['bullets_fired'], ":hit" => $stats['bullets_hit'], ":headshots" => $stats['headshots'], ":melee" => $stats['melee_kills'], ":penetration" => $stats['penetration_kills'], ":assists" => $stats['assists']));
			}

			private function updateProgression()
			{
				$stats = $this->json['player']['stats']['progression'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Progression(UID, DataDate, Level, XP) VALUES(:uid, FROM_UNIXTIME(:datadate), :level, :xp)", array(":uid" => $this->uid, ":datadate" => $this->date, ":level" => $stats['level'], ":xp" => $stats['xp']));
			}

			private function updateRankedSeason()
			{
				$seasons = $this->json['seasons'];
				if(!$seasons)
					return;
				$regions = end($seasons);
				$season = end($regions);
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Season(UID, DataDate, SeasonNumber, Region, Wins, Losses, Abandons, Rating, NextRating, PreviousRating, Mean, StandardDeviation, Rank) VALUES(:uid, FROM_UNIXTIME(:datadate), :seasonnumber, :region, :wins, :losses, :abandons, :rating, :nextrating, :previousrating, :mean, :stddev, :rank)", array(":uid" => $this->uid, ":datadate" => $this->date, ":seasonnumber" => $season['season'], ":region" => $season['region'], ":wins" => $season['wins'], ":losses" => $season['losses'], ":abandons" => $season['abandons'], ":rating" => $season['ranking']['rating'], ":nextrating" => $season['ranking']['next_rating'], ":previousrating" => $season['ranking']['prev_rating'], ":mean" => $season['ranking']['mean'], ":stddev" => $season['ranking']['stdev'], ":rank" => $season['ranking']['rank']));
			}

			private function updateOperators()
			{
				if($this->json['operators'])
				{
					foreach($this->json['operators'] as $operator)
					{
						$this->addOperator($operator);
						$this->updateOperator($operator);
					}
				}
			}

			private function addOperator($operator)
			{
				$this->sendRequest("INSERT IGNORE INTO R6_Operator(Name, Role, CTU, ImageFigure, ImageBadge, ImageBust) VALUES(:name, :role, :ctu, :figure, :badge, :bust)", array(":name" => $operator['operator']["name"], ":role" => $operator['operator']["role"], ":ctu" => $operator['operator']["ctu"], ":figure" => $operator['operator']["images"]["figure"], ":badge" => $operator['operator']["images"]["badge"], ":bust" => $operator['operator']["images"]["bust"]));
				$sql = array();
				$values = array();
				foreach($operator['stats']['specials'] as $special => $value)
				{
					$sql[] = "(:o$special, :$special)";
					$values[":o$special"] = $operator['operator']["name"];
					$values[":$special"] = $special;
				}
				$this->sendRequest("INSERT IGNORE INTO R6_Operator_Special(Operator, Name) VALUES " . implode(",", $sql), $values);
			}

			private function updateOperator($operator)
			{
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Operator(UID, DataDate, Operator, Played, Wins, Losses, Kills, Deaths, Playtime) VALUES (:uid, FROM_UNIXTIME(:datadate), :operator, :played, :wins, :losses, :kills, :deaths, :playtime)", array(":uid" => $this->uid, ":datadate" => $this->date, ":operator" => $operator['operator']["name"], ":played" => $operator['stats']["played"], ":wins" => $operator['stats']["wins"], ":losses" => $operator['stats']["losses"], ":kills" => $operator['stats']["kills"], ":deaths" => $operator['stats']["deaths"], ":playtime" => $operator['stats']["playtime"],));

				$sql = array();
				$values = array();
				foreach($operator['stats']['specials'] as $special => $value)
				{
					$sql[] = "(:u$special, FROM_UNIXTIME(:d$special), :o$special, :$special)";
					$values[":u$special"] = $this->uid;
					$values[":d$special"] = $this->date;
					$values[":o$special"] = $special;
					$values[":$special"] = $value;
				}
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Operator_Special(UID, DataDate, OperatorSpecial, SpecialValue) VALUES " . implode(",", $sql), $values);
			}
		}
	}
