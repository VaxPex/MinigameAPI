<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\player\Player;

class Team
{

	/** @var Player[] $players */
	protected $players = [];

	/** @var string $color */
	protected $color;

	/** @var string $name */
	protected $name;

	/** @var int $maxplayers */
	private $maxplayers = 4;

	/**
	 * Team constructor.
	 *
	 * @param string $name
	 * @param string $color
	 */
	public function __construct(string $name, string $color)
	{
		$this->name = $name;
		$this->color = $color;
	}

	/**
	 * @param Player $player
	 */
	public function add(Player $player): void
	{
		if (count($this->players) < $this->maxplayers) {
			$this->players[$player->getName()] = $player;
		}
	}

	public function remove(Player $player): void
	{
		unset($this->players[$player->getName()]);
	}

	/**
	 * @return string
	 */
	public function getColor(): string
	{
		return $this->color;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getPlayers(): array
	{
		return $this->players;
	}

	public function reset(): void
	{
		$this->players = [];
	}

	public function setMaxPlayers(int $number){
		$this->maxplayers = $number;
	}

	public function getMaxPlayers()
	{
		return $this->maxplayers;
	}
}