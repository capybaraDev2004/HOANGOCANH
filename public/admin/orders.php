<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/OrderModel.php';
require_once BASE_PATH . '/app/Controllers/OrderController.php';

AuthMiddleware::check();

$page_title = 'Quản lý Đơn hàng';
$orderController = new OrderController();

// Redirect action handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'delete')) {
    require BASE_PATH . '/public/admin/actions/orders.php';
    exit;
}

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$filters = [
    'status' => $_GET['status'] ?? '',
    'search' => $_GET['search'] ?? ''
];

$orders = $orderController->index($filters);
$order = null;
$items = [];

if ($action === 'edit' && $id) {
    $order = $orderController->show($id);
    if (!$order) {
        header('Location: ' . APP_URL . '/admin/orders.php');
        exit;
    }
    $items = $order['items'] ?? [];
}

include BASE_PATH . '/includes/admin/header.php';
include BASE_PATH . '/includes/admin/views/orders.php';
include BASE_PATH . '/includes/admin/footer.php';

