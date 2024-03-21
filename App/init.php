<?php
if (session_status() === 1) {
    session_start();
}

spl_autoload_register(function ($class) {
    $class = explode("\\", $class);
    $filename = end($class) . ".php";
    $path = "App/Config/" . $filename;


    if (file_exists($path)) {
        require_once $path;
    }
});
