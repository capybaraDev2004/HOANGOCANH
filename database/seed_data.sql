-- ============================================
-- Seed Data - Dữ liệu mẫu
-- ============================================

USE hoa_ngoc_anh;

-- Tắt kiểm tra foreign key tạm thời để insert dữ liệu
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- 1. Tài khoản Admin
-- ============================================
-- Password: 123456 (đã hash bằng password_hash PHP)
INSERT INTO users (email, password, full_name, phone, role, status, email_verified) VALUES
('admin@gmail.com', '$2y$10$MkiahhpKWBZOgRariTzd9uXUpSZmZvp/YPN./xS06QFE.xlowgmQ6', 'Administrator', '0392690630', 'admin', 'active', TRUE);

-- ============================================
-- 2. Danh mục sản phẩm
-- ============================================
INSERT INTO categories (name, slug, description, display_order, status) VALUES
('Hoa Sinh Nhật', 'hoa-sinh-nhat', 'Các loại hoa tươi dành cho sinh nhật', 1, 'active'),
('Hoa 8/3', 'hoa-8-3', 'Hoa tươi ngày Quốc tế Phụ nữ', 2, 'active'),
('Hoa Khai Trương', 'hoa-khai-truong', 'Hoa chúc mừng khai trương', 3, 'active'),
('Hoa Tốt Nghiệp', 'hoa-tot-nghiep', 'Hoa chúc mừng tốt nghiệp', 4, 'active'),
('Hoa Chia Buồn', 'hoa-chia-buon', 'Hoa viếng, chia buồn', 5, 'active'),
('Bó Hoa', 'bo-hoa', 'Các loại bó hoa tươi', 6, 'active'),
('Hoa Lan Hồ Điệp', 'hoa-lan-ho-diep', 'Hoa lan hồ điệp cao cấp', 7, 'active');

-- Danh mục con của Hoa Sinh Nhật
INSERT INTO categories (name, slug, description, parent_id, display_order, status) VALUES
('Bó Hoa Sinh Nhật', 'bo-hoa-sinh-nhat', 'Bó hoa tươi cho sinh nhật', 1, 1, 'active'),
('Giỏ Hoa Sinh Nhật', 'gio-hoa-sinh-nhat', 'Giỏ hoa tươi cho sinh nhật', 1, 2, 'active'),
('Lẵng Hoa Sinh Nhật', 'lang-hoa-sinh-nhat', 'Lẵng hoa tươi cho sinh nhật', 1, 3, 'active'),
('Hoa Sinh Nhật Người Yêu', 'hoa-sinh-nhat-nguoi-yeu', 'Hoa sinh nhật tặng người yêu', 1, 4, 'active'),
('Hoa Sinh Nhật Tặng Vợ', 'hoa-sinh-nhat-tang-vo', 'Hoa sinh nhật tặng vợ', 1, 5, 'active'),
('Hoa Sinh Nhật Tặng Mẹ', 'hoa-sinh-nhat-tang-me', 'Hoa sinh nhật tặng mẹ', 1, 6, 'active');

-- Danh mục con của Hoa Khai Trương
INSERT INTO categories (name, slug, description, parent_id, display_order, status) VALUES
('Kệ Hoa Khai Trương', 'ke-hoa-khai-truong', 'Kệ hoa khai trương', 3, 1, 'active'),
('Lẵng Hoa Khai Trương', 'lang-hoa-khai-truong', 'Lẵng hoa khai trương', 3, 2, 'active'),
('Giỏ Hoa Khai Trương', 'gio-hoa-khai-truong', 'Giỏ hoa khai trương', 3, 3, 'active');

-- Danh mục con của Hoa Chia Buồn
INSERT INTO categories (name, slug, description, parent_id, display_order, status) VALUES
('Kệ Hoa Chia Buồn', 'ke-hoa-chia-buon', 'Kệ hoa chia buồn', 5, 1, 'active'),
('Giỏ Hoa Chia Buồn', 'gio-hoa-chia-buon', 'Giỏ hoa chia buồn', 5, 2, 'active');

-- ============================================
-- 3. Slider mẫu
-- ============================================
INSERT INTO sliders (title, description, image_url, link_url, button_text, display_order, status) VALUES
('Chào mừng đến với Hoa Ngọc Anh', 'Dịch vụ đặt hoa online chất lượng, giao hàng nhanh trong 90-120 phút', '/assets/images/slider1.jpg', '/shop.php', 'Mua sắm ngay', 1, 'active'),
('Hoa tươi mỗi ngày', 'Mang đến những sản phẩm hoa tươi làm đẹp cuộc sống', '/assets/images/slider2.jpg', '/category.php?cat=bo-hoa', 'Xem sản phẩm', 2, 'active'),
('Miễn phí giao hàng', 'Đơn hàng trên 600k được miễn phí giao hàng', '/assets/images/slider3.jpg', '/shop.php', 'Đặt hàng ngay', 3, 'active');

-- ============================================
-- 4. Địa chỉ shop/văn phòng
-- ============================================
INSERT INTO addresses (name, address, ward, district, city, phone, email, type, display_order, status) VALUES
('Văn phòng Miền Bắc', '177 Trung Kính, phường Yên Hoà, quận Cầu Giấy', 'Yên Hoà', 'Cầu Giấy', 'Hà Nội', '0392690630', 'contact@hoangocanh.com', 'office', 1, 'active'),
('Văn phòng Miền Nam', '151 Nguyễn Duy Trinh, TP Thủ Đức', NULL, 'Thủ Đức', 'Hồ Chí Minh', '0966312360', 'contact@hoangocanh.com', 'office', 2, 'active'),
('Shop 1 - Thuy Khuê', '169 Thuy Khuê, Phường Thuy Khuê, Quận Tây Hồ', 'Thuy Khuê', 'Tây Hồ', 'Hà Nội', '0392690630', NULL, 'shop', 1, 'active'),
('Shop 2 - Giang Văn Minh', '49 Giang Văn Minh, Phường Đội Cấn, Quận Ba Đình', 'Đội Cấn', 'Ba Đình', 'Hà Nội', '0392690630', NULL, 'shop', 2, 'active'),
('Shop 3 - Phùng Hưng', '145 Phùng Hưng, Phường Phúc La, Quận Hà Đông', 'Phúc La', 'Hà Đông', 'Hà Nội', '0392690630', NULL, 'shop', 3, 'active'),
('Shop 4 - Hoàng Cầu', 'Số 1 Hoàng Cầu, Phường Ô Chợ Dừa, Quận Đống Đa', 'Ô Chợ Dừa', 'Đống Đa', 'Hà Nội', '0392690630', NULL, 'shop', 4, 'active'),
('Shop 5 - Cầu Diễn', '32 Cầu Diễn, Phường Phúc Diễn, Quận Bắc Từ Liêm', 'Phúc Diễn', 'Bắc Từ Liêm', 'Hà Nội', '0392690630', NULL, 'shop', 5, 'active'),
('Shop 6 - Linh Nam', '569 Linh Nam, Phường Lĩnh Nam Quận Hoàng Mai', 'Lĩnh Nam', 'Hoàng Mai', 'Hà Nội', '0392690630', NULL, 'shop', 6, 'active'),
('Shop 7 - Đường Láng', '216 Đường Láng, Phường Thịnh Quang, Quận Đống Đa', 'Thịnh Quang', 'Đống Đa', 'Hà Nội', '0392690630', NULL, 'shop', 7, 'active'),
('Shop 8 - Bắc Ninh', '18 Hồ Ngọc Lân, Phường Kinh Bắc, TP. Bắc Ninh', 'Kinh Bắc', NULL, 'Bắc Ninh', '0392690630', NULL, 'shop', 8, 'active'),
('Shop 9 - Bắc Ninh', '77 Trần Hưng Đạo, Phường Tiền An, TP Bắc Ninh', 'Tiền An', NULL, 'Bắc Ninh', '0392690630', NULL, 'shop', 9, 'active'),
('Shop 10 - Bắc Giang', '218 Xương Giang, Phường Ngô Quyền, TP Bắc Giang', 'Ngô Quyền', NULL, 'Bắc Giang', '0392690630', NULL, 'shop', 10, 'active');

-- ============================================
-- 5. Sản phẩm mẫu (50 sản phẩm)
-- ============================================
-- Dữ liệu sản phẩm chi tiết được import từ file seed_products.sql
-- Chạy file seed_products.sql để có đầy đủ 50 sản phẩm với hình ảnh và thuộc tính

-- ============================================
-- 6. Settings - Cấu hình website
-- ============================================
INSERT INTO settings (key_name, key_value, description) VALUES
('site_name', 'Hoa Ngọc Anh Floral & Gifts', 'Tên website'),
('site_email', 'contact@hoangocanh.com', 'Email liên hệ'),
('site_phone', '0392690630', 'Số điện thoại liên hệ'),
('free_shipping_threshold', '600000', 'Ngưỡng miễn phí vận chuyển (VNĐ)'),
('shipping_fee', '30000', 'Phí vận chuyển mặc định (VNĐ)'),
('delivery_time', '90-120 phút', 'Thời gian giao hàng'),
('discount_code', 'Uudais', 'Mã giảm giá mặc định'),
('discount_percentage', '5', 'Phần trăm giảm giá mặc định');

-- ============================================
-- 7. Mã giảm giá mẫu
-- ============================================
INSERT INTO coupons (code, description, discount_type, discount_value, min_order_value, start_date, end_date, status) VALUES
('Uudais', 'Giảm 5% cho đơn hàng online', 'percentage', 5.00, 0, NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR), 'active'),
('WELCOME10', 'Giảm 10% cho khách hàng mới', 'percentage', 10.00, 100000, NOW(), DATE_ADD(NOW(), INTERVAL 6 MONTH), 'active'),
('FREESHIP', 'Miễn phí vận chuyển', 'fixed', 50000, 500000, NOW(), DATE_ADD(NOW(), INTERVAL 3 MONTH), 'active');

-- Bật lại kiểm tra foreign key
SET FOREIGN_KEY_CHECKS = 1;

