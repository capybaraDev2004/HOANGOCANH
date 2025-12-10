<?php
/**
 * Order Actions Handler
 */

require_once __DIR__ . '/../../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/OrderModel.php';
require_once BASE_PATH . '/app/Controllers/OrderController.php';

AuthMiddleware::check();

$orderController = new OrderController();
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit' && $id) {
    $data = [
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'customer_phone' => trim($_POST['customer_phone'] ?? ''),
        'customer_email' => trim($_POST['customer_email'] ?? ''),
        'shipping_address' => trim($_POST['shipping_address'] ?? ''),
        'note' => trim($_POST['note'] ?? ''),
        'payment_method' => strtoupper(trim($_POST['payment_method'] ?? 'COD')),
        'status' => strtoupper(trim($_POST['status'] ?? 'PENDING')),
    ];

    if (!$data['customer_name'] || !$data['customer_phone'] || !$data['customer_email'] || !$data['shipping_address']) {
        header('Location: ' . APP_URL . "/admin/orders.php?action=edit&id={$id}&error=" . urlencode('Vui lòng nhập đủ thông tin'));
        exit;
    }

    $result = $orderController->update($id, $data);
    $redirect = APP_URL . "/admin/orders.php?action=edit&id={$id}&" . ($result['success'] ? 'success=1&' : 'error=1&') . 'message=' . urlencode($result['message']);
    header("Location: {$redirect}");
    exit;
}

if ($action === 'delete' && $id) {
    $result = $orderController->destroy($id);
    $redirect = APP_URL . "/admin/orders.php?" . ($result['success'] ? 'success=1&' : 'error=1&') . 'message=' . urlencode($result['message']);
    header("Location: {$redirect}");
    exit;
}

header('Location: ' . APP_URL . '/admin/orders.php');
exit;

