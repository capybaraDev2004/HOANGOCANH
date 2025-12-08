<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/app/Controllers/AuthController.php';

$authController = new AuthController();
$authController->logout();

