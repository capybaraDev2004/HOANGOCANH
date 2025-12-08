<?php
require_once '../config/config.php';

$page_title = 'Đăng ký - ' . APP_NAME;
$page_description = 'Tạo tài khoản mới';

include '../includes/header.php';
?>

<!-- Register Section -->
<section class="py-12 min-h-screen flex items-center bg-gradient-to-br from-rose-50 to-pink-50">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-rose-500 to-pink-500 text-white p-8 text-center">
                    <i class="fas fa-user-plus text-6xl mb-3"></i>
                    <h1 class="text-2xl font-bold">Đăng ký tài khoản</h1>
                    <p class="text-sm opacity-90 mt-2">Tạo tài khoản để trải nghiệm dịch vụ tốt nhất!</p>
                </div>

                <!-- Register Form -->
                <div class="p-8">
                    <form id="register-form" onsubmit="handleRegister(event)">
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user text-rose-500 mr-2"></i>
                                Họ và tên
                            </label>
                            <input type="text" 
                                   name="fullname"
                                   required
                                   placeholder="Nguyễn Văn A"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 transition">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-envelope text-rose-500 mr-2"></i>
                                Email
                            </label>
                            <input type="email" 
                                   name="email"
                                   required
                                   placeholder="example@email.com"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 transition">
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-phone text-rose-500 mr-2"></i>
                                Số điện thoại
                            </label>
                            <input type="tel" 
                                   name="phone"
                                   required
                                   placeholder="0123456789"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 transition">
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock text-rose-500 mr-2"></i>
                                Mật khẩu
                            </label>
                            <input type="password" 
                                   name="password"
                                   required
                                   placeholder="••••••••"
                                   minlength="6"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 transition">
                            <p class="text-xs text-gray-500 mt-1">Tối thiểu 6 ký tự</p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-lock text-rose-500 mr-2"></i>
                                Xác nhận mật khẩu
                            </label>
                            <input type="password" 
                                   name="confirm_password"
                                   required
                                   placeholder="••••••••"
                                   minlength="6"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 transition">
                        </div>

                        <!-- Terms -->
                        <div class="mb-6">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" required class="w-4 h-4 text-rose-500 rounded mt-1">
                                <span class="ml-2 text-sm text-gray-700">
                                    Tôi đồng ý với 
                                    <a href="#" class="text-rose-500 hover:text-rose-600 font-medium">Điều khoản dịch vụ</a> 
                                    và 
                                    <a href="#" class="text-rose-500 hover:text-rose-600 font-medium">Chính sách bảo mật</a>
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-rose-500 to-pink-500 text-white py-3 rounded-lg font-bold text-lg hover:shadow-lg transition-all hover:-translate-y-1">
                            <i class="fas fa-user-plus mr-2"></i>
                            Đăng ký
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-4 my-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="text-gray-500 text-sm">HOẶC</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Social Register -->
                    <div class="space-y-3">
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f mr-2"></i>
                            Đăng ký với Facebook
                        </button>
                        <button class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                            <i class="fab fa-google mr-2"></i>
                            Đăng ký với Google
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center mt-6 pt-6 border-t">
                        <p class="text-gray-600">
                            Đã có tài khoản? 
                            <a href="<?php echo APP_URL; ?>/login.php" class="text-rose-500 font-semibold hover:text-rose-600">
                                Đăng nhập ngay
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="<?php echo APP_URL; ?>" class="text-gray-600 hover:text-rose-500 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay về trang chủ
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function handleRegister(event) {
    event.preventDefault();
    const form = event.target;
    const password = form.password.value;
    const confirmPassword = form.confirm_password.value;
    
    if (password !== confirmPassword) {
        showToast('Mật khẩu xác nhận không khớp!', 'error');
        return;
    }
    
    showToast('Tính năng đăng ký đang được phát triển!', 'warning');
    // Xử lý đăng ký ở đây
}
</script>

<?php include '../includes/footer.php'; ?>

