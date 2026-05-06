<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\config\Database;
use Src\Router;

// Conectar a la base de datos
Database::connect();

// Iniciar el enrutador
$router = new Router();
$router->run();