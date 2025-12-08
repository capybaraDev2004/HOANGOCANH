<?php
/**
 * Product Actions Handler
 */

require_once __DIR__ . '/../../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/ProductModel.php';
require_once BASE_PATH . '/app/Controllers/ProductController.php';

AuthMiddleware::check();

$productController = new ProductController();
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $result = $productController->store();
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/products.php?action=create&success=1&message=' . urlencode($result['message']));
        } else {
            header('Location: ' . APP_URL . '/admin/products.php?action=create&error=' . urlencode($result['message']));
        }
        exit;
    } elseif ($action === 'edit' && $id) {
        $result = $productController->update($id);
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/products.php?action=edit&success=1&message=' . urlencode($result['message']));
        } else {
            header('Location: ' . APP_URL . '/admin/products.php?action=edit&id=' . $id . '&error=' . urlencode($result['message']));
        }
        exit;
    }
}

if ($action === 'delete' && $id) {
    $result = $productController->destroy($id);
    
    // Kiểm tra nếu là AJAX request
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    
    if ($isAjax) {
        // Trả về JSON cho AJAX request
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    } else {
        // Redirect cho request thông thường
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/products.php?action=delete&success=1&message=' . urlencode($result['message']));
        } else {
            header('Location: ' . APP_URL . '/admin/products.php?action=delete&error=' . urlencode($result['message']));
        }
    exit;
    }
}

header('Location: ' . APP_URL . '/admin/products.php');
exit;

