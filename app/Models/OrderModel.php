<?php
/**
 * Order Model
 */

class OrderModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($filters = []) {
        $sql = "SELECT * FROM orders WHERE 1=1";
        $params = [];
        $types = "";
        
        if (!empty($filters['status'])) {
            $sql .= " AND order_status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (order_code LIKE ? OR customer_name LIKE ? OR customer_phone LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $types .= "sss";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if (!empty($params)) {
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query($sql);
        }
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $allowedStatus = ['PENDING','CONFIRMED','SHIPPING','COMPLETED','CANCELLED'];
        $allowedPayment = ['COD','BANKPLUS'];

        $status = in_array($data['status'], $allowedStatus) ? $data['status'] : 'PENDING';
        $payment = in_array($data['payment_method'], $allowedPayment) ? $data['payment_method'] : 'COD';

        $stmt = $this->db->prepare("
            UPDATE orders
            SET customer_name = ?, customer_phone = ?, customer_email = ?, shipping_address = ?, note = ?, payment_method = ?, status = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            "sssssssi",
            $data['customer_name'],
            $data['customer_phone'],
            $data['customer_email'],
            $data['shipping_address'],
            $data['note'],
            $payment,
            $status,
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

