<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\scheduler\Task;

class ArenaScheduler extends Task
{

	private int $startTime = 30;
	private MinigameBase $plugin;
	private Arena $arena;

	public function __construct(MinigameBase $plugin, Arena $arena)
	{
		$this->plugin = $plugin;
		$this->arena = $arena;
	}

	public function getTimer(): int
	{
		return $this->startTime;
	}

	public function onRun(): void
	{
		if (array_filter($this->arena->getTeams(), function (Team $team) {
				return count($this->arena->getPlayers()) > $team->getMaxPlayers();
			})) {
			$this->startTime--;
			if ($this->startTime < 1) {
				$this->plugin->startArena($this->arena);
			}
		}
	}
}
