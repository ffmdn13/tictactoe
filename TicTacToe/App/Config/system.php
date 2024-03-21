<?php

namespace App\Config;

class System
{
    public function renderTile()
    {
        if (!isset($_SESSION['tile_pattern'])) {
            $_SESSION['tile_pattern'] = [
                '', '', '',
                '', '', '',
                '', '', ''
            ];
        }
        $tile_pattern = $_SESSION['tile_pattern'];
        if (!isset($_GET['msg'])) {
            foreach ($tile_pattern as $id => $tile) {
                echo "<button name='btn' value='$id'>$tile</button>";
            }
        } else {
            foreach ($tile_pattern as $id => $tile) {
                echo "<button name='btn' value='$id' disabled='disabled'>$tile</button>";
            }
        }
        return;
    }

    public function play()
    {
        if (!isset($_POST['btn'])) {
            return;
        }
        $tile_id = $_POST['btn'];
        if (!empty($_SESSION['tile_pattern'][$tile_id])) {
            return;
        }

        /*
            first player code logic,
            if first player have action true, this if statement in this code below
            will be executed.

            first player action will change to false and
            second player action will change to true
        */
        $player_list = ['player-1', 'player-2'];
        $player_first = $_SESSION['whoplayfirst'];
        $player_second = ($player_first !== $player_list[0]) ? $player_list[0] : $player_list[1];
        $player_first_action = $_SESSION['player'][$player_first]['action'];
        if ($player_first_action) {
            $usedSymbol = $_SESSION['player'][$player_first]['usedSymbol'];
            $_SESSION['tile_pattern'][$tile_id] = $usedSymbol;
            $_SESSION['player'][$player_first]['action'] = false;
            $_SESSION['player'][$player_second]['action'] = true;
            return;
        }

        /*
            second player code logic
            if first player have action false, this code will be executed,
            this code below let second player play and change
            second player action to false and first player to true
        */
        $usedSymbol = $_SESSION['player'][$player_second]['usedSymbol'];
        $_SESSION['tile_pattern'][$tile_id] = $usedSymbol;
        $_SESSION['player'][$player_second]['action'] = false;
        $_SESSION['player'][$player_first]['action'] = true;
        return;
    }

    public function checkTile()
    {
        if (!isset($_POST['btn']) || $this->countPlayersPressing() < 5) {
            return;
        }
        $pattern = $_SESSION['tile_pattern'];
        $new_pattern = [
            [$pattern[0], $pattern[1], $pattern[2]],
            [$pattern[3], $pattern[4], $pattern[5]],
            [$pattern[6], $pattern[7], $pattern[8]],
        ];
        $tile = $pattern[$_POST['btn']];
        $symbol = ['X', 'O'];
        $usedSymbol = $symbol[array_search($tile, $symbol)];
        $count = 0;

        // check horizontal line
        for ($i = 0; $i < count($new_pattern); $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($new_pattern[$i][$j] === $usedSymbol) {
                    $count++;
                }
            }
            if ($count === 3) {
                return header("location: index.php?msg=$usedSymbol win");
            }
            $count = 0;
        }

        // check vertical line
        $verline = 0;
        $nextline = 0;
        for ($i = 0; $i < count($new_pattern); $i++) {
            for ($j = 0; $j < count($new_pattern); $j++) {
                if ($new_pattern[$verline][$nextline] === $usedSymbol) {
                    $count++;
                }
                $verline++;
            }
            if ($count === 3) {
                return header("location: index.php?msg=$usedSymbol win");;
            }
            $verline = 0;
            $count = 0;
            $nextline++;
        }

        // check diagonal line left and right
        $dgnline = 0;

        // check left
        for ($i = 0; $i < count($new_pattern); $i++) {
            if ($new_pattern[$i][$dgnline] === $usedSymbol) {
                $count++;
                if ($count === 3) {
                    return header("location: index.php?msg=$usedSymbol win");
                }
            }
            $dgnline++;
        }

        // check right
        $dgnline = 2;
        $count = 0;
        for ($i = 0; $i < count($new_pattern); $i++) {
            if ($new_pattern[$i][$dgnline] === $usedSymbol) {
                $count++;
                if ($count === 3) {
                    return header("location: index.php?msg=$usedSymbol win");
                }
            }
            $dgnline--;
        }
    }

    public function restart()
    {
        if (isset($_POST['restart'])) {
            $_SESSION['tile_pattern'] = [
                '', '', '',
                '', '', '',
                '', '', ''
            ];
            unset($_SESSION['count']);
            unset($_SESSION['whoplayfirst']);
            unset($_SESSION['player']);
            header("location: index.php");
        }
        return;
    }

    public function setting()
    {
        if (isset($_POST['setting'])) {
            return header("location: setting.php");
        }
    }

    private function countPlayersPressing()
    {
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        }
        $_SESSION['count'] += 1;
        return $_SESSION['count'];
    }
}
