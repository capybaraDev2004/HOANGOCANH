-- Migration: Thêm cột main vào bảng reviews
-- Cột main dùng để đánh dấu review hiển thị trên trang chủ (main = 1)

ALTER TABLE reviews 
ADD COLUMN main BOOLEAN DEFAULT 0 AFTER status;

-- Tạo index cho cột main để tối ưu query
CREATE INDEX idx_main ON reviews(main);

-- Cập nhật comment cho cột
ALTER TABLE reviews 
MODIFY COLUMN main BOOLEAN DEFAULT 0 COMMENT 'Đánh dấu review hiển thị trên trang chủ (1 = hiển thị, 0 = không hiển thị)';
