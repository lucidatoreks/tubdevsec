<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Membutuhkan autoloader dari Composer
require_once __DIR__ . '/vendor/autoload.php';

// Membuat instance logger
$log = new Logger('app');

// Mengarahkan log ke standard output (stdout), yang akan ditangkap oleh Docker
$log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

// Mengembalikan instance logger agar bisa digunakan di file lain
return $log;

