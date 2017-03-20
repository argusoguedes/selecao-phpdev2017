<?php
require 'vendor/autoload.php';

require 'config.php';


$settings['displayErrorDetails'] = true;
$settings['determineRouteBeforeAppMiddleware'] = true;
$settings['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $settings]);

require '_genesis/genesis.php';
require 'endpoints/usuarios.php';
require 'endpoints/proprietarios.php';
require 'endpoints/animais.php';

$app->run();
?>