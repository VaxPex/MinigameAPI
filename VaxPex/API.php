<?php

namespace VaxPex;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class API
{

	public static function getPlayerArena(Player $player) : Arena {
		return MinigameBase::getInstance()->arenas[$player->getWorld()->getFolderName()];
	}

	public static function getArenaData($arenaPath, $arenaName): array
	{
		$arena = new Config($arenaPath . $arenaName . ".yml", Config::YAML);
		return $arena->getAll(\false);
	}
}