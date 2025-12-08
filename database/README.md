# Hướng dẫn cài đặt Database

## Cách 1: Sử dụng MySQL Command Line

```bash
# Tạo database và các bảng
mysql -u root -p < create_database.sql

# Thêm dữ liệu mẫu cơ bản
mysql -u root -p hoa_ngoc_anh < seed_data.sql

# Thêm 50 sản phẩm mẫu với hình ảnh và thuộc tính
mysql -u root -p hoa_ngoc_anh < seed_products.sql
```

## Cách 2: Sử dụng phpMyAdmin

1. Mở phpMyAdmin: `http://localhost/phpmyadmin`
2. Tạo database mới: `hoa_ngoc_anh`
3. Chọn database vừa tạo
4. Vào tab "SQL"
5. Copy nội dung file `create_database.sql` và chạy
6. Copy nội dung file `seed_data.sql` và chạy
7. Copy nội dung file `seed_products.sql` và chạy (50 sản phẩm mẫu)

## Cách 3: Sử dụng MySQL Workbench

1. Mở MySQL Workbench
2. Kết nối đến MySQL server
3. File → Open SQL Script → Chọn `create_database.sql`
4. Chạy script (Ctrl+Shift+Enter)
5. Lặp lại với file `seed_data.sql`
6. Lặp lại với file `seed_products.sql` (50 sản phẩm mẫu)

## Thông tin đăng nhập Admin

Sau khi chạy seed data, bạn có thể đăng nhập admin với:

- **Email:** `admin@hoangocanh.com`
- **Mật khẩu:** `123456`

## Lưu ý

- Đảm bảo MySQL/MariaDB đã được cài đặt và chạy
- Kiểm tra cấu hình database trong `config/config.php` trước khi chạy
- Nếu database đã tồn tại, có thể cần xóa và tạo lại

## Cấu trúc file

- `create_database.sql` - Tạo tất cả các bảng
- `seed_data.sql` - Dữ liệu mẫu cơ bản (admin, categories, sliders, addresses, settings)
- `seed_products.sql` - 50 sản phẩm mẫu với hình ảnh và thuộc tính
- `install.sql` - File tổng hợp (chạy tất cả các file trên)

