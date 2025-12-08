# Hướng dẫn cài đặt Website Bán Hoa

## Yêu cầu hệ thống

- **Web Server**: Apache 2.4+ hoặc Nginx
- **PHP**: 7.4 trở lên
- **MySQL**: 5.7+ hoặc MariaDB 10.3+ (cho phần backend sau này)
- **Browser**: Chrome, Firefox, Safari, Edge (phiên bản mới nhất)

## Các bước cài đặt

### 1. Clone hoặc Download dự án

```bash
git clone <repository-url>
cd hoaNgocAnh
```

Hoặc giải nén file ZIP vào thư mục web server của bạn.

### 2. Cấu hình Web Server

#### Với XAMPP/WAMP:

1. Copy thư mục dự án vào `htdocs/` (XAMPP) hoặc `www/` (WAMP)
2. Truy cập: `http://localhost/hoaNgocAnh/public`

#### Với Apache (Linux/macOS):

1. Copy dự án vào `/var/www/html/`
2. Cấu hình Virtual Host (tùy chọn):

```apache
<VirtualHost *:80>
    ServerName hoangocauh.local
    DocumentRoot "/var/www/html/hoaNgocAnh/public"
    
    <Directory "/var/www/html/hoaNgocAnh/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Thêm vào `/etc/hosts`:
```
127.0.0.1  hoangocauh.local
```

4. Restart Apache:
```bash
sudo systemctl restart apache2
```

### 3. Cấu hình dự án

Mở file `config/config.php` và chỉnh sửa:

```php
// Thay đổi APP_URL theo môi trường của bạn
define('APP_URL', 'http://localhost/hoaNgocAnh/public');

// Cấu hình database (khi cần dùng)
define('DB_HOST', 'localhost');
define('DB_NAME', 'hoa_ngoc_anh');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Cấu hình quyền truy cập (Linux/macOS)

```bash
# Cấp quyền cho thư mục uploads (khi có)
chmod -R 755 public/assets/images
chown -R www-data:www-data public/assets/images
```

### 5. Tạo hình ảnh mẫu

Vì dự án này chỉ là Frontend, bạn cần thêm hình ảnh vào:
- `public/assets/images/products/` - Hình sản phẩm
- `public/assets/images/blog/` - Hình blog
- `public/assets/images/` - Hình banner, hero, v.v.

**Khuyến nghị kích thước hình:**
- Sản phẩm: 800x800px
- Banner/Hero: 1920x600px
- Blog: 1200x600px

### 6. Kiểm tra cài đặt

1. Mở trình duyệt và truy cập: `http://localhost/hoaNgocAnh/public`
2. Kiểm tra các chức năng:
   - ✅ Trang chủ hiển thị đầy đủ
   - ✅ Menu điều hướng hoạt động
   - ✅ Tìm kiếm
   - ✅ Giỏ hàng (lưu trong localStorage)
   - ✅ Responsive trên mobile

## Cấu trúc thư mục

```
hoaNgocAnh/
├── config/              # File cấu hình
├── app/                 # Application logic
│   ├── Controllers/     # Controllers (sẽ dùng sau)
│   ├── Models/         # Models (sẽ dùng sau)
│   └── Views/          # Views (sẽ dùng sau)
├── includes/           # Components tái sử dụng
├── public/             # Thư mục public (document root)
│   ├── assets/         # CSS, JS, Images
│   ├── index.php       # Trang chủ
│   └── *.php          # Các trang khác
└── README.md
```

## Phát triển Backend (Tương lai)

Khi cần phát triển backend với PHP:

1. **Tạo database:**
```sql
CREATE DATABASE hoa_ngoc_anh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Import schema** (sẽ có file SQL sau)

3. **Cài đặt Composer** (nếu cần thư viện PHP):
```bash
composer install
```

4. **Cấu hình kết nối database** trong `config/config.php`

## Troubleshooting

### Lỗi 404 - Not Found
- Kiểm tra `.htaccess` có tồn tại trong `public/`
- Bật `mod_rewrite` cho Apache: `sudo a2enmod rewrite`

### CSS/JS không load
- Kiểm tra đường dẫn `APP_URL` trong `config/config.php`
- Kiểm tra quyền truy cập thư mục `public/assets/`

### Hình ảnh không hiển thị
- Thêm hình ảnh mẫu vào `public/assets/images/`
- Hoặc thay đổi đường dẫn hình trong code

### Giỏ hàng không lưu
- Kiểm tra Console của browser (F12)
- Đảm bảo JavaScript không bị lỗi
- Kiểm tra localStorage của browser

## Liên hệ hỗ trợ

Nếu gặp vấn đề, vui lòng:
- Kiểm tra logs của Apache/Nginx
- Kiểm tra Console của browser
- Đọc lại hướng dẫn cài đặt

## License

Dự án này được phát triển cho mục đích học tập và thương mại.

