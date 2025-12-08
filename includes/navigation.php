<!-- Desktop Navigation -->
<nav class="hidden lg:block border-t">
    <ul class="main-nav flex items-center justify-center gap-8 py-3">
        <li>
            <a href="<?php echo APP_URL; ?>" class="text-gray-700 hover:text-rose-500 font-medium transition">
                Giới Thiệu
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>/shop.php" class="text-gray-700 hover:text-rose-500 font-medium transition">
                Shop
            </a>
        </li>
        <li class="relative group">
            <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat" class="nav-dropdown-trigger text-gray-700 font-medium transition flex items-center gap-1">
                Hoa Sinh Nhật
                <i class="fas fa-chevron-down text-xs"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="<?php echo APP_URL; ?>/category.php?cat=bo-hoa-sinh-nhat" class="nav-dropdown-item">Bó Hoa Sinh Nhật</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=gio-hoa-sinh-nhat" class="nav-dropdown-item">Giỏ Hoa Sinh Nhật</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=lang-hoa-sinh-nhat" class="nav-dropdown-item">Lẵng Hoa Sinh Nhật</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat-nguoi-yeu" class="nav-dropdown-item">Hoa Sinh Nhật Người Yêu</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat-tang-vo" class="nav-dropdown-item">Hoa Sinh Nhật Tặng Vợ</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat-tang-me" class="nav-dropdown-item">Hoa Sinh Nhật Tặng Mẹ</a>
            </div>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-8-3" class="text-gray-700 hover:text-rose-500 font-medium transition">
                Hoa 8/3
            </a>
        </li>
        <li class="relative group">
            <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-khai-truong" class="nav-dropdown-trigger text-gray-700 font-medium transition flex items-center gap-1">
                Hoa Khai Trương
                <i class="fas fa-chevron-down text-xs"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="<?php echo APP_URL; ?>/category.php?cat=ke-hoa-khai-truong" class="nav-dropdown-item">Kệ Hoa Khai Trương</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=lang-hoa-khai-truong" class="nav-dropdown-item">Lẵng Hoa Khai Trương</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=gio-hoa-khai-truong" class="nav-dropdown-item">Giỏ Hoa Khai Trương</a>
            </div>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-tot-nghiep" class="text-gray-700 hover:text-rose-500 font-medium transition">
                Hoa Tốt Nghiệp
            </a>
        </li>
        <li class="relative group">
            <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-chia-buon" class="nav-dropdown-trigger text-gray-700 font-medium transition flex items-center gap-1">
                Hoa Chia Buồn
                <i class="fas fa-chevron-down text-xs"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="<?php echo APP_URL; ?>/category.php?cat=ke-hoa-chia-buon" class="nav-dropdown-item">Kệ Hoa Chia Buồn</a>
                <a href="<?php echo APP_URL; ?>/category.php?cat=gio-hoa-chia-buon" class="nav-dropdown-item">Giỏ Hoa Chia Buồn</a>
            </div>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>/category.php?cat=bo-hoa" class="text-gray-700 hover:text-rose-500 font-medium transition">
                Bó Hoa
            </a>
        </li>
        <li>
            <a href="<?php echo APP_URL; ?>/category.php?cat=hoa-lan-ho-diep" class="text-gray-700 hover:text-rose-500 font-medium transition">
                Hoa Lan Hồ Điệp
            </a>
        </li>
    </ul>
</nav>

<!-- Mobile Navigation -->
<nav id="mobile-menu" class="lg:hidden hidden border-t">
    <ul class="py-2">
        <li><a href="<?php echo APP_URL; ?>" class="block px-4 py-2 hover:bg-gray-100">Giới Thiệu</a></li>
        <li><a href="<?php echo APP_URL; ?>/shop.php" class="block px-4 py-2 hover:bg-gray-100">Shop</a></li>
        <li>
            <button class="w-full text-left px-4 py-2 hover:bg-gray-100 flex justify-between items-center" onclick="toggleMobileSubmenu('sinh-nhat')">
                Hoa Sinh Nhật
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul id="submenu-sinh-nhat" class="hidden bg-gray-50">
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=bo-hoa-sinh-nhat" class="block px-8 py-2 hover:bg-gray-100">Bó Hoa Sinh Nhật</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=gio-hoa-sinh-nhat" class="block px-8 py-2 hover:bg-gray-100">Giỏ Hoa Sinh Nhật</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=lang-hoa-sinh-nhat" class="block px-8 py-2 hover:bg-gray-100">Lẵng Hoa Sinh Nhật</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat-nguoi-yeu" class="block px-8 py-2 hover:bg-gray-100">Hoa Sinh Nhật Người Yêu</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat-tang-vo" class="block px-8 py-2 hover:bg-gray-100">Hoa Sinh Nhật Tặng Vợ</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=hoa-sinh-nhat-tang-me" class="block px-8 py-2 hover:bg-gray-100">Hoa Sinh Nhật Tặng Mẹ</a></li>
            </ul>
        </li>
        <li><a href="<?php echo APP_URL; ?>/category.php?cat=hoa-8-3" class="block px-4 py-2 hover:bg-gray-100">Hoa 8/3</a></li>
        <li>
            <button class="w-full text-left px-4 py-2 hover:bg-gray-100 flex justify-between items-center" onclick="toggleMobileSubmenu('khai-truong')">
                Hoa Khai Trương
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul id="submenu-khai-truong" class="hidden bg-gray-50">
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=ke-hoa-khai-truong" class="block px-8 py-2 hover:bg-gray-100">Kệ Hoa Khai Trương</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=lang-hoa-khai-truong" class="block px-8 py-2 hover:bg-gray-100">Lẵng Hoa Khai Trương</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=gio-hoa-khai-truong" class="block px-8 py-2 hover:bg-gray-100">Giỏ Hoa Khai Trương</a></li>
            </ul>
        </li>
        <li><a href="<?php echo APP_URL; ?>/category.php?cat=hoa-tot-nghiep" class="block px-4 py-2 hover:bg-gray-100">Hoa Tốt Nghiệp</a></li>
        <li>
            <button class="w-full text-left px-4 py-2 hover:bg-gray-100 flex justify-between items-center" onclick="toggleMobileSubmenu('chia-buon')">
                Hoa Chia Buồn
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <ul id="submenu-chia-buon" class="hidden bg-gray-50">
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=ke-hoa-chia-buon" class="block px-8 py-2 hover:bg-gray-100">Kệ Hoa Chia Buồn</a></li>
                <li><a href="<?php echo APP_URL; ?>/category.php?cat=gio-hoa-chia-buon" class="block px-8 py-2 hover:bg-gray-100">Giỏ Hoa Chia Buồn</a></li>
            </ul>
        </li>
        <li><a href="<?php echo APP_URL; ?>/category.php?cat=bo-hoa" class="block px-4 py-2 hover:bg-gray-100">Bó Hoa</a></li>
        <li><a href="<?php echo APP_URL; ?>/category.php?cat=hoa-lan-ho-diep" class="block px-4 py-2 hover:bg-gray-100">Hoa Lan Hồ Điệp</a></li>
    </ul>
</nav>

