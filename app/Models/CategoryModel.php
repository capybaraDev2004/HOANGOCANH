<?php
/**
 * Category Model
 */

class CategoryModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($status = null) {
        $sql = "SELECT c.*, p.name as parent_name FROM categories c LEFT JOIN categories p ON c.parent_id = p.id";
        if ($status) {
            $sql .= " WHERE c.status = ?";
        }
        $sql .= " ORDER BY c.display_order ASC, c.id DESC";
        
        $stmt = $this->db->prepare($sql);
        if ($status) {
            $stmt->bind_param("s", $status);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    }
    
    public function findBySlug($slug, $status = null) {
        $sql = "SELECT * FROM categories WHERE slug = ?";
        if ($status) {
            $sql .= " AND status = ?";
        }
        $sql .= " LIMIT 1";
        $stmt = $this->db->prepare($sql);
        if ($status) {
            $stmt->bind_param("ss", $slug, $status);
        } else {
            $stmt->bind_param("s", $slug);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getByParentId($parentId, $status = null) {
        $sql = "SELECT * FROM categories WHERE parent_id = ?";
        if ($status) {
            $sql .= " AND status = ?";
        }
        $sql .= " ORDER BY display_order ASC, id DESC";
        $stmt = $this->db->prepare($sql);
        if ($status) {
            $stmt->bind_param("is", $parentId, $status);
        } else {
            $stmt->bind_param("i", $parentId);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, slug, description, image, parent_id, display_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $parentId = !empty($data['parent_id']) ? $data['parent_id'] : null;
        $stmt->bind_param("ssssiis",
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['image'],
            $parentId,
            $data['display_order'],
            $data['status']
        );
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, image = ?, parent_id = ?, display_order = ?, status = ? WHERE id = ?");
        $parentId = !empty($data['parent_id']) ? $data['parent_id'] : null;
        $stmt->bind_param("ssssiisi",
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['image'],
            $parentId,
            $data['display_order'],
            $data['status'],
            $id
        );
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

