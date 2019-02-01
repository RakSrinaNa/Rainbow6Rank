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
				$this->uid = $this->json['player']['profile_id'];
				$this->date = $this->getTimestamp($this->json['player']['update_time']);
			}

			private function getTimestamp($date_str)
			{
				$timeFormat = 'Y-m-d\TH:i:s+';
				$date = DateTime::createFromFormat($timeFormat, $date_str);
				if(!$date)
				{
					echo 'BAD DATE: ' . $date_str . "<br/>\n";
					return null;
				}
				return $date->getTimestamp();
			}

			public function putInDB()
			{
				if($this->date)
				{
					$this->updatePlayer();
					$this->updateRanked();
					$this->updateProgression();
					$this->updateCasual();
					$this->updateOverall();
					$this->updateRankedSeason();
				}
				else
				{
					echo 'BAD Object!';
					print_r($this);
					echo "<br/>\n";
				}
			}

			private function updatePlayer()
			{
				$player = $this->json['player'];

				$this->sendRequest("INSERT INTO R6_Player(UID, Username, Platform) VALUES(:uid, :username, :platform) ON DUPLICATE KEY UPDATE Updated=FROM_UNIXTIME(:timeupdated)", array(':uid' => $this->uid, ':username' => $player['nickname'], ':platform' => $player['platform'], ':timeupdated' => $this->date));
			}

			private function sendRequest($statement, $args = array())
			{
				$conn = DBConnection::getConnection();

				$prepared = $conn->prepare($statement);
				$result = $prepared->execute($args);
				if(!$result)
				{
					echo "<br/>\n";
					echo "SQL Error: ";
					print_r($prepared->errorInfo());
					echo "<br/>\n";
				}
				return $result;
			}

			private function updateCasual()
			{
				$stats = $this->json['stats'];
				$kd = $stats['casualpvp_death'] == 0 ? 0 : ($stats['casualpvp_kills'] / $stats['casualpvp_death']);
				$wl = $stats['casualpvp_matchlost'] == 0 ? 0 : ($stats['casualpvp_matchwon'] / $stats['casualpvp_matchlost']);
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Casual(UID, DataDate, Wins, Losses, WLR, Kills, Deaths, KD, Playtime) VALUES(:uid, FROM_UNIXTIME(:datadate), :wins, :losses, :wlr, :kills, :deaths, :kd, :playtime)", array(":uid" => $this->uid, ":datadate" => $this->date, ":wins" => $stats['casualpvp_matchwon'], ":losses" => $stats['casualpvp_matchlost'], ":wlr" => $wl, ":kills" => $stats['casualpvp_kills'], ":deaths" => $stats['casualpvp_death'], ":kd" => $kd, ":playtime" => $stats['casualpvp_timeplayed']));
			}

			private function updateRanked()
			{
				$stats = $this->json['stats'];
				$kd = $stats['rankedpvp_death'] == 0 ? 0 : ($stats['rankedpvp_kills'] / $stats['rankedpvp_death']);
				$wl = $stats['rankedpvp_matchlost'] == 0 ? 0 : ($stats['rankedpvp_matchwon'] / $stats['rankedpvp_matchlost']);
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Ranked(UID, DataDate, Wins, Losses, WLR, Kills, Deaths, KD, Playtime) VALUES(:uid, FROM_UNIXTIME(:datadate), :wins, :losses, :wlr, :kills, :deaths, :kd, :playtime)", array(":uid" => $this->uid, ":datadate" => $this->date, ":wins" => $stats['rankedpvp_matchwon'], ":losses" => $stats['rankedpvp_matchlost'], ":wlr" => $wl, ":kills" => $stats['rankedpvp_kills'], ":deaths" => $stats['rankedpvp_death'], ":kd" => $kd, ":playtime" => $stats['rankedpvp_timeplayed']));
			}

			private function updateOverall()
			{
				$stats = $this->json['stats'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Overall(UID, DataDate, Revives, Suicides, ReinforcementsDeployed, BarricadesBuilt, StepsMoved, BulletsFired, BulletsHit, Headshots, MeleeKills, PenetrationKills, Assists, DBNO, DBNOAssists, GadgetsDestroyed) VALUES(:uid, FROM_UNIXTIME(:datadate), :revives, :suicides, :reinforcements, :barricades, :steps, :fired, :hit, :headshots, :melee, :penetration, :assists, :dbno, :dbnoassists, :gadgetsdestroyed)", array(
					":uid" => $this->uid,
					":datadate" => $this->date,
					":revives" => $stats['generalpvp_revive'],
					":suicides" => $stats['generalpvp_suicide'],
					":reinforcements" => $stats['generalpvp_reinforcementdeploy'],
					":barricades" => $stats['generalpvp_barricadedeployed'],
					":steps" => $stats['generalpvp_distancetravelled'],
					":fired" => $stats['generalpvp_bulletfired'],
					":hit" => $stats['generalpvp_bullethit'],
					":headshots" => $stats['generalpvp_headshot'],
					":melee" => $stats['generalpvp_meleekills'],
					":penetration" => $stats['generalpvp_penetrationkills'],
					":assists" => $stats['generalpvp_killassists'],
					":dbno" => $stats["generalpvp_dbno"],
					":dbnoassists" => $stats["generalpvp_dbnoassists"],
					":gadgetsdestroyed" => $stats["generalpvp_gadgetdestroy"]));
			}

			private function updateProgression()
			{
				$stats = $this->json['player'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Progression(UID, DataDate, Level, XP) VALUES(:uid, FROM_UNIXTIME(:datadate), :level, :xp)", array(":uid" => $this->uid, ":datadate" => $this->date, ":level" => $stats['level'], ":xp" => $stats['xp']));
			}

			private function updateRankedSeason()
			{
				$season = $this->json['player'];
				$this->sendRequest("INSERT IGNORE INTO R6_Stats_Season(UID, DataDate, SeasonNumber, Region, Wins, Losses, Abandons, Rating, NextRating, PreviousRating, Mean, StandardDeviation, `Rank`) VALUES(:uid, FROM_UNIXTIME(:datadate), :seasonnumber, :region, :wins, :losses, :abandons, :rating, :nextrating, :previousrating, :mean, :stddev, :rank)", array(":uid" => $this->uid, ":datadate" => $this->date, ":seasonnumber" => $season['season'], ":region" => $season['region'], ":wins" => $season['wins'], ":losses" => $season['losses'], ":abandons" => $season['abandons'], ":rating" => $season['mmr'], ":nextrating" => $season['next_rank_mmr'], ":previousrating" => $season['previous_rank_mmr'], ":mean" => $season['skill_mean'], ":stddev" => $season['skill_stdev'], ":rank" => $season['rank']));
			}
		}
	}
