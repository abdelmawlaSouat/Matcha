<?php
namespace Matcha;

use Matcha\Core\Routeur;

require_once 'Autoloader.php';
Autoloader::register();

// ini_set(‘display_errors’, 1);
// ini_set(‘display_startup_errors’, 1);
// error_reporting(E_ALL);

$routeur = new Routeur();
$routeur->executeRequest();
