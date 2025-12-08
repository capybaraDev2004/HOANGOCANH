<?php
/**
 * Category View
 */
?>

<!-- Toast Notification Container -->
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<?php
// Xác định loại thông báo dựa trên action
$actionType = $_GET['action'] ?? '';
$successMessage = '';
$errorMessage = '';

if (isset($_GET['success']) && $_GET['success'] == '1') {
    $message = $_GET['message'] ?? '';
    switch ($actionType) {
        case 'create':
            $successMessage = !empty($message) ? $message : 'Thêm danh mục thành công!';
            break;
        case 'edit':
            $successMessage = !empty($message) ? $message : 'Sửa danh mục thành công!';
            break;
        case 'delete':
            $successMessage = !empty($message) ? $message : 'Xóa danh mục thành công!';
            break;
        default:
            $successMessage = !empty($message) ? $message : 'Thao tác thành công!';
    }
}

if (isset($_GET['error'])) {
    $errorMessage = htmlspecialchars($_GET['error']);
}
?>

<script>
// Hiển thị toast notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toastId = 'toast-' + Date.now();
    
    const icon = type === 'success' 
        ? '<i class="fas fa-check-circle"></i>' 
        : '<i class="fas fa-exclamation-circle"></i>';
    
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    const borderColor = type === 'success' ? '#059669' : '#dc2626';
    
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast-notification';
    toast.style.cssText = `
        background: white;
        border-left: 4px solid ${borderColor};
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        padding: 16px 20px;
        margin-bottom: 12px;
        min-width: 300px;
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideInRight 0.3s ease-out;
        position: relative;
    `;
    
    toast.innerHTML = `
        <div style="font-size: 24px; color: ${bgColor}; flex-shrink: 0;">
            ${icon}
        </div>
        <div style="flex: 1;">
            <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">
                ${type === 'success' ? 'Thành công' : 'Lỗi'}
            </div>
            <div style="font-size: 14px; color: #6b7280;">
                ${message}
            </div>
    </div>
        <button onclick="closeToast('${toastId}')" style="background: none; border: none; font-size: 18px; color: #9ca3af; cursor: pointer; padding: 0; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(toast);
    
    // Tự động đóng sau 5 giây
    setTimeout(() => {
        closeToast(toastId);
    }, 5000);
}

function closeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
}

// CSS Animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Hiển thị thông báo khi trang load
<?php if (!empty($successMessage)): ?>
showToast('<?php echo addslashes($successMessage); ?>', 'success');
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
showToast('<?php echo addslashes($errorMessage); ?>', 'error');
<?php endif; ?>
</script>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Danh sách Danh mục</h5>
        <button class="btn btn-primary btn-sm" onclick="showModal('create')">
            <i class="fas fa-plus"></i> Thêm mới
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Danh mục cha</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Chưa có danh mục nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $item): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['slug']); ?></td>
                                <td><?php echo htmlspecialchars($item['parent_name'] ?? '-'); ?></td>
                                <td><?php echo $item['display_order']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $item['status'] == 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo $item['status'] == 'active' ? 'Hoạt động' : 'Tắt'; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="showModal('edit', <?php echo $item['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory(<?php echo $item['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm Danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="categoryForm">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="formId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục <span style="color:#dc3545;">*</span></label>
                        <input type="text" name="name" class="form-control" id="formName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả <span style="color:#dc3545;">*</span></label>
                        <textarea name="description" class="form-control" id="formDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Danh mục cha</label>
                        <select name="parent_id" class="form-control" id="formParentId">
                            <option value="">Không có (danh mục gốc)</option>
                            <?php foreach ($categories as $cat): ?>
                                <?php if ($cat['id'] >= 1 && $cat['id'] <= 7): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Thứ tự hiển thị <span style="color:#dc3545;">*</span></label>
                                <input type="number" name="display_order" class="form-control" id="formDisplayOrder" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Trạng thái <span style="color:#dc3545;">*</span></label>
                                <select name="status" class="form-control" id="formStatus" required>
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Tắt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const categoryData = <?php echo json_encode($categories); ?>;

function showModal(action, id = null) {
    const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    const form = document.getElementById('categoryForm');
    const formAction = document.getElementById('formAction');
    const formId = document.getElementById('formId');
    
    if (action === 'create') {
        document.getElementById('modalTitle').textContent = 'Thêm Danh mục';
        formAction.value = 'create';
        form.action = '<?php echo APP_URL; ?>/admin/actions/categories.php?action=create';
        form.reset();
        formId.value = '';
        document.getElementById('formParentId').value = '';
        document.getElementById('formStatus').value = 'active';
        document.getElementById('formDisplayOrder').value = 1;
    } else if (action === 'edit' && id) {
        document.getElementById('modalTitle').textContent = 'Sửa Danh mục';
        formAction.value = 'edit';
        form.action = '<?php echo APP_URL; ?>/admin/actions/categories.php?action=edit&id=' + id;
        formId.value = id;
        
        const category = categoryData.find(c => c.id == id);
        if (category) {
            document.getElementById('formName').value = category.name || '';
            document.getElementById('formDescription').value = category.description || '';
            const parentId = category.parent_id;
            // Nếu có danh mục cha và trong khoảng 1..7 thì set, ngược lại để trống (danh mục gốc)
            document.getElementById('formParentId').value = (parentId >= 1 && parentId <= 7) ? parentId : '';
            document.getElementById('formDisplayOrder').value = category.display_order || 1;
            document.getElementById('formStatus').value = category.status || 'active';
        }
    }
    
    modal.show();
}

// Xóa danh mục bằng AJAX để hiện toast trước khi reload
function deleteCategory(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) return;
    fetch('<?php echo APP_URL; ?>/admin/actions/categories.php?action=delete&id=' + id, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Xóa danh mục thành công!', 'success');
            setTimeout(() => { window.location.href = '<?php echo APP_URL; ?>/admin/categories.php'; }, 2500);
    } else {
            showToast(data.message || 'Có lỗi xảy ra khi xóa danh mục!', 'error');
        }
    })
    .catch(() => {
        showToast('Có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại.', 'error');
    });
}
</script>

