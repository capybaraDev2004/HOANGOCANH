<?php
/**
 * Slider View
 * Hiển thị danh sách và form slider
 */
?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-<?php echo $_GET['success'] == '1' ? 'success' : 'danger'; ?> alert-dismissible fade show">
        <?php echo $_GET['success'] == '1' ? 'Thao tác thành công!' : 'Có lỗi xảy ra!'; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php echo htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Danh sách Slider</h5>
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
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sliders)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Chưa có slider nào</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sliders as $item): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td>
                                    <?php 
                                    // Đảm bảo URL hình ảnh đã được xử lý đúng (đã xử lý trong controller)
                                    $displayImageUrl = $item['image_url'];
                                    ?>
                                    <img src="<?php echo htmlspecialchars($displayImageUrl); ?>" 
                                         alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                         style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;"
                                         onerror="this.src='<?php echo IMAGES_URL; ?>/sliders/default.jpg'; this.onerror=null;">
                                </td>
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td><?php echo $item['display_order']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $item['status'] == 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo $item['status'] == 'active' ? 'Hoạt động' : 'Tắt'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($item['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="showModal('edit', <?php echo $item['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?php echo APP_URL; ?>/admin/actions/sliders.php?action=delete&id=<?php echo $item['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       data-delete
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
<div class="modal fade" id="sliderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="sliderForm" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="formId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề *</label>
                        <input type="text" name="title" class="form-control" id="formTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" id="formDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh *</label>
                        <!-- Hiển thị hình ảnh hiện tại khi edit -->
                        <div id="currentImagePreview" class="mb-3" style="display: none;">
                            <label class="form-label small text-muted">Hình ảnh hiện tại:</label>
                            <div class="border rounded p-2" style="background: #f8f9fa;">
                                <img id="currentImage" src="" alt="Current Image" style="max-width: 100%; max-height: 300px; border-radius: 5px; display: block; margin: 0 auto;">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small text-muted">Hoặc nhập URL hình ảnh:</label>
                            <input type="text" name="image_url" class="form-control" id="formImageUrl" placeholder="https://example.com/image.jpg">
                        </div>
                        <div class="text-center text-muted mb-2">HOẶC</div>
                        <div class="mb-2">
                            <label class="form-label small text-muted">Hoặc chọn file từ máy:</label>
                            <input type="file" name="image_file" class="form-control" id="formImageFile" accept="image/*">
                            <small class="form-text text-muted">Chấp nhận: JPG, PNG, GIF, WEBP (tối đa 5MB)</small>
                        </div>
                        <!-- Preview hình ảnh mới khi chọn file hoặc nhập URL -->
                        <div id="imagePreview" class="mt-2" style="display: none;">
                            <label class="form-label small text-muted">Xem trước hình ảnh mới:</label>
                            <div class="border rounded p-2" style="background: #f8f9fa;">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 5px; display: block; margin: 0 auto;">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="text" name="link_url" class="form-control" id="formLinkUrl">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Text nút</label>
                        <input type="text" name="button_text" class="form-control" id="formButtonText">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Thứ tự hiển thị</label>
                                <input type="number" name="display_order" class="form-control" id="formDisplayOrder" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-control" id="formStatus">
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Tắt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input type="datetime-local" name="start_date" class="form-control" id="formStartDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ngày kết thúc</label>
                                <input type="datetime-local" name="end_date" class="form-control" id="formEndDate">
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
const sliderData = <?php echo json_encode($sliders); ?>;
const currentSlider = <?php echo json_encode($slider); ?>;

function showModal(action, id = null) {
    const modal = new bootstrap.Modal(document.getElementById('sliderModal'));
    const form = document.getElementById('sliderForm');
    const formAction = document.getElementById('formAction');
    const formId = document.getElementById('formId');
    
    if (action === 'create') {
        document.getElementById('modalTitle').textContent = 'Thêm Slider';
        formAction.value = 'create';
        form.action = '<?php echo APP_URL; ?>/admin/actions/sliders.php?action=create';
        form.reset();
        formId.value = '';
        // Ẩn preview hình ảnh hiện tại khi tạo mới
        document.getElementById('currentImagePreview').style.display = 'none';
        document.getElementById('imagePreview').style.display = 'none';
    } else if (action === 'edit' && id) {
        document.getElementById('modalTitle').textContent = 'Sửa Slider';
        formAction.value = 'edit';
        form.action = '<?php echo APP_URL; ?>/admin/actions/sliders.php?action=edit&id=' + id;
        formId.value = id;
        
        const slider = sliderData.find(s => s.id == id);
        if (slider) {
            document.getElementById('formTitle').value = slider.title || '';
            document.getElementById('formDescription').value = slider.description || '';
            document.getElementById('formImageUrl').value = slider.image_url || '';
            document.getElementById('formLinkUrl').value = slider.link_url || '';
            document.getElementById('formButtonText').value = slider.button_text || '';
            document.getElementById('formDisplayOrder').value = slider.display_order || 0;
            document.getElementById('formStatus').value = slider.status || 'active';
            if (slider.start_date) {
                document.getElementById('formStartDate').value = slider.start_date.replace(' ', 'T').substring(0, 16);
            }
            if (slider.end_date) {
                document.getElementById('formEndDate').value = slider.end_date.replace(' ', 'T').substring(0, 16);
            }
            // Hiển thị hình ảnh hiện tại khi edit
            if (slider.image_url) {
                const currentImagePreview = document.getElementById('currentImagePreview');
                const currentImage = document.getElementById('currentImage');
                // Đảm bảo URL hình ảnh được xử lý đúng
                let imageUrl = slider.image_url;
                // Nếu là relative path và chưa có domain, thêm APP_URL
                if (imageUrl && !imageUrl.startsWith('http') && imageUrl.startsWith('/')) {
                    imageUrl = '<?php echo APP_URL; ?>' + imageUrl;
                }
                currentImage.src = imageUrl;
                currentImage.onerror = function() {
                    // Nếu lỗi, thử với URL gốc
                    this.src = slider.image_url;
                };
                currentImagePreview.style.display = 'block';
            } else {
                document.getElementById('currentImagePreview').style.display = 'none';
            }
            // Ẩn preview hình ảnh mới khi mới mở form
            document.getElementById('imagePreview').style.display = 'none';
        }
    }
    
    modal.show();
}

// Preview hình ảnh khi chọn file hoặc nhập URL
document.getElementById('formImageFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
});

document.getElementById('formImageUrl').addEventListener('input', function(e) {
    const url = e.target.value;
    if (url && (url.startsWith('http') || url.startsWith('/'))) {
        document.getElementById('previewImg').src = url;
        document.getElementById('imagePreview').style.display = 'block';
    } else {
        // Nếu xóa URL, chỉ ẩn preview mới, giữ nguyên hình ảnh hiện tại
        document.getElementById('imagePreview').style.display = 'none';
    }
});
</script>

