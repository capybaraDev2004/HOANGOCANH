<?php
/**
 * Category Controller
 */

class CategoryController {
    private $categoryModel;
    
    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }
    
    public function index($status = null) {
        return $this->categoryModel->getAll($status);
    }
    
    public function show($id) {
        return $this->categoryModel->findById($id);
    }
    
    public function store() {
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => createSlug(trim($_POST['name'] ?? '')),
            'description' => trim($_POST['description'] ?? ''),
            'parent_id' => isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? intval($_POST['parent_id']) : null,
            'display_order' => intval($_POST['display_order'] ?? 1),
            'status' => $_POST['status'] ?? 'active',
            'image' => null
        ];
        
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập tên danh mục'];
        }
        if (empty($data['description'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập mô tả'];
        }
        // Danh mục cha không bắt buộc; nếu có thì phải trong khoảng 1..7
        if ($data['parent_id'] !== null && ($data['parent_id'] < 1 || $data['parent_id'] > 7)) {
            return ['success' => false, 'message' => 'Danh mục cha không hợp lệ (chỉ chọn ID 1-7 hoặc để trống)'];
        }
        if (empty($data['display_order']) || $data['display_order'] < 1) {
            return ['success' => false, 'message' => 'Thứ tự hiển thị phải lớn hơn 0'];
        }
        if (empty($data['status'])) {
            return ['success' => false, 'message' => 'Vui lòng chọn trạng thái'];
        }
        
        if ($this->categoryModel->create($data)) {
            return ['success' => true, 'message' => 'Thêm danh mục thành công'];
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
    
    public function update($id) {
        // Lấy category hiện tại để giữ image
        $currentCategory = $this->categoryModel->findById($id);
        
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => createSlug(trim($_POST['name'] ?? '')),
            'description' => trim($_POST['description'] ?? ''),
            'parent_id' => isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? intval($_POST['parent_id']) : null,
            'display_order' => intval($_POST['display_order'] ?? 1),
            'status' => $_POST['status'] ?? 'active',
            'image' => $currentCategory ? ($currentCategory['image'] ?? null) : null
        ];
        
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập tên danh mục'];
        }
        if (empty($data['description'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập mô tả'];
        }
        // Danh mục cha không bắt buộc; nếu có thì phải trong khoảng 1..7
        if ($data['parent_id'] !== null && ($data['parent_id'] < 1 || $data['parent_id'] > 7)) {
            return ['success' => false, 'message' => 'Danh mục cha không hợp lệ (chỉ chọn ID 1-7 hoặc để trống)'];
        }
        if (empty($data['display_order']) || $data['display_order'] < 1) {
            return ['success' => false, 'message' => 'Thứ tự hiển thị phải lớn hơn 0'];
        }
        if (empty($data['status'])) {
            return ['success' => false, 'message' => 'Vui lòng chọn trạng thái'];
        }
        
        if ($this->categoryModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Cập nhật danh mục thành công'];
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
    
    public function destroy($id) {
        if ($this->categoryModel->delete($id)) {
            return ['success' => true, 'message' => 'Xóa danh mục thành công'];
        }
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
}

