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
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\item\enchantment;

use pocketmine\item\ChainBoots;
use pocketmine\item\ChainChestplate;
use pocketmine\item\ChainHelmet;
use pocketmine\item\ChainLeggings;
use pocketmine\item\DiamondAxe;
use pocketmine\item\DiamondBoots;
use pocketmine\item\DiamondChestplate;
use pocketmine\item\DiamondHelmet;
use pocketmine\item\DiamondHoe;
use pocketmine\item\DiamondLeggings;
use pocketmine\item\DiamondPickaxe;
use pocketmine\item\DiamondShovel;
use pocketmine\item\DiamondSword;
use pocketmine\item\GoldAxe;
use pocketmine\item\GoldBoots;
use pocketmine\item\GoldChestplate;
use pocketmine\item\GoldHelmet;
use pocketmine\item\GoldHoe;
use pocketmine\item\GoldLeggings;
use pocketmine\item\GoldPickaxe;
use pocketmine\item\GoldShovel;
use pocketmine\item\GoldSword;
use pocketmine\item\IronAxe;
use pocketmine\item\IronBoots;
use pocketmine\item\IronChestplate;
use pocketmine\item\IronHelmet;
use pocketmine\item\IronHoe;
use pocketmine\item\IronLeggings;
use pocketmine\item\IronPickaxe;
use pocketmine\item\IronShovel;
use pocketmine\item\IronSword;
use pocketmine\item\Item;
use pocketmine\item\LeatherBoots;
use pocketmine\item\LeatherCap;
use pocketmine\item\LeatherPants;
use pocketmine\item\LeatherTunic;
use pocketmine\item\StoneAxe;
use pocketmine\item\StoneHoe;
use pocketmine\item\StonePickaxe;
use pocketmine\item\StoneShovel;
use pocketmine\item\StoneSword;
use pocketmine\item\WoodenAxe;
use pocketmine\item\WoodenHoe;
use pocketmine\item\WoodenPickaxe;
use pocketmine\item\WoodenShovel;
use pocketmine\item\WoodenSword;

use pocketmine\Server;

class Enchantment {

    const TYPE_INVALID = -1;

    const PROTECTION = 0;
    const FIRE_PROTECTION = 1;
    const FEATHER_FALLING = 2;
    const BLAST_PROTECTION = 3;
    const PROJECTILE_PROTECTION = 4;
    const THORNS = 5;
    const RESPIRATION = 6;
    const DEPTH_STRIDER = 7;
    const AQUA_AFFINITY = 8;
    const SHARPNESS = 9;
    const SMITE = 10;
    const BANE_OF_ARTHROPODS = 11;
    const KNOCKBACK = 12;
    const FIRE_ASPECT = 13;
    const LOOTING = 14;
    const EFFICIENCY = 15;
    const SILK_TOUCH = 16;
    const UNBREAKING = 17;
    const FORTUNE = 18;
    const POWER = 19;
    const PUNCH = 20;
    const FLAME = 21;
    const INFINITY = 22;
    const LUCK_OF_THE_SEA = 23;
    const LURE = 24;
    //1.1 const FROST_WALKER = 25;
    //1.1 const MENDING = 26;

    const WEIGHT_COMMON = 10;
    const WEIGHT_UNCOMMON = 5;
    const WEIGHT_RARE = 2;
    const RARITY_MYTHIC = 1;

    const SLOT_NONE = 0;
    const SLOT_ALL = 0b11111111111111;
    const SLOT_ARMOR = 0b1111;
    const SLOT_HEAD = 0b1;
    const SLOT_TORSO = 0b10;
    const SLOT_LEGS = 0b100;
    const SLOT_FEET = 0b1000;
    const SLOT_SWORD = 0b10000;
    const SLOT_BOW = 0b100000;
    const SLOT_TOOL = 0b111000000;
    const SLOT_HOE = 0b1000000;
    const SLOT_SHEARS = 0b10000000;
    const SLOT_FLINT_AND_STEEL = 0b10000000;
    const SLOT_DIG = 0b111000000000;
    const SLOT_AXE = 0b1000000000;
    const SLOT_PICKAXE = 0b10000000000;
    const SLOT_SHOVEL = 0b10000000000;
    const SLOT_FISHING_ROD = 0b100000000000;
    const SLOT_CARROT_STICK = 0b1000000000000;

    /** @var Enchantment[] */
    public static $enchantments;

    public static function init() {
        self::$enchantments = new \SplFixedArray(256);

        $data = json_decode(file_get_contents(\pocketmine\PATH . "src/pocketmine/resources/enchantments.json"), true);
        if(!is_array($data)){
            throw new \RuntimeException("Enchantments data could not be read");
        }

        foreach($data as $enchantName => $enchantData){
            //TODO: add item type flags
            self::registerEnchantment(new Enchantment($enchantData["id"], $enchantData["translation"], $enchantData["weight"], -1, $enchantData["max_level"]));
        }
    }

    public static function registerEnchantment(Enchantment $enchantment){
        self::$enchantments[$enchantment->getId()] = $enchantment;
    }

    /**
     * @param int $id
     * @return $this
     */
    public static function getEnchantment(int $id) {
        if (isset(self::$enchantments[$id])) {
            return clone self::$enchantments[$id];
        }
        return null;
    }

    public static function getEnchantmentByName($name) {
        if(defined(Enchantment::class . "::" . strtoupper($name))){
            return self::getEnchantment(constant(Enchantment::class . "::" . strtoupper($name)));
        }
        return null;
    }

    private $id;
    private $level = 1;
    private $name;
    private $rarity;
    private $slot;
    private $maxLevel;

    public function __construct(int $id, string $name, int $rarity, int $slot, int $maxLevel) {
        $this->id = $id;
        $this->name = $name;
        $this->rarity = $rarity;
        $this->slot = $slot;
        $this->maxLevel = $maxLevel;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getName(): string {
        return "%enchantment." . $this->name;
    }

    public function getRarity(): int{
        return $this->rarity;
    }

    public function getSlot(): int {
        return $this->slot;
    }

    public function hasSlot(int $slot): bool {
        return ($this->slot & $slot) > 0;
    }

    public function getMaxLevel(){
        return $this->maxLevel;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function setLevel(int $level) {
        $this->level = $level;

        return $this;
    }

    public static function getEnchantAbility(Item $item) {
        switch ($item->getId()) {
            case Item::BOOK:
            case Item::BOW:
            case Item::FISHING_ROD:
                return 4;
        }

        if ($item->isArmor()) {
            if ($item instanceof ChainBoots or $item instanceof ChainChestplate or $item instanceof ChainHelmet or $item instanceof ChainLeggings) return 12;
            if ($item instanceof IronBoots or $item instanceof IronChestplate or $item instanceof IronHelmet or $item instanceof IronLeggings) return 9;
            if ($item instanceof DiamondBoots or $item instanceof DiamondChestplate or $item instanceof DiamondHelmet or $item instanceof DiamondLeggings) return 10;
            if ($item instanceof LeatherBoots or $item instanceof LeatherTunic or $item instanceof LeatherCap or $item instanceof LeatherPants) return 15;
            if ($item instanceof GoldBoots or $item instanceof GoldChestplate or $item instanceof GoldHelmet or $item instanceof GoldLeggings) return 25;
        }

        if ($item->isTool()) {
            if ($item instanceof WoodenAxe or $item instanceof WoodenHoe or $item instanceof WoodenPickaxe or $item instanceof WoodenShovel or $item instanceof WoodenSword) return 15;
            if ($item instanceof StoneAxe or $item instanceof StoneHoe or $item instanceof StonePickaxe or $item instanceof StoneShovel or $item instanceof StoneSword) return 5;
            if ($item instanceof DiamondAxe or $item instanceof DiamondHoe or $item instanceof DiamondPickaxe or $item instanceof DiamondShovel or $item instanceof DiamondSword) return 10;
            if ($item instanceof IronAxe or $item instanceof IronHoe or $item instanceof IronPickaxe or $item instanceof IronShovel or $item instanceof IronSword) return 14;
            if ($item instanceof GoldAxe or $item instanceof GoldHoe or $item instanceof GoldPickaxe or $item instanceof GoldShovel or $item instanceof GoldSword) return 22;
        }

        return 0;
    }

    public static function rarityFromString(string $name) : int{
        switch($name){
            case "common":
                return Enchantment::WEIGHT_COMMON;
            case "uncommon":
                return Enchantment::WEIGHT_UNCOMMON;
            case "rare":
                return Enchantment::WEIGHT_RARE;
            case "mythic":
                return Enchantment::RARITY_MYTHIC;
            default:
                throw new \InvalidArgumentException("Unknown enchantment rarity \"$name\"");
        }
    }

    public static function rarityToString(int $rarity) : string{
        switch($rarity){
            case Enchantment::WEIGHT_COMMON:
                return "common";
            case Enchantment::WEIGHT_UNCOMMON:
                return "uncommon";
            case Enchantment::WEIGHT_RARE:
                return "rare";
            case Enchantment::RARITY_MYTHIC:
                return "mythic";
            default:
                throw new \InvalidArgumentException("Unknown rarity type $rarity");
        }
    }
}
