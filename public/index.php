<?php

session_start();

/**
 * Cek autoload composer
 */
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
  throw new Exception('Pleace run "composer install"', 1);
}

/**
 * Autoload composer
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Start app
 */
$app = new Src\Core\Application();
$app->routing();
