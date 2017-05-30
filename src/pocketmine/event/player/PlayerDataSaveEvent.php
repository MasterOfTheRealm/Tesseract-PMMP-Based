<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link   http://www.pocketmine.net/
 *
 *
 */

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\IPlayer;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Server;

class PlayerDataSaveEvent extends Event implements Cancellable{
    public static $handlerList = null;

    protected $data;
    protected $playerName;

    public function __construct(CompoundTag $nbt, string $playerName) {
        $this->data = $nbt;
        $this->playerName = $playerName;
    }

    public function getSaveData() : CompoundTag{
        return $this->data;
    }

    public function setSaveData(CompoundTag $data){
        $this->data = $data;
    }

    public function getPlayerName() : string{
        return $this->playerName;
    }

    public function getPlayer() : IPlayer{
        return Server::getInstance()->getOfflinePlayer($this->playerName);
    }
}