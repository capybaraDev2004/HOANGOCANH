<?php
/**
 * Category Management Page
 */

require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/CategoryModel.php';
require_once BASE_PATH . '/app/Controllers/CategoryController.php';

AuthMiddleware::check();

$page_title = 'Quản lý Danh mục';
$categoryController = new CategoryController();

// Redirect POST requests to actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'delete')) {
    require BASE_PATH . '/public/admin/actions/categories.php';
    exit;
}

// Load data for view
$categories = $categoryController->index();

include BASE_PATH . '/includes/admin/header.php';
include BASE_PATH . '/includes/admin/views/categories.php';
include BASE_PATH . '/includes/admin/footer.php';
?>

