# Website Bán Hoa - Siin Store Clone

## Mô tả dự án
Website bán hoa tươi với đầy đủ chức năng mua sắm online, xây dựng theo mô hình MVC chuẩn với PHP thuần.

## Cấu trúc dự án

```
├── public/                 # Thư mục public (root web server)
│   ├── index.php          # Entry point
│   ├── assets/            # Tài nguyên tĩnh
│   │   ├── css/          # File CSS
│   │   ├── js/           # File JavaScript
│   │   └── images/       # Hình ảnh
│   └── .htaccess         # Cấu hình Apache
├── app/                   # Thư mục ứng dụng
│   ├── Controllers/       # Controllers
│   ├── Models/           # Models
│   └── Views/            # Views
├── includes/              # Components tái sử dụng
│   ├── header.php        # Header component
│   ├── footer.php        # Footer component
│   ├── navigation.php    # Navigation menu
│   └── product-card.php  # Product card component
└── config/               # Cấu hình
    └── config.php        # File cấu hình chính
```

## Công nghệ sử dụng
- **Frontend**: HTML5, CSS3, Tailwind CSS, Bootstrap 5
- **Backend**: PHP thuần (MVC pattern)
- **Database**: MySQL (sẽ tích hợp sau)

## Cài đặt
1. Clone repository
2. Copy vào thư mục web server (htdocs, www, etc.)
3. Truy cập: http://localhost/hoaNgocAnh/public

## Tính năng
- ✅ Trang chủ với sản phẩm nổi bật
- ✅ Danh mục sản phẩm (Hoa sinh nhật, Hoa khai trương, etc.)
- ✅ Chi tiết sản phẩm
- ✅ Giỏ hàng
- ✅ Tìm kiếm sản phẩm
- ✅ Responsive design
- ⏳ Đăng nhập/Đăng ký (sẽ phát triển)
- ⏳ Thanh toán (sẽ phát triển)

## Ghi chú
- Dự án này chỉ bao gồm Frontend, Backend sẽ được phát triển tiếp
- Thiết kế dựa trên website siinstore.com với các cải tiến về UI/UX

