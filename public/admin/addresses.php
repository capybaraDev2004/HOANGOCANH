<?php
/**
 * Address Management Page
 */

require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/AddressModel.php';
require_once BASE_PATH . '/app/Controllers/AddressController.php';

AuthMiddleware::check();

$page_title = 'Quản lý Địa chỉ';
$addressController = new AddressController();

// Redirect POST requests to actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'delete')) {
    require BASE_PATH . '/public/admin/actions/addresses.php';
    exit;
}

// Load data for view
$type = $_GET['type'] ?? '';
$addresses = $addressController->index($type ?: null);

include BASE_PATH . '/includes/admin/header.php';
include BASE_PATH . '/includes/admin/views/addresses.php';
include BASE_PATH . '/includes/admin/footer.php';
?>

