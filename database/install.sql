-- ============================================
-- File cài đặt database hoàn chỉnh
-- Chạy file này để tạo database và dữ liệu mẫu
-- ============================================

-- Import file tạo database
SOURCE create_database.sql;

-- Import file dữ liệu mẫu
SOURCE seed_data.sql;

-- Import file sản phẩm mẫu (50 sản phẩm với hình ảnh và thuộc tính)
SOURCE seed_products.sql;

-- Hoàn tất
SELECT 'Database đã được tạo thành công!' AS message;
SELECT 'Tài khoản admin: admin' AS admin_email;
SELECT 'Mật khẩu: 123456' AS admin_password;
SELECT 'Đã thêm 50 sản phẩm mẫu với hình ảnh và thuộc tính' AS products_info;

