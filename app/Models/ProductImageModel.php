<?php
/**
 * Product Image Model
 */

class ProductImageModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getByProductId($productId) {
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY is_primary DESC, display_order ASC, id ASC");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        return $images;
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii",
            $data['product_id'],
            $data['image_url'],
            $data['is_primary'],
            $data['display_order']
        );
        return $stmt->execute();
    }
    
    public function deleteByProductId($productId) {
        $stmt = $this->db->prepare("DELETE FROM product_images WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM product_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function setPrimary($productId, $imageId) {
        // Bỏ primary của tất cả ảnh
        $stmt = $this->db->prepare("UPDATE product_images SET is_primary = 0 WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        // Set primary cho ảnh được chọn
        $stmt = $this->db->prepare("UPDATE product_images SET is_primary = 1 WHERE id = ? AND product_id = ?");
        $stmt->bind_param("ii", $imageId, $productId);
        return $stmt->execute();
    }
}

