<?php
/**
 * Address Actions Handler
 */

require_once __DIR__ . '/../../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/AddressModel.php';
require_once BASE_PATH . '/app/Controllers/AddressController.php';

AuthMiddleware::check();

$addressController = new AddressController();
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $result = $addressController->store();
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/addresses.php?action=create&success=1&message=' . urlencode($result['message']));
        } else {
            header('Location: ' . APP_URL . '/admin/addresses.php?action=create&error=' . urlencode($result['message']));
        }
        exit;
    } elseif ($action === 'edit' && $id) {
        $result = $addressController->update($id);
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/addresses.php?action=edit&success=1&message=' . urlencode($result['message']));
        } else {
            header('Location: ' . APP_URL . '/admin/addresses.php?action=edit&id=' . $id . '&error=' . urlencode($result['message']));
        }
        exit;
    }
}

if ($action === 'delete' && $id) {
    $result = $addressController->destroy($id);
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
    
    header('Location: ' . APP_URL . '/admin/addresses.php?action=delete&' . ($result['success'] ? 'success=1&message=' : 'error=') . urlencode($result['message']));
    exit;
}

header('Location: ' . APP_URL . '/admin/addresses.php');
exit;

