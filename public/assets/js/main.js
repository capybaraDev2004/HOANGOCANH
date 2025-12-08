/**
 * Main JavaScript cho Siin Store
 */

// =====================================
// Global Variables
// =====================================
let cart = [];
let wishlist = [];
let guestId = null;

// =====================================
// Guest Identification
// =====================================
function getOrCreateGuestId() {
    // Kiểm tra xem đã có mã định danh chưa
    guestId = localStorage.getItem('guest_id');
    
    if (!guestId) {
        // Tạo mã định danh duy nhất: timestamp + random string
        const timestamp = Date.now();
        const randomStr = Math.random().toString(36).substring(2, 15);
        guestId = `guest_${timestamp}_${randomStr}`;
        localStorage.setItem('guest_id', guestId);
        
        // Lưu thời gian tạo
        localStorage.setItem('guest_created_at', new Date().toISOString());
    }
    
    return guestId;
}

// =====================================
// Initialize
// =====================================
document.addEventListener('DOMContentLoaded', function() {
    // Tạo hoặc lấy mã định danh người dùng
    getOrCreateGuestId();
    
    initMobileMenu();
    initCart();
    initSearch();
    initScrollEffects();
    loadCartFromStorage();
    updateCartCount();
});

// =====================================
// Mobile Menu
// =====================================
function initMobileMenu() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
}

function toggleMobileSubmenu(menuId) {
    const submenu = document.getElementById('submenu-' + menuId);
    if (submenu) {
        submenu.classList.toggle('hidden');
    }
}

// =====================================
// Shopping Cart Functions
// =====================================
function initCart() {
    // Đảm bảo có mã định danh
    if (!guestId) {
        getOrCreateGuestId();
    }
    
    // Load cart from localStorage theo mã định danh
    const cartKey = `cart_${guestId}`;
    const savedCart = localStorage.getItem(cartKey);
    if (savedCart) {
        try {
            cart = JSON.parse(savedCart);
        } catch (e) {
            console.error('Lỗi khi đọc giỏ hàng:', e);
            cart = [];
        }
    } else {
        cart = [];
    }
}

function addToCart(productId, quantity = 1, productData = null) {
    // Đảm bảo có mã định danh
    if (!guestId) {
        getOrCreateGuestId();
    }
    
    // Chuyển đổi sang số nguyên
    productId = parseInt(productId);
    quantity = parseInt(quantity) || 1;
    
    // Nếu có productData từ button, lưu thông tin sản phẩm
    if (productData) {
        const productsKey = `products_${guestId}`;
        let products = {};
        try {
            const saved = localStorage.getItem(productsKey);
            if (saved) {
                products = JSON.parse(saved);
            }
        } catch (e) {
            console.error('Lỗi khi đọc thông tin sản phẩm:', e);
        }
        
        products[productId] = {
            id: productId,
            name: productData.name || '',
            slug: productData.slug || '',
            image: productData.image || '',
            price: parseFloat(productData.price) || 0,
            sale_price: productData.sale_price ? parseFloat(productData.sale_price) : null
        };
        
        localStorage.setItem(productsKey, JSON.stringify(products));
    }
    
    // Tìm sản phẩm trong giỏ hàng
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({
            id: productId,
            quantity: quantity,
            addedAt: new Date().toISOString()
        });
    }
    
    saveCart();
    updateCartCount();
    showToast('Đã thêm sản phẩm vào giỏ hàng!', 'success');
}

function removeFromCart(productId) {
    productId = parseInt(productId);
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartCount();
    showToast('Đã xóa sản phẩm khỏi giỏ hàng!', 'warning');
}

function updateCartQuantity(productId, quantity) {
    productId = parseInt(productId);
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = parseInt(quantity);
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            saveCart();
            updateCartCount();
        }
    }
}

function clearCart() {
    cart = [];
    saveCart();
    updateCartCount();
    showToast('Đã xóa tất cả sản phẩm khỏi giỏ hàng!', 'warning');
}

function saveCart() {
    if (!guestId) {
        getOrCreateGuestId();
    }
    const cartKey = `cart_${guestId}`;
    localStorage.setItem(cartKey, JSON.stringify(cart));
}

function loadCartFromStorage() {
    if (!guestId) {
        getOrCreateGuestId();
    }
    const cartKey = `cart_${guestId}`;
    const savedCart = localStorage.getItem(cartKey);
    if (savedCart) {
        try {
            cart = JSON.parse(savedCart);
        } catch (e) {
            console.error('Lỗi khi đọc giỏ hàng:', e);
            cart = [];
        }
    } else {
        cart = [];
    }
}

function updateCartCount() {
    const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = cartCount;
    }
}

function getCartTotal() {
    // Sẽ được implement khi có API backend
    return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
}

// =====================================
// Wishlist Functions
// =====================================
function addToWishlist(productId) {
    if (!wishlist.includes(productId)) {
        wishlist.push(productId);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        showToast('Đã thêm vào danh sách yêu thích!', 'success');
    } else {
        showToast('Sản phẩm đã có trong danh sách yêu thích!', 'warning');
    }
}

function removeFromWishlist(productId) {
    wishlist = wishlist.filter(id => id !== productId);
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
    showToast('Đã xóa khỏi danh sách yêu thích!', 'warning');
}

// =====================================
// Quick View Modal
// =====================================
function quickView(productId) {
    // Sẽ được implement khi có API backend
    console.log('Quick view product:', productId);
    showToast('Tính năng xem nhanh đang được phát triển!', 'warning');
}

// =====================================
// Search Functions
// =====================================
function initSearch() {
    const searchInputs = document.querySelectorAll('input[type="text"][placeholder*="Tìm kiếm"]');
    
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(this.value);
            }
        });
    });
}

function performSearch(query) {
    if (query.trim() !== '') {
        window.location.href = `${window.location.origin}/search.php?q=${encodeURIComponent(query)}`;
    }
}

// =====================================
// Toast Notification
// =====================================
function showToast(message, type = 'success') {
    // Remove existing toasts
    const existingToasts = document.querySelectorAll('.toast');
    existingToasts.forEach(toast => toast.remove());
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        display: flex;
        align-items: center;
        min-width: 300px;
        animation: slideInRight 0.3s ease;
    `;
    
    // Icon based on type
    let icon = '';
    let bgColor = '';
    switch(type) {
        case 'success':
            icon = '<i class="fas fa-check-circle text-green-500 mr-2"></i>';
            bgColor = 'border-l-4 border-green-500';
            break;
        case 'error':
            icon = '<i class="fas fa-times-circle text-red-500 mr-2"></i>';
            bgColor = 'border-l-4 border-red-500';
            break;
        case 'warning':
            icon = '<i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i>';
            bgColor = 'border-l-4 border-yellow-500';
            break;
    }
    
    toast.className = `toast ${type} ${bgColor}`;
    toast.innerHTML = `
        <div class="flex items-center">
            ${icon}
            <span class="text-gray-800 font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS animations if not exists
if (!document.getElementById('toast-animations')) {
    const style = document.createElement('style');
    style.id = 'toast-animations';
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// =====================================
// Scroll Effects
// =====================================
function initScrollEffects() {
    // Sticky header effect
    let lastScroll = 0;
    const header = document.querySelector('header');
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll <= 0) {
            header.classList.remove('scroll-up');
            return;
        }
        
        if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
            // Scroll Down
            header.classList.remove('scroll-up');
            header.classList.add('scroll-down');
        } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
            // Scroll Up
            header.classList.remove('scroll-down');
            header.classList.add('scroll-up');
        }
        
        lastScroll = currentScroll;
    });
    
    // Fade-in animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// =====================================
// Image Lazy Loading
// =====================================
if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
        img.src = img.dataset.src || img.src;
    });
} else {
    // Fallback for browsers that don't support lazy loading
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
    document.body.appendChild(script);
}

// =====================================
// Format Currency
// =====================================
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// =====================================
// Smooth Scroll to Top
// =====================================
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show scroll to top button
window.addEventListener('scroll', () => {
    const scrollBtn = document.getElementById('scroll-to-top');
    if (scrollBtn) {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.remove('hidden');
        } else {
            scrollBtn.classList.add('hidden');
        }
    }
});

// =====================================
// Product Filter & Sort
// =====================================
function filterProducts(category) {
    console.log('Filter by category:', category);
    // Sẽ được implement khi có API backend
}

function sortProducts(sortBy) {
    console.log('Sort by:', sortBy);
    // Sẽ được implement khi có API backend
}

// =====================================
// Newsletter Subscription
// =====================================
function subscribeNewsletter(email) {
    if (validateEmail(email)) {
        // Sẽ được implement khi có API backend
        showToast('Đăng ký nhận tin thành công!', 'success');
        return true;
    } else {
        showToast('Email không hợp lệ!', 'error');
        return false;
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// =====================================
// Export functions to global scope
// =====================================
window.toggleMobileSubmenu = toggleMobileSubmenu;
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateCartQuantity = updateCartQuantity;
window.clearCart = clearCart;
window.addToWishlist = addToWishlist;
window.removeFromWishlist = removeFromWishlist;
window.quickView = quickView;
window.scrollToTop = scrollToTop;
window.filterProducts = filterProducts;
window.sortProducts = sortProducts;

