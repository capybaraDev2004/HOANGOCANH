<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';

AuthMiddleware::check();

$page_title = 'Dashboard';

$db = Database::getInstance();

// Thống kê
$stats = [];

// Tổng số sản phẩm
$result = $db->query("SELECT COUNT(*) as total FROM products");
$stats['total_products'] = $result->fetch_assoc()['total'];

// Tổng số danh mục
$result = $db->query("SELECT COUNT(*) as total FROM categories");
$stats['total_categories'] = $result->fetch_assoc()['total'];

include BASE_PATH . '/includes/admin/header.php';
?>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Tổng sản phẩm</h6>
                        <h3 class="mb-0"><?php echo number_format($stats['total_products']); ?></h3>
                    </div>
                    <div class="text-success" style="font-size: 40px;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Tổng danh mục</h6>
                        <h3 class="mb-0"><?php echo number_format($stats['total_categories']); ?></h3>
                    </div>
                    <div class="text-info" style="font-size: 40px;">
                        <i class="fas fa-folder"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/includes/admin/footer.php'; ?>

