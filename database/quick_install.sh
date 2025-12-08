#!/bin/bash

echo "============================================"
echo "Cài đặt Database - Hoa Ngọc Anh"
echo "============================================"
echo ""

# Kiểm tra MySQL
if ! command -v mysql &> /dev/null; then
    echo "Lỗi: MySQL chưa được cài đặt hoặc không có trong PATH"
    echo "Vui lòng cài đặt MySQL hoặc sử dụng phpMyAdmin"
    exit 1
fi

# Nhập mật khẩu MySQL
read -sp "Nhập mật khẩu MySQL (Enter nếu không có mật khẩu): " MYSQL_PASS
echo ""

if [ -z "$MYSQL_PASS" ]; then
    echo "Đang tạo database..."
    mysql -u root < create_database.sql
    echo "Đang thêm dữ liệu mẫu..."
    mysql -u root hoa_ngoc_anh < seed_data.sql
else
    echo "Đang tạo database..."
    mysql -u root -p"$MYSQL_PASS" < create_database.sql
    echo "Đang thêm dữ liệu mẫu..."
    mysql -u root -p"$MYSQL_PASS" hoa_ngoc_anh < seed_data.sql
fi

echo ""
echo "============================================"
echo "Hoàn tất!"
echo "============================================"
echo ""
echo "Thông tin đăng nhập Admin:"
echo "Email: admin@hoangocanh.com"
echo "Mật khẩu: 123456"
echo ""

