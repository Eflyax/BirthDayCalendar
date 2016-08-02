<?php

namespace FrontModule\Components;

use Entity\Game;
use Nette\Application\UI\Control;

class GameView extends Control
{

    public function render(Game $game)
    {
        $this->template->game = $game;

        $this->template->setFile(__DIR__ . '/gameView.latte');

        $this->template->render();
    }
}