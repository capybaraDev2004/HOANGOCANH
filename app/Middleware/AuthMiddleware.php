<?php
/**
 * Authentication Middleware
 * Kiểm tra đăng nhập cho admin
 */

class AuthMiddleware {
    public static function check() {
        if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'admin') {
            header('Location: ' . APP_URL . '/admin/login.php');
            exit;
        }
        
        // Kiểm tra user còn tồn tại và active
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id, status FROM users WHERE id = ? AND role = 'admin'");
        $stmt->bind_param("i", $_SESSION['admin_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            session_destroy();
            header('Location: ' . APP_URL . '/admin/login.php');
            exit;
        }
        
        $user = $result->fetch_assoc();
        if ($user['status'] !== 'active') {
            session_destroy();
            header('Location: ' . APP_URL . '/admin/login.php?error=account_inactive');
            exit;
        }
        
        return true;
    }
    
    public static function guest() {
        if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin') {
            header('Location: ' . APP_URL . '/admin/index.php');
            exit;
        }
    }
}

