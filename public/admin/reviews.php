<?php
/**
 * Review Management Page
 */

require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/ReviewModel.php';
require_once BASE_PATH . '/app/Models/ProductModel.php';

AuthMiddleware::check();

$page_title = 'Quản lý Đánh giá';
$reviewModel = new ReviewModel();
$productModel = new ProductModel();

// Redirect POST requests to actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'delete')) {
    require BASE_PATH . '/public/admin/actions/reviews.php';
    exit;
}

// Load data for view
$filters = [
    'status' => $_GET['status'] ?? '',
    'product_id' => $_GET['product_id'] ?? '',
    'search' => $_GET['search'] ?? ''
];

$reviews = $reviewModel->getAll($filters);
$products = $productModel->getAll(['status' => 'active']);

// Load review để edit nếu có
$review = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $review = $reviewModel->getById($_GET['id']);
    if (!$review) {
        header('Location: ' . APP_URL . '/admin/reviews.php?error=' . urlencode('Không tìm thấy đánh giá'));
        exit;
    }
}

include BASE_PATH . '/includes/admin/header.php';
include BASE_PATH . '/includes/admin/views/reviews.php';
include BASE_PATH . '/includes/admin/footer.php';
?>
