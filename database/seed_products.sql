-- ============================================
-- Seed Data - 50 Sản phẩm mẫu với thuộc tính và hình ảnh
-- ============================================

USE hoa_ngoc_anh;

-- Tắt kiểm tra foreign key tạm thời
SET FOREIGN_KEY_CHECKS = 0;

-- Xóa dữ liệu cũ (nếu có)
DELETE FROM product_attributes;
DELETE FROM product_images;
DELETE FROM products WHERE id > 0;

-- Reset AUTO_INCREMENT
ALTER TABLE products AUTO_INCREMENT = 1;
ALTER TABLE product_images AUTO_INCREMENT = 1;
ALTER TABLE product_attributes AUTO_INCREMENT = 1;

-- ============================================
-- 50 Sản phẩm mẫu
-- ============================================

-- Nhóm 1: Hoa Sinh Nhật (10 sản phẩm)
INSERT INTO products (category_id, name, slug, sku, description, price, sale_price, stock_quantity, featured, status) VALUES
(1, 'Bó Hoa Hồng Đỏ Sinh Nhật', 'bo-hoa-hong-do-sinh-nhat', 'SP1', 'Bó hoa hồng đỏ tươi thắm, kèm lá phụ và baby breath trắng, phù hợp tặng sinh nhật', 500000, 450000, 50, TRUE, 'active'),
(1, 'Giỏ Hoa Sinh Nhật Mix Nhiều Màu', 'gio-hoa-sinh-nhat-mix-nhieu-mau', 'SP2', 'Giỏ hoa mix nhiều loại hoa tươi với màu sắc rực rỡ', 600000, 550000, 30, TRUE, 'active'),
(1, 'Lẵng Hoa Sinh Nhật Hồng', 'lang-hoa-sinh-nhat-hong', 'SP3', 'Lẵng hoa hồng hồng đẹp mắt, sang trọng', 700000, 650000, 25, FALSE, 'active'),
(1, 'Bó Hoa Hồng Trắng Sinh Nhật', 'bo-hoa-hong-trang-sinh-nhat', 'SP4', 'Bó hoa hồng trắng tinh khôi, thanh lịch', 450000, 400000, 40, FALSE, 'active'),
(1, 'Giỏ Hoa Sinh Nhật Vàng', 'gio-hoa-sinh-nhat-vang', 'SP5', 'Giỏ hoa vàng rực rỡ, tươi vui', 550000, 500000, 35, FALSE, 'active'),
(1, 'Bó Hoa Hồng Đỏ Lớn Sinh Nhật', 'bo-hoa-hong-do-lon-sinh-nhat', 'SP6', 'Bó hoa hồng đỏ kích thước lớn, ấn tượng', 800000, 750000, 20, TRUE, 'active'),
(1, 'Lẵng Hoa Sinh Nhật Mix', 'lang-hoa-sinh-nhat-mix', 'SP7', 'Lẵng hoa mix nhiều loại, đa dạng màu sắc', 650000, 600000, 28, FALSE, 'active'),
(1, 'Bó Hoa Hồng Hồng Sinh Nhật', 'bo-hoa-hong-hong-sinh-nhat', 'SP8', 'Bó hoa hồng màu hồng ngọt ngào', 480000, 430000, 45, FALSE, 'active'),
(1, 'Giỏ Hoa Sinh Nhật Đỏ Trắng', 'gio-hoa-sinh-nhat-do-trang', 'SP9', 'Giỏ hoa kết hợp đỏ và trắng hài hòa', 580000, 530000, 32, FALSE, 'active'),
(1, 'Bó Hoa Sinh Nhật Đặc Biệt', 'bo-hoa-sinh-nhat-dac-biet', 'SP10', 'Bó hoa sinh nhật đặc biệt với thiết kế độc đáo', 900000, 850000, 15, TRUE, 'active'),

-- Nhóm 2: Hoa 8/3 (8 sản phẩm)
(2, 'Bó Hoa 8/3 Hồng Đỏ', 'bo-hoa-8-3-hong-do', 'SP11', 'Bó hoa chúc mừng ngày Quốc tế Phụ nữ', 350000, 300000, 60, FALSE, 'active'),
(2, 'Giỏ Hoa 8/3 Mix', 'gio-hoa-8-3-mix', 'SP12', 'Giỏ hoa 8/3 đa dạng màu sắc', 450000, 400000, 50, FALSE, 'active'),
(2, 'Bó Hoa 8/3 Hồng', 'bo-hoa-8-3-hong', 'SP13', 'Bó hoa hồng ngọt ngào cho ngày 8/3', 380000, 330000, 55, FALSE, 'active'),
(2, 'Lẵng Hoa 8/3 Đặc Biệt', 'lang-hoa-8-3-dac-biet', 'SP14', 'Lẵng hoa 8/3 đặc biệt, sang trọng', 550000, 500000, 30, TRUE, 'active'),
(2, 'Bó Hoa 8/3 Vàng', 'bo-hoa-8-3-vang', 'SP15', 'Bó hoa vàng tươi vui', 320000, 280000, 65, FALSE, 'active'),
(2, 'Giỏ Hoa 8/3 Trắng Hồng', 'gio-hoa-8-3-trang-hong', 'SP16', 'Giỏ hoa trắng hồng thanh lịch', 420000, 370000, 48, FALSE, 'active'),
(2, 'Bó Hoa 8/3 Mix Nhiều Màu', 'bo-hoa-8-3-mix-nhieu-mau', 'SP17', 'Bó hoa mix nhiều màu rực rỡ', 400000, 350000, 52, FALSE, 'active'),
(2, 'Lẵng Hoa 8/3 Cao Cấp', 'lang-hoa-8-3-cao-cap', 'SP18', 'Lẵng hoa 8/3 cao cấp, đẹp mắt', 600000, 550000, 25, TRUE, 'active'),

-- Nhóm 3: Hoa Khai Trương (8 sản phẩm)
(3, 'Kệ Hoa Khai Trương Lớn', 'ke-hoa-khai-truong-lon', 'SP19', 'Kệ hoa khai trương sang trọng, kích thước lớn', 2000000, 1800000, 20, TRUE, 'active'),
(3, 'Kệ Hoa Khai Trương Vàng', 'ke-hoa-khai-truong-vang', 'SP20', 'Kệ hoa khai trương màu vàng rực rỡ', 1800000, 1650000, 22, TRUE, 'active'),
(3, 'Lẵng Hoa Khai Trương', 'lang-hoa-khai-truong', 'SP21', 'Lẵng hoa khai trương đẹp mắt', 1200000, 1100000, 30, FALSE, 'active'),
(3, 'Kệ Hoa Khai Trương Mix', 'ke-hoa-khai-truong-mix', 'SP22', 'Kệ hoa khai trương mix nhiều màu', 1900000, 1750000, 18, TRUE, 'active'),
(3, 'Giỏ Hoa Khai Trương', 'gio-hoa-khai-truong', 'SP23', 'Giỏ hoa khai trương sang trọng', 1000000, 900000, 35, FALSE, 'active'),
(3, 'Kệ Hoa Khai Trương Đỏ Vàng', 'ke-hoa-khai-truong-do-vang', 'SP24', 'Kệ hoa khai trương đỏ vàng nổi bật', 2100000, 1950000, 15, TRUE, 'active'),
(3, 'Lẵng Hoa Khai Trương Lớn', 'lang-hoa-khai-truong-lon', 'SP25', 'Lẵng hoa khai trương kích thước lớn', 1500000, 1400000, 25, FALSE, 'active'),
(3, 'Kệ Hoa Khai Trương Đặc Biệt', 'ke-hoa-khai-truong-dac-biet', 'SP26', 'Kệ hoa khai trương đặc biệt, ấn tượng', 2500000, 2300000, 12, TRUE, 'active'),

-- Nhóm 4: Hoa Tốt Nghiệp (5 sản phẩm)
(4, 'Bó Hoa Tốt Nghiệp Mix', 'bo-hoa-tot-nghiep-mix', 'SP27', 'Bó hoa chúc mừng tốt nghiệp', 450000, 400000, 35, FALSE, 'active'),
(4, 'Giỏ Hoa Tốt Nghiệp', 'gio-hoa-tot-nghiep', 'SP28', 'Giỏ hoa tốt nghiệp đẹp mắt', 500000, 450000, 32, FALSE, 'active'),
(4, 'Bó Hoa Tốt Nghiệp Vàng', 'bo-hoa-tot-nghiep-vang', 'SP29', 'Bó hoa vàng chúc mừng tốt nghiệp', 420000, 380000, 38, FALSE, 'active'),
(4, 'Lẵng Hoa Tốt Nghiệp', 'lang-hoa-tot-nghiep', 'SP30', 'Lẵng hoa tốt nghiệp sang trọng', 600000, 550000, 28, TRUE, 'active'),
(4, 'Bó Hoa Tốt Nghiệp Đặc Biệt', 'bo-hoa-tot-nghiep-dac-biet', 'SP31', 'Bó hoa tốt nghiệp đặc biệt', 550000, 500000, 30, FALSE, 'active'),

-- Nhóm 5: Hoa Chia Buồn (5 sản phẩm)
(5, 'Kệ Hoa Chia Buồn Trắng', 'ke-hoa-chia-buon-trang', 'SP32', 'Kệ hoa chia buồn màu trắng', 1500000, NULL, 25, FALSE, 'active'),
(5, 'Kệ Hoa Chia Buồn Trắng Vàng', 'ke-hoa-chia-buon-trang-vang', 'SP33', 'Kệ hoa chia buồn trắng vàng', 1600000, NULL, 22, FALSE, 'active'),
(5, 'Giỏ Hoa Chia Buồn', 'gio-hoa-chia-buon', 'SP34', 'Giỏ hoa chia buồn trang trọng', 1200000, NULL, 30, FALSE, 'active'),
(5, 'Kệ Hoa Chia Buồn Lớn', 'ke-hoa-chia-buon-lon', 'SP35', 'Kệ hoa chia buồn kích thước lớn', 1800000, NULL, 18, FALSE, 'active'),
(5, 'Lẵng Hoa Chia Buồn', 'lang-hoa-chia-buon', 'SP36', 'Lẵng hoa chia buồn thanh lịch', 1400000, NULL, 28, FALSE, 'active'),

-- Nhóm 6: Bó Hoa (7 sản phẩm)
(6, 'Bó Hoa Hồng Trắng', 'bo-hoa-hong-trang', 'SP37', 'Bó hoa hồng trắng tinh khôi', 400000, NULL, 40, FALSE, 'active'),
(6, 'Bó Hoa Hồng Đỏ', 'bo-hoa-hong-do', 'SP38', 'Bó hoa hồng đỏ tươi thắm', 450000, 400000, 45, TRUE, 'active'),
(6, 'Bó Hoa Hồng Hồng', 'bo-hoa-hong-hong', 'SP39', 'Bó hoa hồng màu hồng ngọt ngào', 420000, 380000, 42, FALSE, 'active'),
(6, 'Bó Hoa Mix Nhiều Màu', 'bo-hoa-mix-nhieu-mau', 'SP40', 'Bó hoa mix nhiều màu rực rỡ', 480000, 430000, 38, FALSE, 'active'),
(6, 'Bó Hoa Hồng Vàng', 'bo-hoa-hong-vang', 'SP41', 'Bó hoa hồng vàng tươi vui', 430000, 390000, 40, FALSE, 'active'),
(6, 'Bó Hoa Đỏ Trắng', 'bo-hoa-do-trang', 'SP42', 'Bó hoa kết hợp đỏ trắng', 460000, 420000, 36, FALSE, 'active'),
(6, 'Bó Hoa Đặc Biệt', 'bo-hoa-dac-biet', 'SP43', 'Bó hoa đặc biệt với thiết kế độc đáo', 550000, 500000, 30, TRUE, 'active'),

-- Nhóm 7: Hoa Lan Hồ Điệp (7 sản phẩm)
(7, 'Hoa Lan Hồ Điệp Trắng', 'hoa-lan-ho-diep-trang', 'SP44', 'Chậu lan hồ điệp trắng cao cấp', 800000, 750000, 15, TRUE, 'active'),
(7, 'Hoa Lan Hồ Điệp Hồng', 'hoa-lan-ho-diep-hong', 'SP45', 'Chậu lan hồ điệp hồng đẹp mắt', 850000, 800000, 12, TRUE, 'active'),
(7, 'Hoa Lan Hồ Điệp Vàng', 'hoa-lan-ho-diep-vang', 'SP46', 'Chậu lan hồ điệp vàng rực rỡ', 820000, 770000, 14, FALSE, 'active'),
(7, 'Hoa Lan Hồ Điệp Tím', 'hoa-lan-ho-diep-tim', 'SP47', 'Chậu lan hồ điệp tím thanh lịch', 880000, 830000, 10, TRUE, 'active'),
(7, 'Hoa Lan Hồ Điệp Mix', 'hoa-lan-ho-diep-mix', 'SP48', 'Chậu lan hồ điệp mix nhiều màu', 900000, 850000, 8, TRUE, 'active'),
(7, 'Hoa Lan Hồ Điệp Đỏ', 'hoa-lan-ho-diep-do', 'SP49', 'Chậu lan hồ điệp đỏ nổi bật', 870000, 820000, 11, FALSE, 'active'),
(7, 'Hoa Lan Hồ Điệp Đặc Biệt', 'hoa-lan-ho-diep-dac-biet', 'SP50', 'Chậu lan hồ điệp đặc biệt cao cấp', 1200000, 1100000, 5, TRUE, 'active');

-- ============================================
-- Hình ảnh sản phẩm (1 ảnh chính + 3-5 ảnh bổ sung mỗi sản phẩm)
-- ============================================

-- Sản phẩm 1-10: Hoa Sinh Nhật
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(1, '/assets/images/products/hoa1.png', TRUE, 0),
(1, '/assets/images/products/hoa2.png', FALSE, 1),
(1, '/assets/images/products/hoa3.jpg', FALSE, 2),
(1, '/assets/images/products/hoa4.jpg', FALSE, 3),
(1, '/assets/images/products/hoa5.jpg', FALSE, 4),

(2, '/assets/images/products/hoa2.png', TRUE, 0),
(2, '/assets/images/products/hoa1.png', FALSE, 1),
(2, '/assets/images/products/hoa3.jpg', FALSE, 2),
(2, '/assets/images/products/hoa4.jpg', FALSE, 3),
(2, '/assets/images/products/hoa5.jpg', FALSE, 4),

(3, '/assets/images/products/hoa3.jpg', TRUE, 0),
(3, '/assets/images/products/hoa1.png', FALSE, 1),
(3, '/assets/images/products/hoa2.png', FALSE, 2),
(3, '/assets/images/products/hoa4.jpg', FALSE, 3),
(3, '/assets/images/products/hoa5.jpg', FALSE, 4),

(4, '/assets/images/products/hoa4.jpg', TRUE, 0),
(4, '/assets/images/products/hoa1.png', FALSE, 1),
(4, '/assets/images/products/hoa2.png', FALSE, 2),
(4, '/assets/images/products/hoa3.jpg', FALSE, 3),

(5, '/assets/images/products/hoa5.jpg', TRUE, 0),
(5, '/assets/images/products/hoa1.png', FALSE, 1),
(5, '/assets/images/products/hoa2.png', FALSE, 2),
(5, '/assets/images/products/hoa3.jpg', FALSE, 3),
(5, '/assets/images/products/hoa4.jpg', FALSE, 4),

(6, '/assets/images/products/hoa1.png', TRUE, 0),
(6, '/assets/images/products/hoa2.png', FALSE, 1),
(6, '/assets/images/products/hoa3.jpg', FALSE, 2),
(6, '/assets/images/products/hoa4.jpg', FALSE, 3),
(6, '/assets/images/products/hoa5.jpg', FALSE, 4),

(7, '/assets/images/products/hoa2.png', TRUE, 0),
(7, '/assets/images/products/hoa1.png', FALSE, 1),
(7, '/assets/images/products/hoa3.jpg', FALSE, 2),
(7, '/assets/images/products/hoa4.jpg', FALSE, 3),

(8, '/assets/images/products/hoa3.jpg', TRUE, 0),
(8, '/assets/images/products/hoa1.png', FALSE, 1),
(8, '/assets/images/products/hoa2.png', FALSE, 2),
(8, '/assets/images/products/hoa4.jpg', FALSE, 3),
(8, '/assets/images/products/hoa5.jpg', FALSE, 4),

(9, '/assets/images/products/hoa4.jpg', TRUE, 0),
(9, '/assets/images/products/hoa1.png', FALSE, 1),
(9, '/assets/images/products/hoa2.png', FALSE, 2),
(9, '/assets/images/products/hoa3.jpg', FALSE, 3),

(10, '/assets/images/products/hoa5.jpg', TRUE, 0),
(10, '/assets/images/products/hoa1.png', FALSE, 1),
(10, '/assets/images/products/hoa2.png', FALSE, 2),
(10, '/assets/images/products/hoa3.jpg', FALSE, 3),
(10, '/assets/images/products/hoa4.jpg', FALSE, 4);

-- Sản phẩm 11-18: Hoa 8/3
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(11, '/assets/images/products/hoa1.png', TRUE, 0),
(11, '/assets/images/products/hoa2.png', FALSE, 1),
(11, '/assets/images/products/hoa3.jpg', FALSE, 2),
(11, '/assets/images/products/hoa4.jpg', FALSE, 3),

(12, '/assets/images/products/hoa2.png', TRUE, 0),
(12, '/assets/images/products/hoa1.png', FALSE, 1),
(12, '/assets/images/products/hoa3.jpg', FALSE, 2),
(12, '/assets/images/products/hoa4.jpg', FALSE, 3),
(12, '/assets/images/products/hoa5.jpg', FALSE, 4),

(13, '/assets/images/products/hoa3.jpg', TRUE, 0),
(13, '/assets/images/products/hoa1.png', FALSE, 1),
(13, '/assets/images/products/hoa2.png', FALSE, 2),
(13, '/assets/images/products/hoa4.jpg', FALSE, 3),

(14, '/assets/images/products/hoa4.jpg', TRUE, 0),
(14, '/assets/images/products/hoa1.png', FALSE, 1),
(14, '/assets/images/products/hoa2.png', FALSE, 2),
(14, '/assets/images/products/hoa3.jpg', FALSE, 3),
(14, '/assets/images/products/hoa5.jpg', FALSE, 4),

(15, '/assets/images/products/hoa5.jpg', TRUE, 0),
(15, '/assets/images/products/hoa1.png', FALSE, 1),
(15, '/assets/images/products/hoa2.png', FALSE, 2),
(15, '/assets/images/products/hoa3.jpg', FALSE, 3),

(16, '/assets/images/products/hoa1.png', TRUE, 0),
(16, '/assets/images/products/hoa2.png', FALSE, 1),
(16, '/assets/images/products/hoa3.jpg', FALSE, 2),
(16, '/assets/images/products/hoa4.jpg', FALSE, 3),
(16, '/assets/images/products/hoa5.jpg', FALSE, 4),

(17, '/assets/images/products/hoa2.png', TRUE, 0),
(17, '/assets/images/products/hoa1.png', FALSE, 1),
(17, '/assets/images/products/hoa3.jpg', FALSE, 2),
(17, '/assets/images/products/hoa4.jpg', FALSE, 3),

(18, '/assets/images/products/hoa3.jpg', TRUE, 0),
(18, '/assets/images/products/hoa1.png', FALSE, 1),
(18, '/assets/images/products/hoa2.png', FALSE, 2),
(18, '/assets/images/products/hoa4.jpg', FALSE, 3),
(18, '/assets/images/products/hoa5.jpg', FALSE, 4);

-- Sản phẩm 19-26: Hoa Khai Trương
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(19, '/assets/images/products/hoa4.jpg', TRUE, 0),
(19, '/assets/images/products/hoa1.png', FALSE, 1),
(19, '/assets/images/products/hoa2.png', FALSE, 2),
(19, '/assets/images/products/hoa3.jpg', FALSE, 3),
(19, '/assets/images/products/hoa5.jpg', FALSE, 4),

(20, '/assets/images/products/hoa5.jpg', TRUE, 0),
(20, '/assets/images/products/hoa1.png', FALSE, 1),
(20, '/assets/images/products/hoa2.png', FALSE, 2),
(20, '/assets/images/products/hoa3.jpg', FALSE, 3),

(21, '/assets/images/products/hoa1.png', TRUE, 0),
(21, '/assets/images/products/hoa2.png', FALSE, 1),
(21, '/assets/images/products/hoa3.jpg', FALSE, 2),
(21, '/assets/images/products/hoa4.jpg', FALSE, 3),
(21, '/assets/images/products/hoa5.jpg', FALSE, 4),

(22, '/assets/images/products/hoa2.png', TRUE, 0),
(22, '/assets/images/products/hoa1.png', FALSE, 1),
(22, '/assets/images/products/hoa3.jpg', FALSE, 2),
(22, '/assets/images/products/hoa4.jpg', FALSE, 3),

(23, '/assets/images/products/hoa3.jpg', TRUE, 0),
(23, '/assets/images/products/hoa1.png', FALSE, 1),
(23, '/assets/images/products/hoa2.png', FALSE, 2),
(23, '/assets/images/products/hoa4.jpg', FALSE, 3),
(23, '/assets/images/products/hoa5.jpg', FALSE, 4),

(24, '/assets/images/products/hoa4.jpg', TRUE, 0),
(24, '/assets/images/products/hoa1.png', FALSE, 1),
(24, '/assets/images/products/hoa2.png', FALSE, 2),
(24, '/assets/images/products/hoa3.jpg', FALSE, 3),

(25, '/assets/images/products/hoa5.jpg', TRUE, 0),
(25, '/assets/images/products/hoa1.png', FALSE, 1),
(25, '/assets/images/products/hoa2.png', FALSE, 2),
(25, '/assets/images/products/hoa3.jpg', FALSE, 3),
(25, '/assets/images/products/hoa4.jpg', FALSE, 4),

(26, '/assets/images/products/hoa1.png', TRUE, 0),
(26, '/assets/images/products/hoa2.png', FALSE, 1),
(26, '/assets/images/products/hoa3.jpg', FALSE, 2),
(26, '/assets/images/products/hoa4.jpg', FALSE, 3),
(26, '/assets/images/products/hoa5.jpg', FALSE, 4);

-- Sản phẩm 27-31: Hoa Tốt Nghiệp
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(27, '/assets/images/products/hoa2.png', TRUE, 0),
(27, '/assets/images/products/hoa1.png', FALSE, 1),
(27, '/assets/images/products/hoa3.jpg', FALSE, 2),
(27, '/assets/images/products/hoa4.jpg', FALSE, 3),

(28, '/assets/images/products/hoa3.jpg', TRUE, 0),
(28, '/assets/images/products/hoa1.png', FALSE, 1),
(28, '/assets/images/products/hoa2.png', FALSE, 2),
(28, '/assets/images/products/hoa4.jpg', FALSE, 3),
(28, '/assets/images/products/hoa5.jpg', FALSE, 4),

(29, '/assets/images/products/hoa4.jpg', TRUE, 0),
(29, '/assets/images/products/hoa1.png', FALSE, 1),
(29, '/assets/images/products/hoa2.png', FALSE, 2),
(29, '/assets/images/products/hoa3.jpg', FALSE, 3),

(30, '/assets/images/products/hoa5.jpg', TRUE, 0),
(30, '/assets/images/products/hoa1.png', FALSE, 1),
(30, '/assets/images/products/hoa2.png', FALSE, 2),
(30, '/assets/images/products/hoa3.jpg', FALSE, 3),
(30, '/assets/images/products/hoa4.jpg', FALSE, 4),

(31, '/assets/images/products/hoa1.png', TRUE, 0),
(31, '/assets/images/products/hoa2.png', FALSE, 1),
(31, '/assets/images/products/hoa3.jpg', FALSE, 2),
(31, '/assets/images/products/hoa4.jpg', FALSE, 3);

-- Sản phẩm 32-36: Hoa Chia Buồn
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(32, '/assets/images/products/hoa2.png', TRUE, 0),
(32, '/assets/images/products/hoa1.png', FALSE, 1),
(32, '/assets/images/products/hoa3.jpg', FALSE, 2),
(32, '/assets/images/products/hoa4.jpg', FALSE, 3),
(32, '/assets/images/products/hoa5.jpg', FALSE, 4),

(33, '/assets/images/products/hoa3.jpg', TRUE, 0),
(33, '/assets/images/products/hoa1.png', FALSE, 1),
(33, '/assets/images/products/hoa2.png', FALSE, 2),
(33, '/assets/images/products/hoa4.jpg', FALSE, 3),

(34, '/assets/images/products/hoa4.jpg', TRUE, 0),
(34, '/assets/images/products/hoa1.png', FALSE, 1),
(34, '/assets/images/products/hoa2.png', FALSE, 2),
(34, '/assets/images/products/hoa3.jpg', FALSE, 3),
(34, '/assets/images/products/hoa5.jpg', FALSE, 4),

(35, '/assets/images/products/hoa5.jpg', TRUE, 0),
(35, '/assets/images/products/hoa1.png', FALSE, 1),
(35, '/assets/images/products/hoa2.png', FALSE, 2),
(35, '/assets/images/products/hoa3.jpg', FALSE, 3),

(36, '/assets/images/products/hoa1.png', TRUE, 0),
(36, '/assets/images/products/hoa2.png', FALSE, 1),
(36, '/assets/images/products/hoa3.jpg', FALSE, 2),
(36, '/assets/images/products/hoa4.jpg', FALSE, 3),
(36, '/assets/images/products/hoa5.jpg', FALSE, 4);

-- Sản phẩm 37-43: Bó Hoa
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(37, '/assets/images/products/hoa2.png', TRUE, 0),
(37, '/assets/images/products/hoa1.png', FALSE, 1),
(37, '/assets/images/products/hoa3.jpg', FALSE, 2),
(37, '/assets/images/products/hoa4.jpg', FALSE, 3),

(38, '/assets/images/products/hoa3.jpg', TRUE, 0),
(38, '/assets/images/products/hoa1.png', FALSE, 1),
(38, '/assets/images/products/hoa2.png', FALSE, 2),
(38, '/assets/images/products/hoa4.jpg', FALSE, 3),
(38, '/assets/images/products/hoa5.jpg', FALSE, 4),

(39, '/assets/images/products/hoa4.jpg', TRUE, 0),
(39, '/assets/images/products/hoa1.png', FALSE, 1),
(39, '/assets/images/products/hoa2.png', FALSE, 2),
(39, '/assets/images/products/hoa3.jpg', FALSE, 3),

(40, '/assets/images/products/hoa5.jpg', TRUE, 0),
(40, '/assets/images/products/hoa1.png', FALSE, 1),
(40, '/assets/images/products/hoa2.png', FALSE, 2),
(40, '/assets/images/products/hoa3.jpg', FALSE, 3),
(40, '/assets/images/products/hoa4.jpg', FALSE, 4),

(41, '/assets/images/products/hoa1.png', TRUE, 0),
(41, '/assets/images/products/hoa2.png', FALSE, 1),
(41, '/assets/images/products/hoa3.jpg', FALSE, 2),
(41, '/assets/images/products/hoa4.jpg', FALSE, 3),

(42, '/assets/images/products/hoa2.png', TRUE, 0),
(42, '/assets/images/products/hoa1.png', FALSE, 1),
(42, '/assets/images/products/hoa3.jpg', FALSE, 2),
(42, '/assets/images/products/hoa4.jpg', FALSE, 3),
(42, '/assets/images/products/hoa5.jpg', FALSE, 4),

(43, '/assets/images/products/hoa3.jpg', TRUE, 0),
(43, '/assets/images/products/hoa1.png', FALSE, 1),
(43, '/assets/images/products/hoa2.png', FALSE, 2),
(43, '/assets/images/products/hoa4.jpg', FALSE, 3);

-- Sản phẩm 44-50: Hoa Lan Hồ Điệp
INSERT INTO product_images (product_id, image_url, is_primary, display_order) VALUES
(44, '/assets/images/products/hoa4.jpg', TRUE, 0),
(44, '/assets/images/products/hoa1.png', FALSE, 1),
(44, '/assets/images/products/hoa2.png', FALSE, 2),
(44, '/assets/images/products/hoa3.jpg', FALSE, 3),
(44, '/assets/images/products/hoa5.jpg', FALSE, 4),

(45, '/assets/images/products/hoa5.jpg', TRUE, 0),
(45, '/assets/images/products/hoa1.png', FALSE, 1),
(45, '/assets/images/products/hoa2.png', FALSE, 2),
(45, '/assets/images/products/hoa3.jpg', FALSE, 3),

(46, '/assets/images/products/hoa1.png', TRUE, 0),
(46, '/assets/images/products/hoa2.png', FALSE, 1),
(46, '/assets/images/products/hoa3.jpg', FALSE, 2),
(46, '/assets/images/products/hoa4.jpg', FALSE, 3),
(46, '/assets/images/products/hoa5.jpg', FALSE, 4),

(47, '/assets/images/products/hoa2.png', TRUE, 0),
(47, '/assets/images/products/hoa1.png', FALSE, 1),
(47, '/assets/images/products/hoa3.jpg', FALSE, 2),
(47, '/assets/images/products/hoa4.jpg', FALSE, 3),

(48, '/assets/images/products/hoa3.jpg', TRUE, 0),
(48, '/assets/images/products/hoa1.png', FALSE, 1),
(48, '/assets/images/products/hoa2.png', FALSE, 2),
(48, '/assets/images/products/hoa4.jpg', FALSE, 3),
(48, '/assets/images/products/hoa5.jpg', FALSE, 4),

(49, '/assets/images/products/hoa4.jpg', TRUE, 0),
(49, '/assets/images/products/hoa1.png', FALSE, 1),
(49, '/assets/images/products/hoa2.png', FALSE, 2),
(49, '/assets/images/products/hoa3.jpg', FALSE, 3),

(50, '/assets/images/products/hoa5.jpg', TRUE, 0),
(50, '/assets/images/products/hoa1.png', FALSE, 1),
(50, '/assets/images/products/hoa2.png', FALSE, 2),
(50, '/assets/images/products/hoa3.jpg', FALSE, 3),
(50, '/assets/images/products/hoa4.jpg', FALSE, 4);

-- ============================================
-- Thuộc tính sản phẩm (product_attributes)
-- ============================================

-- Sản phẩm 1-10: Hoa Sinh Nhật
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(1, 'Loại hoa', 'Hồng đỏ, Baby trắng, Lá phụ'),
(1, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(1, 'Màu sắc', 'Đỏ chủ đạo'),
(1, 'Dịp sử dụng', 'Sinh nhật, Kỷ niệm, Tặng người yêu'),
(1, 'Bao bì', 'Giấy kraft cao cấp, ruy băng lụa'),
(1, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(2, 'Loại hoa', 'Mix nhiều loại hoa tươi'),
(2, 'Kích thước', 'Cao 45cm x Rộng 35cm'),
(2, 'Màu sắc', 'Nhiều màu rực rỡ'),
(2, 'Dịp sử dụng', 'Sinh nhật, Chúc mừng'),
(2, 'Bao bì', 'Giỏ mây, giấy bọc cao cấp'),
(2, 'Hoa tươi', '100% hoa tươi'),

(3, 'Loại hoa', 'Hồng hồng, Baby breath, Lá xanh'),
(3, 'Kích thước', 'Cao 55cm x Rộng 45cm'),
(3, 'Màu sắc', 'Hồng ngọt ngào'),
(3, 'Dịp sử dụng', 'Sinh nhật, Tặng bạn gái'),
(3, 'Bao bì', 'Lẵng mây, ruy băng hồng'),
(3, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(4, 'Loại hoa', 'Hồng trắng, Baby breath'),
(4, 'Kích thước', 'Cao 48cm x Rộng 38cm'),
(4, 'Màu sắc', 'Trắng tinh khôi'),
(4, 'Dịp sử dụng', 'Sinh nhật, Tặng mẹ'),
(4, 'Bao bì', 'Giấy trắng cao cấp, ruy băng trắng'),
(4, 'Hoa tươi', '100% hoa tươi'),

(5, 'Loại hoa', 'Hoa vàng, Baby breath, Lá xanh'),
(5, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(5, 'Màu sắc', 'Vàng rực rỡ'),
(5, 'Dịp sử dụng', 'Sinh nhật, Chúc mừng'),
(5, 'Bao bì', 'Giỏ mây, giấy vàng'),
(5, 'Hoa tươi', '100% hoa tươi'),

(6, 'Loại hoa', 'Hồng đỏ lớn, Baby breath, Lá phụ'),
(6, 'Kích thước', 'Cao 60cm x Rộng 50cm'),
(6, 'Màu sắc', 'Đỏ nổi bật'),
(6, 'Dịp sử dụng', 'Sinh nhật đặc biệt, Kỷ niệm'),
(6, 'Bao bì', 'Giấy kraft cao cấp, ruy băng đỏ'),
(6, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(7, 'Loại hoa', 'Mix nhiều loại hoa'),
(7, 'Kích thước', 'Cao 52cm x Rộng 42cm'),
(7, 'Màu sắc', 'Đa dạng màu sắc'),
(7, 'Dịp sử dụng', 'Sinh nhật, Chúc mừng'),
(7, 'Bao bì', 'Lẵng mây, giấy bọc đẹp'),
(7, 'Hoa tươi', '100% hoa tươi'),

(8, 'Loại hoa', 'Hồng hồng, Baby breath'),
(8, 'Kích thước', 'Cao 46cm x Rộng 36cm'),
(8, 'Màu sắc', 'Hồng ngọt ngào'),
(8, 'Dịp sử dụng', 'Sinh nhật, Tặng người yêu'),
(8, 'Bao bì', 'Giấy hồng, ruy băng lụa'),
(8, 'Hoa tươi', '100% hoa tươi'),

(9, 'Loại hoa', 'Hồng đỏ, Hồng trắng, Baby breath'),
(9, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(9, 'Màu sắc', 'Đỏ và trắng hài hòa'),
(9, 'Dịp sử dụng', 'Sinh nhật, Kỷ niệm'),
(9, 'Bao bì', 'Giỏ mây, giấy bọc cao cấp'),
(9, 'Hoa tươi', '100% hoa tươi'),

(10, 'Loại hoa', 'Mix cao cấp nhiều loại'),
(10, 'Kích thước', 'Cao 65cm x Rộng 55cm'),
(10, 'Màu sắc', 'Nhiều màu đặc biệt'),
(10, 'Dịp sử dụng', 'Sinh nhật đặc biệt, Kỷ niệm quan trọng'),
(10, 'Bao bì', 'Bao bì cao cấp, ruy băng lụa'),
(10, 'Hoa tươi', '100% hoa tươi nhập khẩu cao cấp');

-- Sản phẩm 11-18: Hoa 8/3
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(11, 'Loại hoa', 'Hồng đỏ, Baby breath, Lá xanh'),
(11, 'Kích thước', 'Cao 45cm x Rộng 35cm'),
(11, 'Màu sắc', 'Đỏ và hồng'),
(11, 'Dịp sử dụng', 'Ngày 8/3, Tặng phụ nữ'),
(11, 'Bao bì', 'Giấy đỏ, ruy băng lụa'),
(11, 'Hoa tươi', '100% hoa tươi'),

(12, 'Loại hoa', 'Mix nhiều loại hoa'),
(12, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(12, 'Màu sắc', 'Nhiều màu rực rỡ'),
(12, 'Dịp sử dụng', 'Ngày 8/3, Chúc mừng'),
(12, 'Bao bì', 'Giỏ mây, giấy bọc đẹp'),
(12, 'Hoa tươi', '100% hoa tươi'),

(13, 'Loại hoa', 'Hồng hồng, Baby breath'),
(13, 'Kích thước', 'Cao 48cm x Rộng 38cm'),
(13, 'Màu sắc', 'Hồng ngọt ngào'),
(13, 'Dịp sử dụng', 'Ngày 8/3, Tặng bạn gái'),
(13, 'Bao bì', 'Giấy hồng, ruy băng'),
(13, 'Hoa tươi', '100% hoa tươi'),

(14, 'Loại hoa', 'Mix cao cấp'),
(14, 'Kích thước', 'Cao 55cm x Rộng 45cm'),
(14, 'Màu sắc', 'Nhiều màu đẹp mắt'),
(14, 'Dịp sử dụng', 'Ngày 8/3 đặc biệt'),
(14, 'Bao bì', 'Lẵng mây cao cấp'),
(14, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(15, 'Loại hoa', 'Hoa vàng, Baby breath'),
(15, 'Kích thước', 'Cao 46cm x Rộng 36cm'),
(15, 'Màu sắc', 'Vàng tươi vui'),
(15, 'Dịp sử dụng', 'Ngày 8/3, Chúc mừng'),
(15, 'Bao bì', 'Giấy vàng, ruy băng'),
(15, 'Hoa tươi', '100% hoa tươi'),

(16, 'Loại hoa', 'Hồng trắng, Hồng hồng'),
(16, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(16, 'Màu sắc', 'Trắng và hồng'),
(16, 'Dịp sử dụng', 'Ngày 8/3, Tặng mẹ'),
(16, 'Bao bì', 'Giỏ mây, giấy bọc'),
(16, 'Hoa tươi', '100% hoa tươi'),

(17, 'Loại hoa', 'Mix nhiều màu'),
(17, 'Kích thước', 'Cao 48cm x Rộng 38cm'),
(17, 'Màu sắc', 'Nhiều màu rực rỡ'),
(17, 'Dịp sử dụng', 'Ngày 8/3, Chúc mừng'),
(17, 'Bao bì', 'Giấy bọc đẹp'),
(17, 'Hoa tươi', '100% hoa tươi'),

(18, 'Loại hoa', 'Mix cao cấp đặc biệt'),
(18, 'Kích thước', 'Cao 58cm x Rộng 48cm'),
(18, 'Màu sắc', 'Nhiều màu sang trọng'),
(18, 'Dịp sử dụng', 'Ngày 8/3 cao cấp'),
(18, 'Bao bì', 'Lẵng cao cấp, ruy băng lụa'),
(18, 'Hoa tươi', '100% hoa tươi nhập khẩu');

-- Sản phẩm 19-26: Hoa Khai Trương
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(19, 'Loại hoa', 'Mix nhiều loại hoa lớn'),
(19, 'Kích thước', 'Cao 150cm x Rộng 100cm'),
(19, 'Màu sắc', 'Nhiều màu nổi bật'),
(19, 'Dịp sử dụng', 'Khai trương, Khánh thành'),
(19, 'Bao bì', 'Kệ hoa chuyên dụng'),
(19, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(20, 'Loại hoa', 'Hoa vàng, Hoa cam, Lá xanh'),
(20, 'Kích thước', 'Cao 140cm x Rộng 90cm'),
(20, 'Màu sắc', 'Vàng và cam rực rỡ'),
(20, 'Dịp sử dụng', 'Khai trương, Chúc mừng'),
(20, 'Bao bì', 'Kệ hoa vàng'),
(20, 'Hoa tươi', '100% hoa tươi'),

(21, 'Loại hoa', 'Mix hoa tươi'),
(21, 'Kích thước', 'Cao 80cm x Rộng 60cm'),
(21, 'Màu sắc', 'Nhiều màu'),
(21, 'Dịp sử dụng', 'Khai trương'),
(21, 'Bao bì', 'Lẵng mây lớn'),
(21, 'Hoa tươi', '100% hoa tươi'),

(22, 'Loại hoa', 'Mix đa dạng'),
(22, 'Kích thước', 'Cao 145cm x Rộng 95cm'),
(22, 'Màu sắc', 'Nhiều màu đẹp'),
(22, 'Dịp sử dụng', 'Khai trương, Khánh thành'),
(22, 'Bao bì', 'Kệ hoa mix'),
(22, 'Hoa tươi', '100% hoa tươi'),

(23, 'Loại hoa', 'Mix hoa tươi'),
(23, 'Kích thước', 'Cao 70cm x Rộng 50cm'),
(23, 'Màu sắc', 'Nhiều màu'),
(23, 'Dịp sử dụng', 'Khai trương'),
(23, 'Bao bì', 'Giỏ mây lớn'),
(23, 'Hoa tươi', '100% hoa tươi'),

(24, 'Loại hoa', 'Hoa đỏ, Hoa vàng'),
(24, 'Kích thước', 'Cao 155cm x Rộng 105cm'),
(24, 'Màu sắc', 'Đỏ và vàng nổi bật'),
(24, 'Dịp sử dụng', 'Khai trương lớn'),
(24, 'Bao bì', 'Kệ hoa đỏ vàng'),
(24, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(25, 'Loại hoa', 'Mix hoa tươi lớn'),
(25, 'Kích thước', 'Cao 90cm x Rộng 70cm'),
(25, 'Màu sắc', 'Nhiều màu'),
(25, 'Dịp sử dụng', 'Khai trương'),
(25, 'Bao bì', 'Lẵng lớn'),
(25, 'Hoa tươi', '100% hoa tươi'),

(26, 'Loại hoa', 'Mix cao cấp đặc biệt'),
(26, 'Kích thước', 'Cao 180cm x Rộng 120cm'),
(26, 'Màu sắc', 'Nhiều màu sang trọng'),
(26, 'Dịp sử dụng', 'Khai trương đặc biệt'),
(26, 'Bao bì', 'Kệ hoa cao cấp'),
(26, 'Hoa tươi', '100% hoa tươi nhập khẩu cao cấp');

-- Sản phẩm 27-31: Hoa Tốt Nghiệp
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(27, 'Loại hoa', 'Mix nhiều loại hoa'),
(27, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(27, 'Màu sắc', 'Nhiều màu rực rỡ'),
(27, 'Dịp sử dụng', 'Tốt nghiệp, Chúc mừng'),
(27, 'Bao bì', 'Giấy bọc đẹp'),
(27, 'Hoa tươi', '100% hoa tươi'),

(28, 'Loại hoa', 'Mix hoa tươi'),
(28, 'Kích thước', 'Cao 55cm x Rộng 45cm'),
(28, 'Màu sắc', 'Nhiều màu'),
(28, 'Dịp sử dụng', 'Tốt nghiệp'),
(28, 'Bao bì', 'Giỏ mây'),
(28, 'Hoa tươi', '100% hoa tươi'),

(29, 'Loại hoa', 'Hoa vàng, Baby breath'),
(29, 'Kích thước', 'Cao 48cm x Rộng 38cm'),
(29, 'Màu sắc', 'Vàng tươi vui'),
(29, 'Dịp sử dụng', 'Tốt nghiệp, Chúc mừng'),
(29, 'Bao bì', 'Giấy vàng'),
(29, 'Hoa tươi', '100% hoa tươi'),

(30, 'Loại hoa', 'Mix cao cấp'),
(30, 'Kích thước', 'Cao 60cm x Rộng 50cm'),
(30, 'Màu sắc', 'Nhiều màu đẹp'),
(30, 'Dịp sử dụng', 'Tốt nghiệp đặc biệt'),
(30, 'Bao bì', 'Lẵng mây cao cấp'),
(30, 'Hoa tươi', '100% hoa tươi nhập khẩu'),

(31, 'Loại hoa', 'Mix đặc biệt'),
(31, 'Kích thước', 'Cao 52cm x Rộng 42cm'),
(31, 'Màu sắc', 'Nhiều màu'),
(31, 'Dịp sử dụng', 'Tốt nghiệp'),
(31, 'Bao bì', 'Giấy bọc đẹp'),
(31, 'Hoa tươi', '100% hoa tươi');

-- Sản phẩm 32-36: Hoa Chia Buồn
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(32, 'Loại hoa', 'Hoa trắng, Lá xanh'),
(32, 'Kích thước', 'Cao 120cm x Rộng 80cm'),
(32, 'Màu sắc', 'Trắng trang trọng'),
(32, 'Dịp sử dụng', 'Chia buồn, Viếng'),
(32, 'Bao bì', 'Kệ hoa trắng'),
(32, 'Hoa tươi', '100% hoa tươi'),

(33, 'Loại hoa', 'Hoa trắng, Hoa vàng'),
(33, 'Kích thước', 'Cao 130cm x Rộng 90cm'),
(33, 'Màu sắc', 'Trắng và vàng'),
(33, 'Dịp sử dụng', 'Chia buồn'),
(33, 'Bao bì', 'Kệ hoa trắng vàng'),
(33, 'Hoa tươi', '100% hoa tươi'),

(34, 'Loại hoa', 'Hoa trắng'),
(34, 'Kích thước', 'Cao 100cm x Rộng 70cm'),
(34, 'Màu sắc', 'Trắng'),
(34, 'Dịp sử dụng', 'Chia buồn'),
(34, 'Bao bì', 'Giỏ mây trắng'),
(34, 'Hoa tươi', '100% hoa tươi'),

(35, 'Loại hoa', 'Hoa trắng lớn'),
(35, 'Kích thước', 'Cao 140cm x Rộng 100cm'),
(35, 'Màu sắc', 'Trắng'),
(35, 'Dịp sử dụng', 'Chia buồn lớn'),
(35, 'Bao bì', 'Kệ hoa lớn'),
(35, 'Hoa tươi', '100% hoa tươi'),

(36, 'Loại hoa', 'Hoa trắng'),
(36, 'Kích thước', 'Cao 110cm x Rộng 80cm'),
(36, 'Màu sắc', 'Trắng'),
(36, 'Dịp sử dụng', 'Chia buồn'),
(36, 'Bao bì', 'Lẵng trắng'),
(36, 'Hoa tươi', '100% hoa tươi');

-- Sản phẩm 37-43: Bó Hoa
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(37, 'Loại hoa', 'Hồng trắng, Baby breath'),
(37, 'Kích thước', 'Cao 45cm x Rộng 35cm'),
(37, 'Màu sắc', 'Trắng tinh khôi'),
(37, 'Dịp sử dụng', 'Tặng quà, Chúc mừng'),
(37, 'Bao bì', 'Giấy trắng, ruy băng'),
(37, 'Hoa tươi', '100% hoa tươi'),

(38, 'Loại hoa', 'Hồng đỏ, Baby breath'),
(38, 'Kích thước', 'Cao 48cm x Rộng 38cm'),
(38, 'Màu sắc', 'Đỏ tươi thắm'),
(38, 'Dịp sử dụng', 'Tặng người yêu, Kỷ niệm'),
(38, 'Bao bì', 'Giấy đỏ, ruy băng lụa'),
(38, 'Hoa tươi', '100% hoa tươi'),

(39, 'Loại hoa', 'Hồng hồng, Baby breath'),
(39, 'Kích thước', 'Cao 46cm x Rộng 36cm'),
(39, 'Màu sắc', 'Hồng ngọt ngào'),
(39, 'Dịp sử dụng', 'Tặng quà, Chúc mừng'),
(39, 'Bao bì', 'Giấy hồng, ruy băng'),
(39, 'Hoa tươi', '100% hoa tươi'),

(40, 'Loại hoa', 'Mix nhiều loại'),
(40, 'Kích thước', 'Cao 50cm x Rộng 40cm'),
(40, 'Màu sắc', 'Nhiều màu rực rỡ'),
(40, 'Dịp sử dụng', 'Tặng quà, Chúc mừng'),
(40, 'Bao bì', 'Giấy bọc đẹp'),
(40, 'Hoa tươi', '100% hoa tươi'),

(41, 'Loại hoa', 'Hồng vàng, Baby breath'),
(41, 'Kích thước', 'Cao 47cm x Rộng 37cm'),
(41, 'Màu sắc', 'Vàng tươi vui'),
(41, 'Dịp sử dụng', 'Tặng quà, Chúc mừng'),
(41, 'Bao bì', 'Giấy vàng, ruy băng'),
(41, 'Hoa tươi', '100% hoa tươi'),

(42, 'Loại hoa', 'Hồng đỏ, Hồng trắng'),
(42, 'Kích thước', 'Cao 49cm x Rộng 39cm'),
(42, 'Màu sắc', 'Đỏ và trắng'),
(42, 'Dịp sử dụng', 'Tặng quà, Kỷ niệm'),
(42, 'Bao bì', 'Giấy đỏ trắng'),
(42, 'Hoa tươi', '100% hoa tươi'),

(43, 'Loại hoa', 'Mix cao cấp'),
(43, 'Kích thước', 'Cao 55cm x Rộng 45cm'),
(43, 'Màu sắc', 'Nhiều màu đẹp'),
(43, 'Dịp sử dụng', 'Tặng quà đặc biệt'),
(43, 'Bao bì', 'Bao bì cao cấp'),
(43, 'Hoa tươi', '100% hoa tươi nhập khẩu');

-- Sản phẩm 44-50: Hoa Lan Hồ Điệp
INSERT INTO product_attributes (product_id, attribute_name, attribute_value) VALUES
(44, 'Loại hoa', 'Lan hồ điệp trắng'),
(44, 'Kích thước', 'Cao 60cm x Rộng 40cm'),
(44, 'Màu sắc', 'Trắng tinh khôi'),
(44, 'Dịp sử dụng', 'Tặng quà cao cấp, Kỷ niệm'),
(44, 'Bao bì', 'Chậu gốm cao cấp'),
(44, 'Hoa tươi', '100% lan hồ điệp nhập khẩu'),

(45, 'Loại hoa', 'Lan hồ điệp hồng'),
(45, 'Kích thước', 'Cao 65cm x Rộng 45cm'),
(45, 'Màu sắc', 'Hồng đẹp mắt'),
(45, 'Dịp sử dụng', 'Tặng quà cao cấp'),
(45, 'Bao bì', 'Chậu gốm hồng'),
(45, 'Hoa tươi', '100% lan hồ điệp nhập khẩu'),

(46, 'Loại hoa', 'Lan hồ điệp vàng'),
(46, 'Kích thước', 'Cao 62cm x Rộng 42cm'),
(46, 'Màu sắc', 'Vàng rực rỡ'),
(46, 'Dịp sử dụng', 'Tặng quà, Chúc mừng'),
(46, 'Bao bì', 'Chậu gốm vàng'),
(46, 'Hoa tươi', '100% lan hồ điệp nhập khẩu'),

(47, 'Loại hoa', 'Lan hồ điệp tím'),
(47, 'Kích thước', 'Cao 63cm x Rộng 43cm'),
(47, 'Màu sắc', 'Tím thanh lịch'),
(47, 'Dịp sử dụng', 'Tặng quà cao cấp'),
(47, 'Bao bì', 'Chậu gốm tím'),
(47, 'Hoa tươi', '100% lan hồ điệp nhập khẩu'),

(48, 'Loại hoa', 'Lan hồ điệp mix'),
(48, 'Kích thước', 'Cao 68cm x Rộng 48cm'),
(48, 'Màu sắc', 'Nhiều màu đẹp'),
(48, 'Dịp sử dụng', 'Tặng quà đặc biệt'),
(48, 'Bao bì', 'Chậu gốm cao cấp'),
(48, 'Hoa tươi', '100% lan hồ điệp nhập khẩu'),

(49, 'Loại hoa', 'Lan hồ điệp đỏ'),
(49, 'Kích thước', 'Cao 64cm x Rộng 44cm'),
(49, 'Màu sắc', 'Đỏ nổi bật'),
(49, 'Dịp sử dụng', 'Tặng quà, Kỷ niệm'),
(49, 'Bao bì', 'Chậu gốm đỏ'),
(49, 'Hoa tươi', '100% lan hồ điệp nhập khẩu'),

(50, 'Loại hoa', 'Lan hồ điệp đặc biệt'),
(50, 'Kích thước', 'Cao 75cm x Rộng 55cm'),
(50, 'Màu sắc', 'Nhiều màu cao cấp'),
(50, 'Dịp sử dụng', 'Tặng quà đặc biệt, Kỷ niệm quan trọng'),
(50, 'Bao bì', 'Chậu gốm cao cấp đặc biệt'),
(50, 'Hoa tươi', '100% lan hồ điệp nhập khẩu cao cấp');

-- Bật lại kiểm tra foreign key
SET FOREIGN_KEY_CHECKS = 1;

