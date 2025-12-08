<?php
require_once '../config/config.php';
require_once BASE_PATH . '/app/Database/Database.php';
require_once BASE_PATH . '/app/Models/ProductModel.php';
require_once BASE_PATH . '/app/Models/ProductImageModel.php';

$page_title = 'Giỏ hàng - ' . APP_NAME;
$page_description = 'Giỏ hàng của bạn';

// Dữ liệu mẫu giỏ hàng (sẽ lấy từ session/database)
$productModel = new ProductModel();
$productImageModel = new ProductImageModel();

// Lấy 2 sản phẩm mẫu từ database
$sampleProducts = $productModel->getAll(['status' => 'active']);
$cart_items = [];

// Lấy tối đa 2 sản phẩm đầu tiên
for ($i = 0; $i < min(2, count($sampleProducts)); $i++) {
    $product = $sampleProducts[$i];
    
    // Lấy ảnh chính của sản phẩm
    $images = $productImageModel->getByProductId($product['id']);
    $mainImage = !empty($images) ? $images[0]['image_url'] : IMAGES_URL . '/products/default.jpg';
    
    // Xử lý URL ảnh
    if (strpos($mainImage, 'http://') === 0 || strpos($mainImage, 'https://') === 0) {
        // URL external, giữ nguyên
        $imageUrl = $mainImage;
    } elseif (strpos($mainImage, '/assets/images/') === 0) {
        // Relative path từ root
        $imageUrl = APP_URL . $mainImage;
    } elseif (strpos($mainImage, '/') === 0) {
        // Relative path khác
        $imageUrl = APP_URL . $mainImage;
    } else {
        // Path tương đối
        $imageUrl = IMAGES_URL . '/products/' . $mainImage;
    }
    
    $cart_items[] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'slug' => $product['slug'],
        'image' => $imageUrl,
        'price' => floatval($product['sale_price'] ?: $product['price']),
        'quantity' => $i + 1, // Số lượng mẫu
    ];
}

// Nếu không có sản phẩm trong database, dùng dữ liệu mẫu với ảnh mặc định
if (empty($cart_items)) {
    $cart_items = [
        [
            'id' => 1,
            'name' => 'Bó hoa Vạn Hoa Yêu Thương SSBHH30',
            'slug' => 'bo-hoa-van-hoa-yeu-thuong-ssbhh30',
            'image' => IMAGES_URL . '/products/hoa1.png',
            'price' => 800000,
            'quantity' => 2,
        ],
        [
            'id' => 2,
            'name' => 'Chậu lan hồ điệp cam - LHDC4',
            'slug' => 'chau-lan-ho-diep-cam-lhdc4',
            'image' => IMAGES_URL . '/products/hoa2.png',
            'price' => 1150000,
            'quantity' => 1,
        ],
    ];
}

$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$shipping_fee = $subtotal >= 600000 ? 0 : 30000;
$discount = 0; // Giảm giá từ mã coupon
$total = $subtotal + $shipping_fee - $discount;

include '../includes/header.php';
?>

<!-- Breadcrumb -->
<div class="bg-gray-50 py-4">
    <div class="container mx-auto px-4">
        <div class="breadcrumb">
            <a href="<?php echo APP_URL; ?>"><i class="fas fa-home"></i> Trang chủ</a>
            <span class="separator">/</span>
            <span class="text-gray-800 font-medium">Giỏ hàng</span>
        </div>
    </div>
</div>

<!-- Cart Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">
            <i class="fas fa-shopping-cart text-rose-500 mr-3"></i>
            Giỏ hàng của bạn
        </h1>

        <!-- Empty Cart (sẽ được ẩn nếu có sản phẩm) -->
        <div id="empty-cart" class="bg-white rounded-xl shadow-sm p-12 text-center hidden">
            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-700 mb-3">Giỏ hàng trống</h2>
            <p class="text-gray-600 mb-6">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
            <a href="<?php echo APP_URL; ?>/shop.php" 
               class="inline-block bg-gradient-to-r from-rose-500 to-pink-500 text-white px-8 py-3 rounded-full font-semibold hover:shadow-lg transition">
                Tiếp tục mua sắm
            </a>
        </div>
        
        <!-- Cart Content -->
        <div id="cart-content" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Cart Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <div class="grid grid-cols-12 gap-4 font-semibold text-gray-700">
                                <div class="col-span-6">Sản phẩm</div>
                                <div class="col-span-2 text-center">Đơn giá</div>
                                <div class="col-span-2 text-center">Số lượng</div>
                                <div class="col-span-2 text-right">Tổng</div>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div id="cart-items">
                            <!-- Sẽ được load từ localStorage bằng JavaScript -->
                        </div>

                        <!-- Cart Actions -->
                        <div class="p-6 bg-gray-50">
                            <div class="flex justify-between items-center">
                                <a href="<?php echo APP_URL; ?>/shop.php" 
                                   class="text-rose-500 font-semibold hover:text-rose-600 transition">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Tiếp tục mua sắm
                                </a>
                                <button onclick="clearCart()" 
                                        class="text-red-500 font-semibold hover:text-red-600 transition">
                                    <i class="fas fa-trash mr-2"></i>
                                    Xóa giỏ hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                        <h3 class="text-xl font-bold mb-6">Tổng đơn hàng</h3>

                        <!-- Coupon -->
                        <?php /* Tạm thời tắt chức năng mã giảm giá
                        <div class="mb-6">
                            <label class="block text-sm font-semibold mb-2">Mã giảm giá</label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       id="coupon-code"
                                       placeholder="Nhập mã..." 
                                       class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500">
                                <button onclick="applyCoupon()" 
                                        class="bg-rose-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-rose-600 transition">
                                    Áp dụng
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-tag mr-1"></i>
                                Nhập mã "Uudai5" giảm 5%
                            </p>
                        </div>
                        */ ?>

                        <!-- Price Details -->
                        <div id="cart-summary" class="space-y-3 mb-6">
                            <!-- Sẽ được cập nhật bằng JavaScript -->
                        </div>

                        <!-- Checkout Button -->
                        <?php /* Tạm thời tắt chức năng thanh toán
                        <button onclick="checkout()" 
                                class="w-full bg-gradient-to-r from-rose-500 to-pink-500 text-white py-4 rounded-xl font-bold text-lg hover:shadow-lg transition-all hover:-translate-y-1 mb-3">
                            <i class="fas fa-credit-card mr-2"></i>
                            Tiến hành thanh toán
                        </button>

                        <div class="text-center text-sm text-gray-600">
                            <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                            Thanh toán an toàn & bảo mật
                        </div>

                        <!-- Payment Methods -->
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-sm font-semibold mb-3">Chúng tôi chấp nhận:</p>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="border rounded p-2 text-center">
                                    <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                                    <p class="text-xs mt-1">Tiền mặt</p>
                                </div>
                                <div class="border rounded p-2 text-center">
                                    <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                                    <p class="text-xs mt-1">Thẻ</p>
                                </div>
                                <div class="border rounded p-2 text-center">
                                    <i class="fas fa-mobile-alt text-purple-600 text-2xl"></i>
                                    <p class="text-xs mt-1">Ví điện tử</p>
                                </div>
                            </div>
                        </div>
                        */ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Định nghĩa formatCurrency trước
function formatCurrency(amount) {
    if (isNaN(amount) || amount === null || amount === undefined) {
        amount = 0;
    }
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Escape HTML helper function
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = String(text);
    return div.innerHTML;
}

// Load và render giỏ hàng từ localStorage
function loadCartFromStorage() {
    try {
        console.log('Loading cart from storage...');
        
        const cartItemsEl = document.getElementById('cart-items');
        const emptyCartEl = document.getElementById('empty-cart');
        const cartContentEl = document.getElementById('cart-content');
        const cartSummaryEl = document.getElementById('cart-summary');
        
        if (!cartItemsEl) {
            console.error('cart-items element not found');
            return;
        }
        
        const guestId = localStorage.getItem('guest_id');
        console.log('Guest ID:', guestId);
        
        if (!guestId) {
            console.log('No guest ID found');
            cartItemsEl.innerHTML = '<div class="p-6 text-center text-gray-500">Giỏ hàng trống</div>';
            if (emptyCartEl) emptyCartEl.classList.remove('hidden');
            if (cartContentEl) cartContentEl.classList.add('hidden');
            if (typeof updateCartSummary === 'function') {
                updateCartSummary(0, 0);
            }
            return;
        }
        
        const cartKey = 'cart_' + guestId;
        const productsKey = 'products_' + guestId;
        
        let cart = [];
        let products = {};
        
        try {
            const cartData = localStorage.getItem(cartKey);
            console.log('Cart data:', cartData);
            if (cartData) {
                cart = JSON.parse(cartData);
                console.log('Parsed cart:', cart);
            }
            
            const productsData = localStorage.getItem(productsKey);
            console.log('Products data:', productsData);
            if (productsData) {
                products = JSON.parse(productsData);
                console.log('Parsed products:', products);
            }
        } catch (e) {
            console.error('Lỗi khi đọc giỏ hàng:', e);
            cart = [];
            products = {};
        }
        
        if (!Array.isArray(cart) || cart.length === 0) {
            console.log('Cart is empty');
            cartItemsEl.innerHTML = '<div class="p-6 text-center text-gray-500">Giỏ hàng trống</div>';
            if (typeof updateCartSummary === 'function') {
                updateCartSummary(0, 0);
            }
            if (emptyCartEl) emptyCartEl.classList.remove('hidden');
            if (cartContentEl) cartContentEl.classList.add('hidden');
            return;
        }
        
        console.log('Cart has items:', cart.length);
        
        if (emptyCartEl) emptyCartEl.classList.add('hidden');
        if (cartContentEl) cartContentEl.classList.remove('hidden');
        
        let html = '';
        let subtotal = 0;
        const appUrl = '<?php echo APP_URL; ?>';
        const imagesUrl = '<?php echo IMAGES_URL; ?>';
        
        cart.forEach((item, index) => {
            try {
                const productId = parseInt(item.id);
                const product = products[productId] || {};
                const price = parseFloat(product.sale_price) || parseFloat(product.price) || 0;
                const quantity = parseInt(item.quantity) || 1;
                const itemTotal = price * quantity;
                subtotal += itemTotal;
                
                console.log(`Item ${index}:`, {
                    id: productId,
                    product: product,
                    price: price,
                    quantity: quantity,
                    total: itemTotal
                });
                
                const productName = escapeHtml(product.name || 'Sản phẩm #' + productId);
                const productSlug = escapeHtml(product.slug || '');
                const productImage = escapeHtml(product.image || imagesUrl + '/products/default.jpg');
                
                html += '<div class="cart-item p-6 border-b hover:bg-gray-50 transition" data-product-id="' + productId + '">';
                html += '<div class="grid grid-cols-12 gap-4 items-center">';
                html += '<div class="col-span-6 flex gap-4">';
                html += '<div class="relative">';
                html += '<a href="' + appUrl + '/product.php?slug=' + productSlug + '">';
                html += '<img src="' + productImage + '" alt="' + productName + '" class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition">';
                html += '</a>';
                html += '<button onclick="removeFromCart(' + productId + ')" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs hover:bg-red-600 transition z-10"><i class="fas fa-times"></i></button>';
                html += '</div>';
                html += '<div class="flex-1">';
                html += '<a href="' + appUrl + '/product.php?slug=' + productSlug + '" class="font-semibold text-gray-800 hover:text-rose-500 transition line-clamp-2 block">' + productName + '</a>';
                html += '<div class="text-sm text-gray-600 mt-1"><span class="text-green-600"><i class="fas fa-check-circle"></i> Còn hàng</span></div>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-span-2 text-center"><span class="font-semibold text-rose-500">' + formatCurrency(price) + '</span></div>';
                html += '<div class="col-span-2 flex justify-center">';
                html += '<div class="flex items-center border-2 border-gray-300 rounded-lg">';
                html += '<button onclick="updateCartQuantity(' + productId + ', ' + (quantity - 1) + ')" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition"><i class="fas fa-minus text-sm"></i></button>';
                html += '<input type="number" value="' + quantity + '" min="1" class="w-12 text-center border-0 focus:outline-none font-semibold" onchange="updateCartQuantity(' + productId + ', this.value)">';
                html += '<button onclick="updateCartQuantity(' + productId + ', ' + (quantity + 1) + ')" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 transition"><i class="fas fa-plus text-sm"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-span-2 text-right"><span class="font-bold text-lg text-gray-800">' + formatCurrency(itemTotal) + '</span></div>';
                html += '</div>';
                html += '</div>';
            } catch (e) {
                console.error('Error processing item:', e, item);
            }
        });
        
        cartItemsEl.innerHTML = html;
        
        console.log('Subtotal:', subtotal);
        if (typeof updateCartSummary === 'function') {
            updateCartSummary(subtotal, 0);
        } else {
            console.error('updateCartSummary function not found');
        }
        
        console.log('Cart loaded successfully');
    } catch (e) {
        console.error('Error in loadCartFromStorage:', e);
        const cartItemsEl = document.getElementById('cart-items');
        if (cartItemsEl) {
            cartItemsEl.innerHTML = '<div class="p-6 text-center text-red-500">Có lỗi xảy ra khi tải giỏ hàng. Vui lòng thử lại.</div>';
        }
    }
}

function updateCartSummary(subtotal, discount = 0) {
    const shippingFee = subtotal >= 600000 ? 0 : 30000;
    const total = subtotal + shippingFee - discount;
    
    let html = `
        <div class="flex justify-between text-gray-700">
            <span>Tạm tính:</span>
            <span class="font-semibold">${formatCurrency(subtotal)}</span>
        </div>
        <div class="flex justify-between text-gray-700">
            <span>Phí vận chuyển:</span>
            <span class="font-semibold ${shippingFee == 0 ? 'text-green-600' : ''}">
                ${shippingFee == 0 ? 'Miễn phí' : formatCurrency(shippingFee)}
            </span>
        </div>
    `;
    
    if (subtotal < 600000) {
        html += `
            <div class="text-xs text-orange-600 bg-orange-50 p-2 rounded">
                <i class="fas fa-info-circle mr-1"></i>
                Mua thêm ${formatCurrency(600000 - subtotal)} để được miễn phí vận chuyển
            </div>
        `;
    }
    
    if (discount > 0) {
        html += `
            <div class="flex justify-between text-green-600">
                <span>Giảm giá:</span>
                <span class="font-semibold">-${formatCurrency(discount)}</span>
            </div>
        `;
    }
    
    html += `
        <div class="border-t pt-3">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold">Tổng cộng:</span>
                <span class="text-2xl font-bold text-rose-500">
                    ${formatCurrency(total)}
                </span>
            </div>
        </div>
    `;
    
    document.getElementById('cart-summary').innerHTML = html;
}

// Override removeFromCart để reload giỏ hàng
window.removeFromCart = function(productId) {
    console.log('Removing product from cart:', productId);
    productId = parseInt(productId);
    
    const guestId = localStorage.getItem('guest_id');
    if (!guestId) {
        console.error('No guest ID');
        return;
    }
    
    const cartKey = `cart_${guestId}`;
    let cart = [];
    
    try {
        const cartData = localStorage.getItem(cartKey);
        if (cartData) {
            cart = JSON.parse(cartData);
        }
    } catch (e) {
        console.error('Error reading cart:', e);
        return;
    }
    
    // Xóa sản phẩm khỏi giỏ hàng
    cart = cart.filter(item => parseInt(item.id) !== productId);
    
    // Lưu lại
    localStorage.setItem(cartKey, JSON.stringify(cart));
    
    // Cập nhật số lượng trong header
    if (window.updateCartCount) {
        window.updateCartCount();
    }
    
    // Reload giỏ hàng
    loadCartFromStorage();
    
    // Hiển thị thông báo
    if (window.showToast) {
        window.showToast('Đã xóa sản phẩm khỏi giỏ hàng!', 'warning');
    }
};

// Override updateCartQuantity để reload giỏ hàng
window.updateCartQuantity = function(productId, quantity) {
    console.log('Updating cart quantity:', productId, quantity);
    productId = parseInt(productId);
    quantity = parseInt(quantity);
    
    if (quantity < 1) {
        window.removeFromCart(productId);
        return;
    }
    
    const guestId = localStorage.getItem('guest_id');
    if (!guestId) {
        console.error('No guest ID');
        return;
    }
    
    const cartKey = `cart_${guestId}`;
    let cart = [];
    
    try {
        const cartData = localStorage.getItem(cartKey);
        if (cartData) {
            cart = JSON.parse(cartData);
        }
    } catch (e) {
        console.error('Error reading cart:', e);
        return;
    }
    
    // Tìm và cập nhật số lượng
    const item = cart.find(item => parseInt(item.id) === productId);
    if (item) {
        item.quantity = quantity;
    }
    
    // Lưu lại
    localStorage.setItem(cartKey, JSON.stringify(cart));
    
    // Cập nhật số lượng trong header
    if (window.updateCartCount) {
        window.updateCartCount();
    }
    
    // Reload giỏ hàng
    loadCartFromStorage();
};

// Override clearCart để reload giỏ hàng
window.clearCart = function() {
    console.log('Clearing cart');
    
    const guestId = localStorage.getItem('guest_id');
    if (!guestId) {
        console.error('No guest ID');
        return;
    }
    
    const cartKey = `cart_${guestId}`;
    
    // Xóa giỏ hàng
    localStorage.setItem(cartKey, JSON.stringify([]));
    
    // Cập nhật số lượng trong header
    if (window.updateCartCount) {
        window.updateCartCount();
    }
    
    // Reload trang
    window.location.reload();
};

// Load giỏ hàng khi trang được tải
// Đảm bảo chạy sau khi DOM và main.js đã load
(function() {
    let cartLoaded = false;
    
    function initCartPage() {
        if (cartLoaded) {
            console.log('Cart already loaded, skipping...');
            return;
        }
        
        console.log('Initializing cart page...');
        
        // Kiểm tra xem các element đã tồn tại chưa
        const cartItemsEl = document.getElementById('cart-items');
        if (!cartItemsEl) {
            console.log('cart-items element not found, will retry...');
            return;
        }
        
        console.log('Elements found, loading cart...');
        cartLoaded = true;
        
        // Gọi hàm load giỏ hàng
        loadCartFromStorage();
    }
    
    // Chạy ngay khi script được load
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initCartPage, 100);
    }
    
    // Chạy khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initCartPage, 200);
        });
    }
    
    // Backup: chạy khi window load hoàn toàn
    window.addEventListener('load', function() {
        setTimeout(function() {
            if (!cartLoaded) {
                console.log('Window loaded, loading cart as backup...');
                initCartPage();
            }
        }, 300);
    });
})();

/* Tạm thời tắt chức năng mã giảm giá và thanh toán
function applyCoupon() {
    const code = document.getElementById('coupon-code').value;
    if (code.toLowerCase() === 'uudai5') {
        const guestId = localStorage.getItem('guest_id');
        const cartKey = `cart_${guestId}`;
        const productsKey = `products_${guestId}`;
        
        let cart = [];
        let products = {};
        
        try {
            const cartData = localStorage.getItem(cartKey);
            if (cartData) cart = JSON.parse(cartData);
            const productsData = localStorage.getItem(productsKey);
            if (productsData) products = JSON.parse(productsData);
        } catch (e) {}
        
        let subtotal = 0;
        cart.forEach(item => {
            const product = products[item.id] || {};
            const price = product.sale_price || product.price || 0;
            subtotal += price * item.quantity;
        });
        
        const discount = subtotal * 0.05;
        updateCartSummary(subtotal, discount);
        showToast('Áp dụng mã giảm giá thành công! Giảm 5%', 'success');
    } else {
        showToast('Mã giảm giá không hợp lệ!', 'error');
    }
}

function checkout() {
    showToast('Chức năng thanh toán đang được phát triển!', 'warning');
    // window.location.href = '<?php echo APP_URL; ?>/checkout.php';
}
*/
</script>

<?php include '../includes/footer.php'; ?>

