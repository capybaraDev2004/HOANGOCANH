<?php
require_once '../../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Models/UserModel.php';
require_once BASE_PATH . '/app/Controllers/AuthController.php';
require_once BASE_PATH . '/app/Middleware/AuthMiddleware.php';

AuthMiddleware::guest();

$authController = new AuthController();
$data = $authController->resetPassword();

if (is_array($data) && isset($data['success']) && !$data['success'] && !isset($data['token'])) {
    $error = $data['message'];
    $token = '';
} else {
    $token = $data['token'] ?? $_GET['token'] ?? '';
    $error = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = $authController->resetPassword();
        if ($result && $result['success']) {
            header('Location: ' . APP_URL . '/admin/login.php?success=reset_success');
            exit;
        } else {
            $error = $result['message'] ?? 'Có lỗi xảy ra';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        .reset-header {
            background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .reset-body {
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <div class="reset-header">
            <i class="fas fa-lock fa-3x mb-3"></i>
            <h3 class="mb-0">Đặt lại mật khẩu</h3>
        </div>
        <div class="reset-body">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($token) || (is_array($data) && isset($data['success']) && !$data['success'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Link reset không hợp lệ hoặc đã hết hạn.
                </div>
                <div class="text-center">
                    <a href="<?php echo APP_URL; ?>/admin/login.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>Quay lại đăng nhập
                    </a>
                </div>
            <?php else: ?>
                <form method="POST" action="">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Mật khẩu mới
                        </label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                        <small class="form-text text-muted">Tối thiểu 6 ký tự</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu
                        </label>
                        <input type="password" name="confirm_password" class="form-control" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-check me-2"></i>Đặt lại mật khẩu
                    </button>
                    
                    <div class="text-center">
                        <a href="<?php echo APP_URL; ?>/admin/login.php" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại đăng nhập
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

