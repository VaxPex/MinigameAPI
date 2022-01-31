<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\player\Player;

class ArenaListener implements Listener
{

	private Arena $plugin;

	/**
	 * @param Arena $plugin
	 */
	public function __construct(Arena $plugin)
	{
		$this->plugin = $plugin;
	}

	public function getArena() : Arena{
		return $this->plugin;
	}

	public function onPlace(BlockPlaceEvent $event){
		$player = $event->getPlayer();
		if($this->getArena()->inGame($player) && $player->getWorld()->getFolderName() === $this->getArena()->getWorld()->getFolderName() && $this->getArena()->getSettings()->noBuild){
			$event->cancel();
		}
	}

	public function onBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		if($this->getArena()->inGame($player) && $player->getWorld()->getFolderName() === $this->getArena()->getWorld()->getFolderName() && $this->getArena()->getSettings()->noBreak){
			$event->cancel();
		}
	}

	public function onExplosion(ExplosionPrimeEvent $event){
		$player = $event->getEntity();
		if($this->getArena()->inGame($player) && $player->getWorld()->getFolderName() === $this->getArena()->getWorld()->getFolderName() && $this->getArena()->getSettings()->noExplosion){
			$event->cancel();
		}
	}

	public function onExplode(EntityExplodeEvent $event){
		$player = $event->getEntity();
		if($this->getArena()->inGame($player) && $player->getWorld()->getFolderName() === $this->getArena()->getWorld()->getFolderName() && $this->getArena()->getSettings()->noExplode){
			$event->cancel();
		}
	}

	public function onExhaust(PlayerExhaustEvent $event){
		$player = $event->getPlayer();
		if($player instanceof Player){
			if($this->getArena()->inGame($player) && $player->getWorld()->getFolderName() === $this->getArena()->getWorld()->getFolderName() && $this->getArena()->getSettings()->noHunger){
				if($player->getHungerManager()->getFood() !== 20.0){
					$player->getHungerManager()->setFood(20.0);
				}
				$event->cancel();
			}
		}
	}
}