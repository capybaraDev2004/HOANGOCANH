<?php
require_once '../config/config.php';

$page_title = 'Đăng nhập - ' . APP_NAME;
$page_description = 'Đăng nhập vào tài khoản của bạn';

include '../includes/header.php';
?>

<!-- Login Section -->
<section class="py-12 min-h-screen flex items-center bg-gradient-to-br from-rose-50 to-pink-50">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-rose-500 to-pink-500 text-white p-8 text-center">
                    <i class="fas fa-user-circle text-6xl mb-3"></i>
                    <h1 class="text-2xl font-bold">Đăng nhập</h1>
                    <p class="text-sm opacity-90 mt-2">Chào mừng bạn quay trở lại!</p>
                </div>

                <!-- Login Form -->
                <div class="p-8">
                    <form id="login-form" onsubmit="handleLogin(event)">
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
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500 transition">
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-rose-500 rounded">
                                <span class="ml-2 text-sm text-gray-700">Ghi nhớ đăng nhập</span>
                            </label>
                            <a href="#" class="text-sm text-rose-500 hover:text-rose-600 font-medium">
                                Quên mật khẩu?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-rose-500 to-pink-500 text-white py-3 rounded-lg font-bold text-lg hover:shadow-lg transition-all hover:-translate-y-1">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Đăng nhập
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-4 my-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="text-gray-500 text-sm">HOẶC</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Social Login -->
                    <div class="space-y-3">
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f mr-2"></i>
                            Đăng nhập với Facebook
                        </button>
                        <button class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                            <i class="fab fa-google mr-2"></i>
                            Đăng nhập với Google
                        </button>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center mt-6 pt-6 border-t">
                        <p class="text-gray-600">
                            Chưa có tài khoản? 
                            <a href="<?php echo APP_URL; ?>/register.php" class="text-rose-500 font-semibold hover:text-rose-600">
                                Đăng ký ngay
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
function handleLogin(event) {
    event.preventDefault();
    showToast('Tính năng đăng nhập đang được phát triển!', 'warning');
    // Xử lý đăng nhập ở đây
}
</script>

<?php include '../includes/footer.php'; ?>

