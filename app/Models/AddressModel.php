<?php
/**
 * Address Model
 */

class AddressModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($type = null) {
        $sql = "SELECT * FROM addresses";
        if ($type) {
            $sql .= " WHERE type = ?";
        }
        $sql .= " ORDER BY display_order ASC, id DESC";
        
        $stmt = $this->db->prepare($sql);
        if ($type) {
            $stmt->bind_param("s", $type);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $addresses = [];
        while ($row = $result->fetch_assoc()) {
            $addresses[] = $row;
        }
        return $addresses;
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM addresses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO addresses (name, address, ward, district, city, phone, email, map_url, latitude, longitude, type, display_order, status, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, NULL, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssis",
            $data['name'],
            $data['address'],
            $data['ward'],
            $data['district'],
            $data['city'],
            $data['phone'],
            $data['email'],
            $data['map_url'],
            $data['type'],
            $data['display_order'],
            $data['status'],
            $data['note']
        );
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE addresses SET name = ?, address = ?, ward = ?, district = ?, city = ?, phone = ?, email = ?, map_url = ?, latitude = NULL, longitude = NULL, type = ?, display_order = ?, status = ?, note = ? WHERE id = ?");
        $stmt->bind_param("ssssssssissisi",
            $data['name'],
            $data['address'],
            $data['ward'],
            $data['district'],
            $data['city'],
            $data['phone'],
            $data['email'],
            $data['map_url'],
            $data['type'],
            $data['display_order'],
            $data['status'],
            $data['note'],
            $id
        );
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM addresses WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    /**
     * Lấy địa chỉ chính (main = 1)
     */
    public function getMain() {
        $stmt = $this->db->prepare("SELECT * FROM addresses WHERE main = 1 AND status = 'active' LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

