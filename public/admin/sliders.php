<?php
/**
 * Slider Management Page
 * Chỉ chứa logic routing và load view
 */

require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';
require_once BASE_PATH . '/app/Models/SliderModel.php';
require_once BASE_PATH . '/app/Controllers/SliderController.php';

AuthMiddleware::check();

$page_title = 'Quản lý Slider';
$sliderController = new SliderController();

// Redirect POST requests to actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'delete')) {
    require BASE_PATH . '/public/admin/actions/sliders.php';
    exit;
}

// Load data for view
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

$sliders = $sliderController->index();
$slider = null;
if ($action === 'edit' && $id) {
    $slider = $sliderController->show($id);
    if (!$slider) {
        header('Location: ' . APP_URL . '/admin/sliders.php');
        exit;
    }
}

// Xử lý URL hình ảnh cho tất cả sliders trong danh sách
foreach ($sliders as &$item) {
    $imageUrl = trim($item['image_url']);
    if (empty($imageUrl)) {
        $item['image_url'] = IMAGES_URL . '/sliders/default.jpg';
    } elseif (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0) {
        // URL external - giữ nguyên
        $item['image_url'] = $imageUrl;
    } elseif (strpos($imageUrl, '/assets/images/') === 0) {
        // Relative path từ root - thêm APP_URL
        $item['image_url'] = APP_URL . $imageUrl;
    } elseif (strpos($imageUrl, '/') === 0) {
        // Relative path khác từ root - thêm APP_URL
        $item['image_url'] = APP_URL . $imageUrl;
    } else {
        // Path tương đối - thêm IMAGES_URL
        $item['image_url'] = IMAGES_URL . '/sliders/' . $imageUrl;
    }
}
unset($item); // Unset reference

// Xử lý URL hình ảnh cho slider đang edit
if ($slider) {
    $imageUrl = trim($slider['image_url']);
    if (empty($imageUrl)) {
        $slider['image_url'] = IMAGES_URL . '/sliders/default.jpg';
    } elseif (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0) {
        $slider['image_url'] = $imageUrl;
    } elseif (strpos($imageUrl, '/assets/images/') === 0) {
        $slider['image_url'] = APP_URL . $imageUrl;
    } elseif (strpos($imageUrl, '/') === 0) {
        $slider['image_url'] = APP_URL . $imageUrl;
    } else {
        $slider['image_url'] = IMAGES_URL . '/sliders/' . $imageUrl;
    }
}

include BASE_PATH . '/includes/admin/header.php';
include BASE_PATH . '/includes/admin/views/sliders.php';
include BASE_PATH . '/includes/admin/footer.php';
?>

