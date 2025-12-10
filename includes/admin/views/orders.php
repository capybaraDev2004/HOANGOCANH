<?php
$statusOptions = [
    '' => 'Tất cả trạng thái',
    'PENDING' => 'Chờ xác nhận',
    'CONFIRMED' => 'Đã xác nhận',
    'SHIPPING' => 'Đang giao',
    'COMPLETED' => 'Hoàn thành',
    'CANCELLED' => 'Đã huỷ'
];

$paymentOptions = [
    'COD' => 'COD',
    'BANKPLUS' => 'BankPlus/QR'
];
?>

<style>
.order-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 12px;
}
.order-badge.pending { background: #fff7ed; color: #ea580c; }
.order-badge.confirmed { background: #ecfdf3; color: #15803d; }
.order-badge.shipping { background: #e0f2fe; color: #0284c7; }
.order-badge.complete { background: #f0fdf4; color: #16a34a; }
.order-badge.cancelled { background: #fef2f2; color: #dc2626; }
.card-glow {
    background: #fff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
}
.table thead th {
    background: #f8fafc;
    font-weight: 700;
    color: #0f172a;
}
.pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f1f5f9;
    padding: 6px 10px;
    border-radius: 999px;
    font-weight: 600;
    color: #0f172a;
    font-size: 12px;
}
.action-btn {
    border: 1px solid #e2e8f0;
    padding: 6px 10px;
    border-radius: 10px;
    background: #fff;
    color: #0f172a;
    font-weight: 600;
    transition: all .2s ease;
}
.action-btn:hover { box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08); transform: translateY(-1px); }
</style>

<div class="container-fluid">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success rounded-3 shadow-sm d-flex align-items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <div><?php echo htmlspecialchars($_GET['message'] ?? 'Thao tác thành công'); ?></div>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger rounded-3 shadow-sm d-flex align-items-center gap-2">
            <i class="fas fa-triangle-exclamation"></i>
            <div><?php echo htmlspecialchars($_GET['message'] ?? 'Có lỗi xảy ra'); ?></div>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <p class="text-uppercase text-muted fw-bold mb-1" style="letter-spacing: .1rem;">Quản lý</p>
            <h2 class="fw-bold mb-0">Đơn hàng</h2>
        </div>
    </div>

    <div class="card-glow p-4 mb-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tìm kiếm</label>
                <input type="text" name="search" value="<?php echo htmlspecialchars($filters['search']); ?>" class="form-control" placeholder="Mã đơn / tên / số điện thoại">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Trạng thái</label>
                <select name="status" class="form-select">
                    <?php foreach ($statusOptions as $key => $label): ?>
                        <option value="<?php echo $key; ?>" <?php echo $filters['status'] === $key ? 'selected' : ''; ?>>
                            <?php echo $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search me-2"></i>Lọc</button>
                <a href="<?php echo APP_URL; ?>/admin/orders.php" class="btn btn-outline-secondary"><i class="fas fa-rotate-left"></i></a>
            </div>
        </form>
    </div>

    <div class="card-glow p-4 mb-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th style="width: 150px;">Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">Chưa có đơn hàng</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $o): 
                            $statusClass = strtolower($o['status'] ?? 'pending');
                            ?>
                            <tr>
                                <td class="fw-bold text-primary"><?php echo htmlspecialchars($o['order_code'] ?? ''); ?></td>
                                <td>
                                    <div class="fw-semibold"><?php echo htmlspecialchars($o['customer_name']); ?></div>
                                    <div class="text-muted small"><?php echo htmlspecialchars($o['shipping_address']); ?></div>
                                </td>
                                <td>
                                    <div class="pill"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($o['customer_phone']); ?></div><br>
                                    <div class="pill"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($o['customer_email']); ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($o['payment_method']); ?></span>
                                </td>
                                <td>
                                    <span class="order-badge <?php echo $statusClass; ?>">
                                        <?php echo $statusOptions[$o['status']] ?? $o['status']; ?>
                                    </span>
                                </td>
                                <td class="fw-bold text-danger text-nowrap"><?php echo number_format($o['total'], 0, ',', '.'); ?> ₫</td>
                                <td class="text-muted small"><?php echo htmlspecialchars($o['created_at']); ?></td>
                                <td class="text-end">
                                    <?php
                                        $encoded = htmlspecialchars(json_encode($o), ENT_QUOTES, 'UTF-8');
                                    ?>
                                    <button type="button" class="action-btn btn btn-sm" onclick="openOrderModal('<?php echo $encoded; ?>')"><i class="fas fa-pen"></i> Sửa</button>
                                    <a href="<?php echo APP_URL; ?>/admin/orders.php?action=delete&id=<?php echo $o['id']; ?>" class="action-btn btn btn-sm text-danger" onclick="return confirm('Xoá đơn hàng này?');"><i class="fas fa-trash"></i> Xoá</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal chỉnh sửa -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="orderForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh sửa đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Mã đơn hàng</label>
                                <input type="text" id="order_code" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Trạng thái</label>
                                <select name="status" id="order_status" class="form-select">
                                    <?php foreach ($statusOptions as $key => $label): if ($key === '') continue; ?>
                                        <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Phương thức thanh toán</label>
                                <select name="payment_method" id="order_payment" class="form-select">
                                    <?php foreach ($paymentOptions as $key => $label): ?>
                                        <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Họ tên</label>
                                <input type="text" name="customer_name" id="order_name" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="customer_phone" id="order_phone" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="customer_email" id="order_email" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
                                <input type="text" name="shipping_address" id="order_address" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Ghi chú</label>
                                <textarea name="note" id="order_note" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openOrderModal(dataStr) {
    try {
        const data = JSON.parse(dataStr);
        document.getElementById('order_code').value = data.order_code || '';
        document.getElementById('order_status').value = data.status || 'PENDING';
        document.getElementById('order_payment').value = data.payment_method || 'COD';
        document.getElementById('order_name').value = data.customer_name || '';
        document.getElementById('order_phone').value = data.customer_phone || '';
        document.getElementById('order_email').value = data.customer_email || '';
        document.getElementById('order_address').value = data.shipping_address || '';
        document.getElementById('order_note').value = data.note || '';

        const form = document.getElementById('orderForm');
        form.action = "<?php echo APP_URL; ?>/admin/orders.php?action=edit&id=" + data.id;

        const modal = new bootstrap.Modal(document.getElementById('orderModal'));
        modal.show();
    } catch (e) {
        console.error('Cannot parse order data', e);
    }
}
</script>

