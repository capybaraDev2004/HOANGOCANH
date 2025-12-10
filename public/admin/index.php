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

// Tổng số địa chỉ
$result = $db->query("SELECT COUNT(*) as total FROM addresses");
$stats['total_addresses'] = $result->fetch_assoc()['total'];

// Tổng số đánh giá
$result = $db->query("SELECT COUNT(*) as total FROM reviews");
$stats['total_reviews'] = $result->fetch_assoc()['total'];

// Tổng số slider
$result = $db->query("SELECT COUNT(*) as total FROM sliders");
$stats['total_sliders'] = $result->fetch_assoc()['total'];

// Sản phẩm đang hoạt động
$result = $db->query("SELECT COUNT(*) as total FROM products WHERE status = 'active'");
$stats['active_products'] = $result->fetch_assoc()['total'];

// Đánh giá đã duyệt
$result = $db->query("SELECT COUNT(*) as total FROM reviews WHERE status = 'approved'");
$stats['approved_reviews'] = $result->fetch_assoc()['total'];

// Đơn hàng theo trạng thái
$orderStatuses = ['PENDING', 'CONFIRMED', 'SHIPPING', 'COMPLETED', 'CANCELLED'];
$stats['orders'] = [];
foreach ($orderStatuses as $st) {
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM orders WHERE status = ?");
    $stmt->bind_param("s", $st);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stats['orders'][$st] = $res['total'] ?? 0;
}

include BASE_PATH . '/includes/admin/header.php';
?>

<style>
/* Dashboard Modern Styles */
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.stat-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(236, 72, 153, 0.1);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.stat-card:hover::before {
    transform: scaleX(1);
}

.stat-card-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    z-index: 1;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    line-height: 1.2;
}

.stat-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}

.stat-icon {
    font-size: 28px;
    color: white;
}

/* Color variants */
.stat-card.primary {
    --gradient-start: #ec4899;
    --gradient-end: #f43f5e;
}

.stat-card.success {
    --gradient-start: #10b981;
    --gradient-end: #059669;
}

.stat-card.info {
    --gradient-start: #3b82f6;
    --gradient-end: #2563eb;
}

.stat-card.warning {
    --gradient-start: #f59e0b;
    --gradient-end: #d97706;
}

.stat-card.purple {
    --gradient-start: #8b5cf6;
    --gradient-end: #7c3aed;
}

.stat-card.orange {
    --gradient-start: #f97316;
    --gradient-end: #ea580c;
}

/* Orders mini section */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
}
.order-card {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    transition: all .2s ease;
}
.order-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); }
.order-card .label { font-size: 14px; font-weight: 600; color: #475569; display: flex; align-items: center; gap: 8px; }
.order-card .value { font-size: 28px; font-weight: 800; margin-top: 8px; }
.order-pending { color: #ea580c; }
.order-confirmed { color: #16a34a; }
.order-shipping { color: #0284c7; }
.order-completed { color: #0f172a; }
.order-cancelled { color: #dc2626; }

/* Dashboard Section */
.dashboard-section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-title i {
    color: #ec4899;
    font-size: 24px;
}

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 32px;
    color: white;
    box-shadow: 0 10px 25px rgba(236, 72, 153, 0.3);
    position: relative;
    overflow: hidden;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.3;
    }
}

.welcome-content {
    position: relative;
    z-index: 1;
}

.welcome-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.welcome-subtitle {
    font-size: 16px;
    opacity: 0.95;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-stats {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .stat-card {
        padding: 20px;
    }
    
    .stat-value {
        font-size: 28px;
    }
    
    .welcome-banner {
        padding: 24px;
    }
    
    .welcome-title {
        font-size: 24px;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
.stat-card:nth-child(5) { animation-delay: 0.5s; }
.stat-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="welcome-banner">
    <div class="welcome-content">
        <h1 class="welcome-title">
            <i class="fas fa-chart-line"></i> Chào mừng đến Dashboard
        </h1>
        <p class="welcome-subtitle">Tổng quan thống kê và quản lý hệ thống</p>
    </div>
                    </div>

<div class="dashboard-section">
    <h2 class="section-title">
        <i class="fas fa-chart-bar"></i>
        <span>Thống kê tổng quan</span>
    </h2>
    
    <div class="dashboard-stats">
        <!-- Sản phẩm -->
        <div class="stat-card primary">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Tổng sản phẩm</div>
                    <h3 class="stat-value"><?php echo number_format($stats['total_products']); ?></h3>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                        <i class="fas fa-check-circle text-success"></i> <?php echo number_format($stats['active_products']); ?> đang hoạt động
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-box stat-icon"></i>
            </div>
        </div>
    </div>
    
        <!-- Danh mục -->
        <div class="stat-card success">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Tổng danh mục</div>
                    <h3 class="stat-value"><?php echo number_format($stats['total_categories']); ?></h3>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                        <i class="fas fa-layer-group"></i> Phân loại sản phẩm
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-folder-open stat-icon"></i>
                </div>
            </div>
        </div>
        
        <!-- Địa chỉ -->
        <div class="stat-card info">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Tổng địa chỉ</div>
                    <h3 class="stat-value"><?php echo number_format($stats['total_addresses']); ?></h3>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                        <i class="fas fa-map-marker-alt"></i> Địa điểm cửa hàng
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-map-marked-alt stat-icon"></i>
                </div>
            </div>
        </div>
        
        <!-- Đánh giá -->
        <div class="stat-card warning">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Tổng đánh giá</div>
                    <h3 class="stat-value"><?php echo number_format($stats['total_reviews']); ?></h3>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                        <i class="fas fa-star text-warning"></i> <?php echo number_format($stats['approved_reviews']); ?> đã duyệt
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-star-half-alt stat-icon"></i>
                </div>
            </div>
        </div>
        
        <!-- Slider -->
        <div class="stat-card purple">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Tổng slider</div>
                    <h3 class="stat-value"><?php echo number_format($stats['total_sliders']); ?></h3>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                        <i class="fas fa-images"></i> Banner quảng cáo
                    </div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-sliders-h stat-icon"></i>
                </div>
            </div>
        </div>
        
        <!-- Sản phẩm hoạt động -->
        <div class="stat-card orange">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">Sản phẩm hoạt động</div>
                    <h3 class="stat-value"><?php echo number_format($stats['active_products']); ?></h3>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
                        <i class="fas fa-check-circle text-success"></i> Đang bán
                    </div>
                    </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-check-circle stat-icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders status quick view -->
<div class="dashboard-section">
    <div class="section-title"><i class="fas fa-receipt"></i> Đơn hàng theo trạng thái</div>
    <div class="orders-grid">
        <div class="order-card">
            <div class="label"><i class="fas fa-hourglass-half text-warning"></i> Chờ xác nhận</div>
            <div class="value order-pending"><?php echo $stats['orders']['PENDING'] ?? 0; ?></div>
        </div>
        <div class="order-card">
            <div class="label"><i class="fas fa-check text-success"></i> Đã xác nhận</div>
            <div class="value order-confirmed"><?php echo $stats['orders']['CONFIRMED'] ?? 0; ?></div>
        </div>
        <div class="order-card">
            <div class="label"><i class="fas fa-truck-fast text-info"></i> Đang giao</div>
            <div class="value order-shipping"><?php echo $stats['orders']['SHIPPING'] ?? 0; ?></div>
        </div>
        <div class="order-card">
            <div class="label"><i class="fas fa-flag-checkered text-dark"></i> Hoàn thành</div>
            <div class="value order-completed"><?php echo $stats['orders']['COMPLETED'] ?? 0; ?></div>
        </div>
        <div class="order-card">
            <div class="label"><i class="fas fa-ban text-danger"></i> Đã huỷ</div>
            <div class="value order-cancelled"><?php echo $stats['orders']['CANCELLED'] ?? 0; ?></div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/includes/admin/footer.php'; ?>

