<?php
require_once "App/init.php";

use App\Config\System as GameSystem;
use App\Config\Player;

$player = new Player;
$player->setPlayer();
$player->setPlayFirst();

$sys = new GameSystem;
$sys->play();
$sys->checkTile();
$sys->restart();
$sys->setting();
?>

hehe

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/feather-icons"></script>
    <title>Tic Tac Toe</title>
    <style>
        * {
            --text: #494242;

            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        button {
            cursor: pointer;
        }

        h1 {
            color: var(--text);
            margin-top: 2rem;
        }

        .play-box {
            margin-top: 2rem;
            width: fit-content;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .play-box button[name='btn'] {
            width: 100px;
            height: 100px;
            margin: 5px;
            cursor: pointer;
            background-color: transparent;
            border: 1px solid var(--text);
            font-size: 2rem;
            color: var(--text);
        }

        .option {
            margin-top: 1.4rem;
            text-align: center;
        }

        .option button {
            padding: .3rem;
            width: 70px;
        }

        .option .setting {
            color: var(--text);
            vertical-align: middle;
            margin-left: .8rem;
            background-color: transparent;
            border: none;
            width: fit-content;
        }

        .win {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>


<body>

    <h1>Tic Tac Toe</h1>

    <div>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="play-box">
            <?php $sys->renderTile(); ?>
        </form>

        <?php echo (isset($_GET['msg'])) ? "<h2 class='win'>" . $_GET['msg'] . "</h2>" : ""; ?>

        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class='option'>
            <button name='restart'>Restart</button>
            <button name='setting' class='setting' title='Game settings'><i data-feather='settings'></i></button>
        </form>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>