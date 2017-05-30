<?php

// TESSERACT TEAM <3

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ClearCommand extends VanillaCommand {

    public function __construct($name) {
        parent::__construct(
            $name,
            "%pocketmine.command.clear.description",
            "%pocketmine.command.clear.usage"
        );
        $this->setPermission("pocketmine.command.clear");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args) {
        if (!$this->testPermission($sender)) {
            return true;
        }
        $sender->getInventory()->clearAll();
        $sender->sendMessage("The inventory of ".$sender->getDisplayName()." is clear all !");
        // Soon TranslationContainer & Message default vanilla.
        return true;
    }
}