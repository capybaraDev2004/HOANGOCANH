<?php
/**
 * Slider Controller
 */

require_once BASE_PATH . '/app/Helpers/ImageUploader.php';

class SliderController {
    private $sliderModel;
    
    public function __construct() {
        $this->sliderModel = new SliderModel();
    }
    
    public function index() {
        $status = $_GET['status'] ?? null;
        return $this->sliderModel->getAll($status);
    }
    
    public function show($id) {
        return $this->sliderModel->findById($id);
    }
    
    public function store() {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'link_url' => trim($_POST['link_url'] ?? ''),
            'button_text' => trim($_POST['button_text'] ?? ''),
            'display_order' => intval($_POST['display_order'] ?? 0),
            'status' => $_POST['status'] ?? 'active',
            'start_date' => $_POST['start_date'] ?: null,
            'end_date' => $_POST['end_date'] ?: null
        ];
        
        // Xử lý hình ảnh: URL hoặc file upload
        $imageUrl = trim($_POST['image_url'] ?? '');
        $imageFile = $_FILES['image_file'] ?? null;
        
        $finalImageUrl = ImageUploader::processImage($imageUrl, $imageFile, 'sliders');
        
        if (empty($data['title']) || empty($finalImageUrl)) {
            return ['success' => false, 'message' => 'Vui lòng nhập tiêu đề và chọn hình ảnh (URL hoặc file)'];
        }
        
        $data['image_url'] = $finalImageUrl;
        
        if ($this->sliderModel->create($data)) {
            return ['success' => true, 'message' => 'Thêm slider thành công'];
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
    
    public function update($id) {
        // Lấy slider hiện tại để giữ image_url nếu không có thay đổi
        $currentSlider = $this->sliderModel->findById($id);
        
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'link_url' => trim($_POST['link_url'] ?? ''),
            'button_text' => trim($_POST['button_text'] ?? ''),
            'display_order' => intval($_POST['display_order'] ?? 0),
            'status' => $_POST['status'] ?? 'active',
            'start_date' => $_POST['start_date'] ?: null,
            'end_date' => $_POST['end_date'] ?: null
        ];
        
        // Xử lý hình ảnh: URL hoặc file upload
        $imageUrl = trim($_POST['image_url'] ?? '');
        $imageFile = $_FILES['image_file'] ?? null;
        
        $finalImageUrl = ImageUploader::processImage($imageUrl, $imageFile, 'sliders');
        
        // Nếu không có hình ảnh mới, giữ hình ảnh cũ
        if (empty($finalImageUrl) && $currentSlider) {
            $finalImageUrl = $currentSlider['image_url'];
        }
        
        if (empty($data['title']) || empty($finalImageUrl)) {
            return ['success' => false, 'message' => 'Vui lòng nhập tiêu đề và chọn hình ảnh (URL hoặc file)'];
        }
        
        $data['image_url'] = $finalImageUrl;
        
        if ($this->sliderModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Cập nhật slider thành công'];
        }
        
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
    
    public function destroy($id) {
        if ($this->sliderModel->delete($id)) {
            return ['success' => true, 'message' => 'Xóa slider thành công'];
        }
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
}

