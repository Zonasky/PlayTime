<?php

namespace Zonasky\PlayTime;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use Zonasky\PlayTime\command\PlayTimeCommand;

class PlayTime extends PluginBase {

	private static $instance;

	public function onEnable(): void {
		self::$instance = $this;
        $this->getServer()->getCommandMap()->register("playtime", new PlayTimeCommand());
	}

	public static function getInstance(): PlayTime {
		return self::$instance;
	}

	public function getPlayTime(Player $player){
	  $time = time() - intval($player->getFirstPlayed() / 1000);
        $seconds = $time % 60;
        $minutes = null;
        $hours = null;
        $days = null;
        if ($time >= 60) {
            $minutes = floor(($time % 3600) / 60);
            if ($time >= 3600) {
                $hours = floor(($time % (3600 * 24)) / 3600);
                if ($time >= 3600 * 24) {
                    $days = floor($time / (3600 * 24));
                }
            }
        }
        $uptime = ($days !== null ? "$days days " : "") . ($hours !== null ? "$hours hours " : "") . ($minutes !== null ? "$minutes minutes " : "") . "$seconds seconds";
		return $uptime;
	}
}