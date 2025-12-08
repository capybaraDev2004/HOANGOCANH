<?php
/**
 * Slider Actions Handler
 * Xử lý các POST requests cho slider
 */

require_once '../../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/SliderModel.php';
require_once BASE_PATH . '/app/Controllers/SliderController.php';

AuthMiddleware::check();

$sliderController = new SliderController();
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $result = $sliderController->store();
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/sliders.php?success=1');
        } else {
            header('Location: ' . APP_URL . '/admin/sliders.php?error=' . urlencode($result['message']));
        }
        exit;
    } elseif ($action === 'edit' && $id) {
        $result = $sliderController->update($id);
        if ($result['success']) {
            header('Location: ' . APP_URL . '/admin/sliders.php?success=1');
        } else {
            header('Location: ' . APP_URL . '/admin/sliders.php?action=edit&id=' . $id . '&error=' . urlencode($result['message']));
        }
        exit;
    }
}

if ($action === 'delete' && $id) {
    $result = $sliderController->destroy($id);
    header('Location: ' . APP_URL . '/admin/sliders.php?success=' . ($result['success'] ? '1' : '0'));
    exit;
}

header('Location: ' . APP_URL . '/admin/sliders.php');
exit;

