<?php
/**
 * Product Attribute Model
 */

class ProductAttributeModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Lấy tất cả attributes của một sản phẩm
     * @param int $productId
     * @return array
     */
    public function getByProductId($productId) {
        $stmt = $this->db->prepare("SELECT * FROM product_attributes WHERE product_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $attributes = [];
        while ($row = $result->fetch_assoc()) {
            $attributes[] = $row;
        }
        return $attributes;
    }
    
    /**
     * Xóa tất cả attributes của một sản phẩm
     * @param int $productId
     * @return bool
     */
    public function deleteByProductId($productId) {
        $stmt = $this->db->prepare("DELETE FROM product_attributes WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        return $stmt->execute();
    }
    
    /**
     * Tạo attribute mới
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", 
            $data['product_id'],
            $data['attribute_name'],
            $data['attribute_value']
        );
        return $stmt->execute();
    }
    
    /**
     * Tạo nhiều attributes cùng lúc
     * @param int $productId
     * @param array $attributes Mảng các mảng ['attribute_name' => ..., 'attribute_value' => ...]
     * @return bool
     */
    public function createMultiple($productId, $attributes) {
        if (empty($attributes)) {
            return true;
        }
        
        // Xóa các attributes cũ trước
        $this->deleteByProductId($productId);
        
        // Tạo các attributes mới
        $stmt = $this->db->prepare("INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES (?, ?, ?)");
        foreach ($attributes as $attr) {
            if (!empty($attr['attribute_name']) && !empty($attr['attribute_value'])) {
                $stmt->bind_param("iss", 
                    $productId,
                    $attr['attribute_name'],
                    $attr['attribute_value']
                );
                $stmt->execute();
            }
        }
        return true;
    }
}
