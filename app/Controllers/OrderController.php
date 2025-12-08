<?php
/**
 * Order Controller
 */

class OrderController {
    private $orderModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
    }
    
    public function index($filters = []) {
        return $this->orderModel->getAll($filters);
    }
    
    public function show($id) {
        $order = $this->orderModel->findById($id);
        if ($order) {
            $order['items'] = $this->orderModel->getOrderItems($id);
        }
        return $order;
    }
    
    public function updateStatus($id, $status) {
        if ($this->orderModel->updateStatus($id, $status)) {
            return ['success' => true, 'message' => 'Cập nhật trạng thái thành công'];
        }
        return ['success' => false, 'message' => 'Có lỗi xảy ra'];
    }
}

