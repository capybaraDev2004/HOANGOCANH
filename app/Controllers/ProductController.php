<?php
/**
 * Product Controller
 */

require_once BASE_PATH . '/app/Helpers/ImageUploader.php';
require_once BASE_PATH . '/app/Models/ProductImageModel.php';
require_once BASE_PATH . '/app/Models/ProductAttributeModel.php';

class ProductController {
    private $productModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
    }
    
    public function index($filters = []) {
        return $this->productModel->getAll($filters);
    }
    
    public function show($id) {
        return $this->productModel->findById($id);
    }
    
    public function store() {
        $name = trim($_POST['name'] ?? '');
        
        $data = [
            'category_id' => intval($_POST['category_id'] ?? 0),
            'name' => $name,
            'slug' => '', // Sẽ được tạo sau
            'description' => trim($_POST['description'] ?? ''),
            'price' => floatval($_POST['price'] ?? 0),
            'sale_price' => !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : null,
            'stock_quantity' => intval($_POST['stock_quantity'] ?? 0),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'status' => $_POST['status'] ?? 'active',
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? '')
        ];
        
        // Validation các trường bắt buộc
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập tên sản phẩm'];
        }
        if (empty($data['category_id']) || $data['category_id'] <= 0) {
            return ['success' => false, 'message' => 'Vui lòng chọn danh mục'];
        }
        if (empty($data['description'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập mô tả sản phẩm'];
        }
        if (empty($data['price']) || $data['price'] <= 0) {
            return ['success' => false, 'message' => 'Vui lòng nhập giá gốc hợp lệ'];
        }
        if (!isset($data['stock_quantity']) || $data['stock_quantity'] <= 0) {
            return ['success' => false, 'message' => 'Vui lòng nhập số lượng tồn kho lớn hơn 0'];
        }
        if (empty($data['status'])) {
            return ['success' => false, 'message' => 'Vui lòng chọn trạng thái'];
        }
        if (empty($data['meta_title'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập tiêu đề SEO'];
        }
        if (empty($data['meta_description'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập mô tả SEO'];
        }
        
        // Kiểm tra ảnh chính
        $primaryImageUrl = trim($_POST['primary_image_url'] ?? '');
        $primaryImageFile = $_FILES['primary_image_file'] ?? null;
        $finalPrimaryImageUrl = ImageUploader::processImage($primaryImageUrl, $primaryImageFile, 'products');
        
        if (empty($finalPrimaryImageUrl)) {
            return ['success' => false, 'message' => 'Vui lòng chọn ảnh chính cho sản phẩm'];
        }
        
        // Tạo slug unique trước khi insert
        $data['slug'] = createUniqueSlug($name, $this->productModel);
        
        // Tạo sản phẩm (SKU sẽ tự động được tạo)
        try {
            $productId = $this->productModel->create($data);
            
            // create() trả về ID nếu thành công, false nếu thất bại
            if (!$productId || $productId <= 0) {
                return ['success' => false, 'message' => 'Không thể tạo sản phẩm. Vui lòng kiểm tra lại thông tin.'];
            }
            
            $imageModel = new ProductImageModel();
            
            // Lưu ảnh chính
            $imageResult = $imageModel->create([
                'product_id' => $productId,
                'image_url' => $finalPrimaryImageUrl,
                'is_primary' => 1,
                'display_order' => 0
            ]);
            
            // Kiểm tra lỗi khi thêm ảnh
            if (!$imageResult) {
                // Xóa sản phẩm vừa tạo nếu không thêm được ảnh
                $this->productModel->delete($productId);
                return ['success' => false, 'message' => 'Lỗi khi thêm ảnh sản phẩm. Vui lòng thử lại.'];
            }
            
            // Xử lý ảnh bổ sung
            if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
                $additionalFiles = $_FILES['additional_images'];
                $fileCount = count($additionalFiles['name']);
                
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($additionalFiles['error'][$i] === UPLOAD_ERR_OK) {
                        $file = [
                            'name' => $additionalFiles['name'][$i],
                            'type' => $additionalFiles['type'][$i],
                            'tmp_name' => $additionalFiles['tmp_name'][$i],
                            'error' => $additionalFiles['error'][$i],
                            'size' => $additionalFiles['size'][$i]
                        ];
                        
                        $uploadResult = ImageUploader::upload($file, 'products');
                        if ($uploadResult['success']) {
                            $imageModel->create([
                                'product_id' => $productId,
                                'image_url' => $uploadResult['url'],
                                'is_primary' => 0,
                                'display_order' => $i + 1
                            ]);
                        }
                    }
                }
            }
            
            // Xử lý lưu attributes
            if (isset($_POST['attributes']) && is_array($_POST['attributes'])) {
                $attributeModel = new ProductAttributeModel();
                $attributes = [];
                foreach ($_POST['attributes'] as $attr) {
                    $attrName = trim($attr['attribute_name'] ?? '');
                    $attrValue = trim($attr['attribute_value'] ?? '');
                    if (!empty($attrName) && !empty($attrValue)) {
                        $attributes[] = [
                            'attribute_name' => $attrName,
                            'attribute_value' => $attrValue
                        ];
                    }
                }
                if (!empty($attributes)) {
                    $attributeModel->createMultiple($productId, $attributes);
                }
            }
            
            return ['success' => true, 'message' => 'Thêm sản phẩm thành công'];
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi duplicate slug
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'slug') !== false) {
                // Thử tạo slug unique lại và insert lại
                $data['slug'] = createUniqueSlug($name, $this->productModel);
                try {
                    $productId = $this->productModel->create($data);
                    
                    if (!$productId || $productId <= 0) {
                        return ['success' => false, 'message' => 'Lỗi khi tạo sản phẩm. Vui lòng thử lại.'];
                    }
                    
                    $imageModel = new ProductImageModel();
                    $imageResult = $imageModel->create([
                        'product_id' => $productId,
                        'image_url' => $finalPrimaryImageUrl,
                        'is_primary' => 1,
                        'display_order' => 0
                    ]);
                    
                    if (!$imageResult) {
                        $this->productModel->delete($productId);
                        return ['success' => false, 'message' => 'Lỗi khi thêm ảnh sản phẩm. Vui lòng thử lại.'];
                    }
                    
                    // Xử lý ảnh bổ sung
                    if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
                        $additionalFiles = $_FILES['additional_images'];
                        $fileCount = count($additionalFiles['name']);
                        
                        for ($i = 0; $i < $fileCount; $i++) {
                            if ($additionalFiles['error'][$i] === UPLOAD_ERR_OK) {
                                $file = [
                                    'name' => $additionalFiles['name'][$i],
                                    'type' => $additionalFiles['type'][$i],
                                    'tmp_name' => $additionalFiles['tmp_name'][$i],
                                    'error' => $additionalFiles['error'][$i],
                                    'size' => $additionalFiles['size'][$i]
                                ];
                                
                                $uploadResult = ImageUploader::upload($file, 'products');
                                if ($uploadResult['success']) {
                                    $imageModel->create([
                                        'product_id' => $productId,
                                        'image_url' => $uploadResult['url'],
                                        'is_primary' => 0,
                                        'display_order' => $i + 1
                                    ]);
                        }
                    }
                }
            }
            
            // Xử lý lưu attributes
            if (isset($_POST['attributes']) && is_array($_POST['attributes'])) {
                $attributeModel = new ProductAttributeModel();
                $attributes = [];
                foreach ($_POST['attributes'] as $attr) {
                    $attrName = trim($attr['attribute_name'] ?? '');
                    $attrValue = trim($attr['attribute_value'] ?? '');
                    if (!empty($attrName) && !empty($attrValue)) {
                        $attributes[] = [
                            'attribute_name' => $attrName,
                            'attribute_value' => $attrValue
                        ];
                    }
                }
                if (!empty($attributes)) {
                    $attributeModel->createMultiple($productId, $attributes);
                }
            }
                    
                    return ['success' => true, 'message' => 'Thêm sản phẩm thành công'];
                } catch (Exception $e2) {
                    return ['success' => false, 'message' => 'Lỗi khi tạo sản phẩm: ' . $e2->getMessage()];
                }
            }
            return ['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }
    
    public function update($id) {
        $name = trim($_POST['name'] ?? '');
        
        $data = [
            'category_id' => intval($_POST['category_id'] ?? 0),
            'name' => $name,
            'slug' => createSlug($name),
            'description' => trim($_POST['description'] ?? ''),
            'price' => floatval($_POST['price'] ?? 0),
            'sale_price' => !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : null,
            'stock_quantity' => intval($_POST['stock_quantity'] ?? 0),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'status' => $_POST['status'] ?? 'active',
            'meta_title' => trim($_POST['meta_title'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? '')
        ];
        
        // Validation các trường bắt buộc
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập tên sản phẩm'];
        }
        if (empty($data['category_id']) || $data['category_id'] <= 0) {
            return ['success' => false, 'message' => 'Vui lòng chọn danh mục'];
        }
        if (empty($data['description'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập mô tả sản phẩm'];
        }
        if (empty($data['price']) || $data['price'] <= 0) {
            return ['success' => false, 'message' => 'Vui lòng nhập giá gốc hợp lệ'];
        }
        if (!isset($data['stock_quantity']) || $data['stock_quantity'] <= 0) {
            return ['success' => false, 'message' => 'Vui lòng nhập số lượng tồn kho lớn hơn 0'];
        }
        if (empty($data['status'])) {
            return ['success' => false, 'message' => 'Vui lòng chọn trạng thái'];
        }
        if (empty($data['meta_title'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập tiêu đề SEO'];
        }
        if (empty($data['meta_description'])) {
            return ['success' => false, 'message' => 'Vui lòng nhập mô tả SEO'];
        }
        
        try {
        if ($this->productModel->update($id, $data)) {
            $imageModel = new ProductImageModel();
                
                // Xử lý xóa ảnh hiện có (nếu có)
                if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
                    foreach ($_POST['delete_images'] as $imageId) {
                        $imageId = intval($imageId);
                        if ($imageId > 0) {
                            // Lấy thông tin ảnh trước khi xóa
                            $oldImages = $imageModel->getByProductId($id);
                            foreach ($oldImages as $img) {
                                if ($img['id'] == $imageId) {
                                    // Xóa file ảnh trên server
                                    ImageUploader::delete($img['image_url']);
                                    // Xóa record trong database
                                    $imageModel->delete($imageId);
                                    break;
                                }
                            }
                        }
                    }
                }
            
            // Xử lý ảnh chính mới (nếu có)
            $primaryImageUrl = trim($_POST['primary_image_url'] ?? '');
            $primaryImageFile = $_FILES['primary_image_file'] ?? null;
            
            $finalPrimaryImageUrl = ImageUploader::processImage($primaryImageUrl, $primaryImageFile, 'products');
            
            if ($finalPrimaryImageUrl) {
                // Xóa ảnh chính cũ
                $oldImages = $imageModel->getByProductId($id);
                foreach ($oldImages as $img) {
                    if ($img['is_primary'] == 1) {
                        ImageUploader::delete($img['image_url']);
                        $imageModel->delete($img['id']);
                    }
                }
                
                // Thêm ảnh chính mới
                $imageModel->create([
                    'product_id' => $id,
                    'image_url' => $finalPrimaryImageUrl,
                    'is_primary' => 1,
                    'display_order' => 0
                ]);
            }
            
            // Xử lý ảnh bổ sung mới (nếu có)
            if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
                $additionalFiles = $_FILES['additional_images'];
                $fileCount = count($additionalFiles['name']);
                
                // Lấy số thứ tự hiện tại
                $existingImages = $imageModel->getByProductId($id);
                $currentOrder = count($existingImages);
                
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($additionalFiles['error'][$i] === UPLOAD_ERR_OK) {
                        $file = [
                            'name' => $additionalFiles['name'][$i],
                            'type' => $additionalFiles['type'][$i],
                            'tmp_name' => $additionalFiles['tmp_name'][$i],
                            'error' => $additionalFiles['error'][$i],
                            'size' => $additionalFiles['size'][$i]
                        ];
                        
                        $uploadResult = ImageUploader::upload($file, 'products');
                        if ($uploadResult['success']) {
                            $imageModel->create([
                                'product_id' => $id,
                                'image_url' => $uploadResult['url'],
                                'is_primary' => 0,
                                'display_order' => $currentOrder + $i + 1
                            ]);
                        }
                    }
                }
            }
            
            // Xử lý lưu attributes
            if (isset($_POST['attributes']) && is_array($_POST['attributes'])) {
                $attributeModel = new ProductAttributeModel();
                $attributes = [];
                foreach ($_POST['attributes'] as $attr) {
                    $attrName = trim($attr['attribute_name'] ?? '');
                    $attrValue = trim($attr['attribute_value'] ?? '');
                    if (!empty($attrName) && !empty($attrValue)) {
                        $attributes[] = [
                            'attribute_name' => $attrName,
                            'attribute_value' => $attrValue
                        ];
                    }
                }
                // Luôn cập nhật attributes (có thể là mảng rỗng để xóa hết)
                $attributeModel->createMultiple($id, $attributes);
            }
            
                return ['success' => true, 'message' => 'Sửa sản phẩm thành công'];
            }
            
            return ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật sản phẩm'];
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi duplicate slug
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'slug') !== false) {
                // Thử tạo slug unique lại và update lại
                $data['slug'] = createUniqueSlug($name, $this->productModel, $id);
                try {
                    if ($this->productModel->update($id, $data)) {
                        $imageModel = new ProductImageModel();
                        
                        // Xử lý xóa ảnh hiện có (nếu có)
                        if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
                            foreach ($_POST['delete_images'] as $imageId) {
                                $imageId = intval($imageId);
                                if ($imageId > 0) {
                                    $oldImages = $imageModel->getByProductId($id);
                                    foreach ($oldImages as $img) {
                                        if ($img['id'] == $imageId) {
                                            ImageUploader::delete($img['image_url']);
                                            $imageModel->delete($imageId);
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        
                        // Xử lý ảnh chính mới (nếu có)
                        $primaryImageUrl = trim($_POST['primary_image_url'] ?? '');
                        $primaryImageFile = $_FILES['primary_image_file'] ?? null;
                        $finalPrimaryImageUrl = ImageUploader::processImage($primaryImageUrl, $primaryImageFile, 'products');
                        
                        if ($finalPrimaryImageUrl) {
                            $oldImages = $imageModel->getByProductId($id);
                            foreach ($oldImages as $img) {
                                if ($img['is_primary'] == 1) {
                                    ImageUploader::delete($img['image_url']);
                                    $imageModel->delete($img['id']);
                                }
                            }
                            
                            $imageModel->create([
                                'product_id' => $id,
                                'image_url' => $finalPrimaryImageUrl,
                                'is_primary' => 1,
                                'display_order' => 0
                            ]);
                        }
                        
                        // Xử lý ảnh bổ sung mới (nếu có)
                        if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
                            $additionalFiles = $_FILES['additional_images'];
                            $fileCount = count($additionalFiles['name']);
                            $existingImages = $imageModel->getByProductId($id);
                            $currentOrder = count($existingImages);
                            
                            for ($i = 0; $i < $fileCount; $i++) {
                                if ($additionalFiles['error'][$i] === UPLOAD_ERR_OK) {
                                    $file = [
                                        'name' => $additionalFiles['name'][$i],
                                        'type' => $additionalFiles['type'][$i],
                                        'tmp_name' => $additionalFiles['tmp_name'][$i],
                                        'error' => $additionalFiles['error'][$i],
                                        'size' => $additionalFiles['size'][$i]
                                    ];
                                    
                                    $uploadResult = ImageUploader::upload($file, 'products');
                                    if ($uploadResult['success']) {
                                        $imageModel->create([
                                            'product_id' => $id,
                                            'image_url' => $uploadResult['url'],
                                            'is_primary' => 0,
                                            'display_order' => $currentOrder + $i + 1
                                        ]);
                        }
                    }
                }
            }
            
            // Xử lý lưu attributes
            if (isset($_POST['attributes']) && is_array($_POST['attributes'])) {
                $attributeModel = new ProductAttributeModel();
                $attributes = [];
                foreach ($_POST['attributes'] as $attr) {
                    $attrName = trim($attr['attribute_name'] ?? '');
                    $attrValue = trim($attr['attribute_value'] ?? '');
                    if (!empty($attrName) && !empty($attrValue)) {
                        $attributes[] = [
                            'attribute_name' => $attrName,
                            'attribute_value' => $attrValue
                        ];
                    }
                }
                // Luôn cập nhật attributes (có thể là mảng rỗng để xóa hết)
                $attributeModel->createMultiple($id, $attributes);
            }
                        
                        return ['success' => true, 'message' => 'Sửa sản phẩm thành công'];
        }
                } catch (Exception $e2) {
                    return ['success' => false, 'message' => 'Lỗi khi cập nhật sản phẩm: ' . $e2->getMessage()];
                }
            }
            return ['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }
    
    public function destroy($id) {
        try {
        if ($this->productModel->delete($id)) {
            return ['success' => true, 'message' => 'Xóa sản phẩm thành công'];
        }
            return ['success' => false, 'message' => 'Không thể xóa sản phẩm. Vui lòng thử lại.'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi khi xóa sản phẩm: ' . $e->getMessage()];
        }
    }
}

