<?php
/**
 * Product Management Page
 */

require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/CategoryModel.php';
require_once BASE_PATH . '/app/Models/ProductModel.php';
require_once BASE_PATH . '/app/Models/ProductImageModel.php';
require_once BASE_PATH . '/app/Models/ProductAttributeModel.php';
require_once BASE_PATH . '/app/Controllers/ProductController.php';

AuthMiddleware::check();

$page_title = 'Quản lý Sản phẩm';
$productController = new ProductController();
$categoryModel = new CategoryModel();

// Redirect POST requests to actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'delete')) {
    require BASE_PATH . '/public/admin/actions/products.php';
    exit;
}

// Load data for view
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

$filters = [
    'category_id' => $_GET['category_id'] ?? '',
    'status' => $_GET['status'] ?? '',
    'search' => $_GET['search'] ?? ''
];

$products = $productController->index($filters);
$categories = $categoryModel->getAll('active');
$product = null;
$productImages = [];

// Đếm tổng số sản phẩm (không có filter)
$productModel = new ProductModel();
$totalProducts = $productModel->count([]);

// Đếm số sản phẩm sau khi lọc
$filteredCount = $productModel->count($filters);

// Load ảnh cho tất cả sản phẩm để hiển thị khi edit
$productImageModel = new ProductImageModel();
$allProductImages = [];
$productAttributeModel = new ProductAttributeModel();
$allProductAttributes = [];

foreach ($products as $prod) {
    $images = $productImageModel->getByProductId($prod['id']);
    // Xử lý URL ảnh để đảm bảo là absolute URL
    foreach ($images as &$img) {
        $imageUrl = $img['image_url'];
        // Nếu là relative path (bắt đầu bằng /) thì thêm APP_URL
        if (strpos($imageUrl, 'http') !== 0 && strpos($imageUrl, '/') === 0) {
            $imageUrl = APP_URL . $imageUrl;
        } elseif (strpos($imageUrl, 'http') !== 0) {
            // Nếu là relative path không có / đầu thì thêm IMAGES_URL
            $imageUrl = IMAGES_URL . '/products/' . $imageUrl;
        }
        $img['image_url'] = $imageUrl;
    }
    unset($img); // Unset reference
    $allProductImages[$prod['id']] = $images;
    
    // Load attributes cho mỗi sản phẩm
    $attributes = $productAttributeModel->getByProductId($prod['id']);
    $allProductAttributes[$prod['id']] = $attributes;
}

if ($action === 'edit' && $id) {
    $product = $productController->show($id);
    if (!$product) {
        header('Location: ' . APP_URL . '/admin/products.php');
        exit;
    }
    $productImages = $productImageModel->getByProductId($id);
    // Load attributes của sản phẩm đang edit
    $productAttributes = $productAttributeModel->getByProductId($id);
} else {
    $productAttributes = [];
}

include BASE_PATH . '/includes/admin/header.php';
include BASE_PATH . '/includes/admin/views/products.php';
include BASE_PATH . '/includes/admin/footer.php';
?>


