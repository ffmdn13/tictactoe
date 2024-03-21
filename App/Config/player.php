<?php

namespace App\Config;

class Player
{
    public function setPlayer()
    {
        if (!isset($_SESSION['player'])) {
            $_SESSION['player'] = [
                'player-1' => [
                    "action" => false,
                    "usedSymbol" => "X"
                ],
                'player-2' => [
                    "action" => false,
                    "usedSymbol" => "O"
                ]
            ];
        }
        return;
    }

    public function setPlayFirst()
    {
        if (!isset($_SESSION['whoplayfirst'])) {
            $playername = ['player-1', 'player-2'];
            $result = $playername[rand(0, 1)];
            $_SESSION['whoplayfirst'] = $result;
            $_SESSION['player'][$result]['action'] = true;
        }
        return;
    }
}
