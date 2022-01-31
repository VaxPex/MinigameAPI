<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\player\Player;
use pocketmine\world\World;

class Arena
{

	private World $world;
	private array $data;
	private MinigameBase $plugin;
	private ArenaSettings $settings;
	private array $players = [];
	/**
	 * @var Team[] $teams
	 */
	private array $teams = [];

	public function __construct(MinigameBase $plugin, ArenaSettings $settings, World $world, array $arenaFileData)
	{
		$this->plugin = $plugin;
		$this->world = $world;
		$this->data = $arenaFileData;
		$this->settings = $settings;
		$plugin->getServer()->getPluginManager()->registerEvents(new ArenaListener($this), $plugin);
		$plugin->getScheduler()->scheduleRepeatingTask(new ArenaScheduler($plugin, $this), 20);
	}

	public function getWorld() : World{
		return $this->world;
	}

	public function getData() : array{
		return $this->data;
	}

	public function getSettings() : ArenaSettings {
		return $this->settings;
	}

	public function getPlugin() : MinigameBase {
		return $this->plugin;
	}

	/**
	 * @return Player[]
	 */
	public function getPlayers() : array {
		return $this->players;
	}

	public function inGame(Player $player): bool{
		return isset($this->players[$player->getName()]);
	}

	/**
	 * @return Team[]
	 */
	public function getTeams() : array{
		return $this->teams;
	}

	public function isTeamExist(string $teamName)
	{
		if (isset($this->teams[$teamName])) {
			return true;
		}
		return null;
	}

	public function getPlayerTeam(Player $player)
	{
		foreach ($this->teams as $team) {
			if (!$this->isInTeam($player)) return false;
			if (in_array($player->getName(), array_keys($team->getPlayers()))) {
				return $team;
			}
		}
		return null;
	}

	public function isInTeam(Player $player)
	{
		foreach ($this->teams as $team) {
			if (in_array($player->getName(), array_keys($team->getPlayers()))) return true;
		}
		return null;
	}

	public function setPlayerTeam(Player $player, string $team)
	{
		if ($this->isInTeam($player)) {
			$this->removePlayerFromTeam($player, $team);
		}
		$this->teams[$team]->add($player);
	}

	public function getTeamName(Player $player)
	{
		if (!$this->isInTeam($player)) return "";
		return $this->getPlayerTeam($player)->getName();
	}

	public function getTeamByName(string $team)
	{
		if ($this->isTeamExist($team)) {
			return $this->teams[$team];
		}
		return null;
	}

	public function removePlayerFromTeam(Player $player, string $team)
	{
		if ($this->isTeamExist($team) && $this->isInTeam($player)) {
			return $this->getPlayerTeam($player)->remove($player);
		}
		return null;
	}

	public function getTeamCount(string $teamName)
	{
		if ($this->isTeamExist($teamName)) {
			return count($this->teams[$teamName]->getPlayers());
		}
	}

	public function addTeam(Team $team)
	{
		return $this->teams[$team->getName()] = $team;
	}
}