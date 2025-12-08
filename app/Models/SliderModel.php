<?php
/**
 * Slider Model
 */

class SliderModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($status = null) {
        $sql = "SELECT * FROM sliders";
        if ($status) {
            $sql .= " WHERE status = ?";
        }
        $sql .= " ORDER BY display_order ASC, id DESC";
        
        $stmt = $this->db->prepare($sql);
        if ($status) {
            $stmt->bind_param("s", $status);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $sliders = [];
        while ($row = $result->fetch_assoc()) {
            $sliders[] = $row;
        }
        return $sliders;
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sliders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO sliders (title, description, image_url, link_url, button_text, display_order, status, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisss", 
            $data['title'],
            $data['description'],
            $data['image_url'],
            $data['link_url'],
            $data['button_text'],
            $data['display_order'],
            $data['status'],
            $data['start_date'],
            $data['end_date']
        );
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE sliders SET title = ?, description = ?, image_url = ?, link_url = ?, button_text = ?, display_order = ?, status = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->bind_param("sssssisssi",
            $data['title'],
            $data['description'],
            $data['image_url'],
            $data['link_url'],
            $data['button_text'],
            $data['display_order'],
            $data['status'],
            $data['start_date'],
            $data['end_date'],
            $id
        );
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM sliders WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

