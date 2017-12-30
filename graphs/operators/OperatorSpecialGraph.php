<?php
	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 10/06/2017
	 * Time: 11:37
	 */

	namespace R6
	{
		require_once __DIR__ . '/SimpleOperatorGraph.php';

		class OperatorSpecialGraph extends SimpleOperatorGraph
		{
			private $title;

			public function __construct($operator, $id)
			{
				parent::__construct($operator, $id);
				$this->title = $this->findTitle($id);
			}

			function findTitle($name)
			{
				switch($name)
				{
					case 'operatorpvp_black_mirror_gadget_deployed':
						return 'Mirrors deployed';
					case 'operatorpvp_fuze_clusterchargekill':
						return 'Cluster charge kills';
					case 'operatorpvp_thermite_chargekill':
						return 'Charge kills';
					case 'operatorpvp_thermite_chargedeployed':
						return 'Charge deployed';
					case 'operatorpvp_thermite_reinforcementbreached':
						return 'Reinforcement breached';
					case 'operatorpvp_smoke_poisongaskill':
						return 'Gas kills';
					case 'operatorpvp_blitz_flashedenemy':
						return 'Flashed enemies';
					case 'operatorpvp_blitz_flashshieldassist':
						return 'Flashed assists';
					case 'operatorpvp_blitz_flashfollowupkills':
						return 'Flashed kills';
					case 'operatorpvp_cazador_assist_kill':
						return 'Track assists';
					case 'operatorpvp_hibana_detonate_projectile':
						return 'Pellets detonated';
					case 'operatorpvp_echo_enemy_sonicburst_affected':
						return 'Sonic burst hits';
					case 'operatorpvp_doc_selfrevive':
						return 'Self revives';
					case 'operatorpvp_doc_hostagerevive':
						return 'Hostage revives';
					case 'operatorpvp_doc_teammaterevive':
						return 'Teammate revives';
					case 'operatorpvp_bandit_batterykill':
						return 'Battery kills';
					case 'operatorpvp_caveira_interrogations':
						return 'Interrogations';
					case 'operatorpvp_capitao_lethaldartkills':
						return 'Dart kills';
					case 'operatorpvp_pulse_heartbeatspot':
						return 'Heartbeats spotted';
					case 'operatorpvp_pulse_heartbeatassist':
						return 'Heartbeat assists';
					case 'operatorpvp_sledge_hammerhole':
						return 'Hammer holes';
					case 'operatorpvp_sledge_hammerkill':
						return 'Hammer kills';
					case 'operatorpvp_castle_kevlarbarricadedeployed':
						return 'Barricades deployed';
					case 'operatorpvp_glaz_sniperkill':
						return 'Sniper kills';
					case 'operatorpvp_glaz_sniperpenetrationkill':
						return 'Sniper penetration kills';
					case 'operatorpvp_montagne_shieldblockdamage':
						return 'Blocked damages';
					case 'operatorpvp_iq_gadgetspotbyef':
						return 'Gadgets detected';
					case 'operatorpvp_twitch_shockdronekill':
						return 'Shock drone kills';
					case 'operatorpvp_tachanka_turretkill':
						return 'Turret kills';
					case 'operatorpvp_tachanka_turretdeployed':
						return 'Turrets deployed';
					case 'operatorpvp_mute_gadgetjammed':
					case 'operatorpvp_thatcher_gadgetdestroywithemp':
						return 'Gadgets jammed';
					case 'operatorpvp_mute_jammerdeployed':
						return 'Jammers deployed';
					case 'operatorpvp_ash_bonfirekill':
						return 'Explosive bullet kills';
					case 'operatorpvp_ash_bonfirewallbreached':
						return 'Walls breached';
					case 'operatorpvp_rook_armorboxdeployed':
						return 'Armor boxes deployed';
					case 'operatorpvp_rook_armortakenourself':
						return 'Armors taken yourself';
					case 'operatorpvp_rook_armortakenteammate':
						return 'Armors teammates took';
					case 'operatorpvp_blackbeard_gunshieldblockdamage':
						return 'Shield damages taken';
					case 'operatorpvp_buck_kill':
						return 'Shotgun kills';
					case 'operatorpvp_frost_dbno':
						return 'Bear traps injured';
					case 'operatorpvp_twitch_gadgetdestroybyshockdrone':
					case 'operatorpvp_jager_gadgetdestroybycatcher':
						return 'Gadgets deployed';
					case 'operatorpvp_valkyrie_camdeployed':
						return 'Cameras deployed';
					case 'operatorpvp_kapkan_boobytrapkill':
						return 'Booby trap kills';
					case 'operatorpvp_kapkan_boobytrapdeployed';
						return 'Booby traps deployed';
					case 'operatorpve_dazzler_gadget_detonate':
						return 'Dazzler detonated';
					case 'operatorpvp_caltrop_enemy_affected':
						return 'Needles walked on';
					case 'operatorpvp_concussionmine_detonate':
						return 'Concussion mine detonated';
					case 'operatorpvp_concussiongrenade_detonate':
						return 'Concussion grenade detonated';
					case 'operatorpvp_dazzler_gadget_detonate':
						return 'Dazzler detonated';
					case 'operatorpvp_phoneshacked':
						return 'Phones called';
					case 'operatorpvp_attackerdrone_diminishedrealitymode':
						return 'Drones fooled';

				}
				return parent::getTitle();
			}

			function getTitle()
			{
				return $this->title;
			}

			function getPoint($operator)
			{
				$point = array('stat' => 0);
				$point['stat'] = isset($operator['specials'][$this->id]) ? $operator['specials'][$this->id] : 0;
				return $point;
			}
		}
	}