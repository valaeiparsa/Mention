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
        $sender = $event->getPlayer();
        $msg = $event->getMessage();
        $msg = explode(' ', strtolower($msg));
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            if ($sender->getName() !== $player->getName()) {
                if (in_array($playerName = strtolower($player->getName()), $msg)) {
                    $msg = str_replace($playerName, TF::GREEN . $player->getName() . TF::RESET, $msg);
                    $player->getLevel()->addSound(new ClickSound($player));
                    $player->sendTip(TF::BOLD . TF::GREEN . 'New mentioned message');
                }
            }
        }
        $msg = implode(' ', $msg);
        $event->setMessage($msg);
    }
}
