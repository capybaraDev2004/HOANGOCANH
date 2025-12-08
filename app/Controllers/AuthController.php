<?php
/**
 * Authentication Controller
 * Xử lý đăng nhập và quên mật khẩu
 */

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            if (empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin'];
            }
            
            $user = $this->userModel->findByEmail($email);
            
            if (!$user) {
                return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
            }
            
            if ($user['role'] !== 'admin') {
                return ['success' => false, 'message' => 'Bạn không có quyền truy cập'];
            }
            
            if ($user['status'] !== 'active') {
                return ['success' => false, 'message' => 'Tài khoản của bạn đã bị khóa'];
            }
            
            if (!password_verify($password, $user['password'])) {
                return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
            }
            
            // Đăng nhập thành công
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_role'] = $user['role'];
            
            $this->userModel->updateLastLogin($user['id']);
            
            if ($remember) {
                setcookie('admin_remember', $user['id'], time() + (86400 * 30), '/');
            }
            
            return ['success' => true, 'message' => 'Đăng nhập thành công'];
        }
        
        return null;
    }
    
    public function logout() {
        session_destroy();
        if (isset($_COOKIE['admin_remember'])) {
            setcookie('admin_remember', '', time() - 3600, '/');
        }
        header('Location: ' . APP_URL . '/admin/login.php');
        exit;
    }
    
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            
            if (empty($email)) {
                return ['success' => false, 'message' => 'Vui lòng nhập email'];
            }
            
            $user = $this->userModel->findByEmail($email);
            
            if (!$user || $user['role'] !== 'admin') {
                // Không tiết lộ email có tồn tại hay không
                return ['success' => true, 'message' => 'Nếu email tồn tại, chúng tôi đã gửi link reset mật khẩu'];
            }
            
            // Tạo token reset
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $this->userModel->createPasswordResetToken($email, $token, $expiresAt);
            
            // Gửi email (sẽ implement sau)
            $resetLink = APP_URL . '/admin/reset-password.php?token=' . $token;
            
            // TODO: Gửi email với link reset
            // mail($email, 'Reset mật khẩu', "Link reset: $resetLink");
            
            return ['success' => true, 'message' => 'Nếu email tồn tại, chúng tôi đã gửi link reset mật khẩu'];
        }
        
        return null;
    }
    
    public function resetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            return ['success' => false, 'message' => 'Token không hợp lệ'];
        }
        
        $reset = $this->userModel->findPasswordResetToken($token);
        
        if (!$reset) {
            return ['success' => false, 'message' => 'Token không hợp lệ hoặc đã hết hạn'];
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($password) || empty($confirmPassword)) {
                return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin'];
            }
            
            if ($password !== $confirmPassword) {
                return ['success' => false, 'message' => 'Mật khẩu xác nhận không khớp'];
            }
            
            if (strlen($password) < 6) {
                return ['success' => false, 'message' => 'Mật khẩu phải có ít nhất 6 ký tự'];
            }
            
            $this->userModel->updatePassword($reset['email'], $password);
            $this->userModel->markTokenAsUsed($token);
            
            return ['success' => true, 'message' => 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.'];
        }
        
        return ['token' => $token, 'email' => $reset['email']];
    }
}

