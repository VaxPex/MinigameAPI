<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

abstract class MinigameBase extends PluginBase
{

	use SingletonTrait;

	public $arenas = [];

	protected function onLoad(): void{
		self::setInstance($this);
		echo $this->getAuthors();
	}

	public function addArena(string $arenaName, Arena $arena) : Arena{
		return $this->arenas[$arenaName] = $arena;
	}

	public function getPrefix() : string{
		return $this->getDescription()->getPrefix();
	}

	public function getAuthor() : string{
		return $this->getDescription()->getAuthors()[0];
	}

	public function getAuthors() : string{
		return implode(",", $this->getDescription()->getAuthors());
	}

	public abstract function getNewArena(string $arenaName) : Arena;

	public abstract function joinToArena(Arena $arena, Player $player) : void;

	public abstract function quitFromArena(Arena $arena, Player $player) : void;

	public abstract function startArena(Arena $arena) : void;
}