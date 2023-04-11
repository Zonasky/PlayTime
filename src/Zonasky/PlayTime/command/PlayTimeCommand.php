<?php

namespace Zonasky\PlayTime\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;
use Zonasky\PlayTime\PlayTime;

class PlayTimeCommand extends Command implements PluginOwned {

	private PlayTime $plugin;
    
    public function __construct() {
        parent::__construct("playtime", "View your playtime");
		$this->setAliases(["pt"]);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "You must use this command in-game!");
            return true;
        }
        if (count($args) === 0) {
            $playtime = PlayTime::getInstance()->getPlayTime($sender);
            $sender->sendMessage(TextFormat::GREEN . "Your Playtime: " . TextFormat::RED . $playtime);
            return true;
        }
        $player = $sender->getServer()->getPlayerExact($args[0]);
        if (!$player instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Could not find player " . $args[0]);
            return true;
        }
        $playtime = PlayTime::getInstance()->getPlayTime($player);
        $sender->sendMessage(TextFormat::GREEN . $player->getName() . "'s Playtime: " . TextFormat::RED . $playtime);
        return true;
    }

	public function getOwningPlugin() : PlayTime {
		return $this->plugin;
	}
}
