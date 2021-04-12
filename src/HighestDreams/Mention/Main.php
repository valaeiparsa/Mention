<?php

declare(strict_types=1);

namespace HighestDreams\Mention;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\level\sound\ClickSound;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase implements Listener {

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onMention(PlayerChatEvent $event)
    {
        $message = $event->getMessage() . " ";
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            if (preg_match($pattern = "/(@*)" . $player->getName() . "+( |-|,|\.|:|\/|\||\\|;)/i", $message))
                strtolower($player->getName()) !== strtolower($event->getPlayer()->getName()) ? $message = preg_replace($pattern, TF::GREEN . $player->getName() . " " . TF::RESET, $message) and $player->getLevel()->addSound(new ClickSound($player)) and $player->sendTip(TF::BOLD . TF::GREEN . 'New mentioned message') : NULL;
        }
        $event->setMessage($message);
    }
}
