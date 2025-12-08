<?php
require_once '../config/config.php';

$page_title = 'Blog - ' . APP_NAME;
$page_description = 'Tin tức và kiến thức về hoa tươi';

// Dữ liệu mẫu blog posts
$blog_posts = [
    [
        'id' => 1,
        'title' => 'Cách chọn hoa sinh nhật phù hợp theo tuổi',
        'slug' => 'cach-chon-hoa-sinh-nhat-phu-hop-theo-tuoi',
        'excerpt' => 'Mỗi độ tuổi đều có những loại hoa phù hợp riêng. Hãy cùng tìm hiểu cách chọn hoa sinh nhật sao cho ý nghĩa nhất.',
        'image' => IMAGES_URL . '/blog/blog-1.jpg',
        'category' => 'Hướng dẫn',
        'author' => 'Admin',
        'date' => '05/12/2024',
        'views' => 1250,
    ],
    [
        'id' => 2,
        'title' => 'Ý nghĩa của các loại hoa trong văn hóa Việt Nam',
        'slug' => 'y-nghia-cua-cac-loai-hoa-trong-van-hoa-viet-nam',
        'excerpt' => 'Mỗi loài hoa đều mang trong mình một ý nghĩa đặc biệt. Cùng khám phá ý nghĩa của các loại hoa phổ biến.',
        'image' => IMAGES_URL . '/blog/blog-2.jpg',
        'category' => 'Kiến thức',
        'author' => 'Admin',
        'date' => '03/12/2024',
        'views' => 980,
    ],
    [
        'id' => 3,
        'title' => 'Top 10 mẫu hoa khai trương được ưa chuộng nhất 2024',
        'slug' => 'top-10-mau-hoa-khai-truong-duoc-ua-chuong-nhat-2024',
        'excerpt' => 'Tổng hợp những mẫu hoa khai trương đẹp, ý nghĩa và được nhiều khách hàng lựa chọn nhất trong năm 2024.',
        'image' => IMAGES_URL . '/blog/blog-3.jpg',
        'category' => 'Xu hướng',
        'author' => 'Admin',
        'date' => '01/12/2024',
        'views' => 1520,
    ],
    [
        'id' => 4,
        'title' => 'Cách bảo quản hoa tươi lâu hơn tại nhà',
        'slug' => 'cach-bao-quan-hoa-tuoi-lau-hon-tai-nha',
        'excerpt' => 'Những mẹo nhỏ giúp hoa tươi của bạn giữ được độ tươi lâu hơn, tiết kiệm chi phí và tận hưởng vẻ đẹp lâu dài.',
        'image' => IMAGES_URL . '/blog/blog-4.jpg',
        'category' => 'Mẹo hay',
        'author' => 'Admin',
        'date' => '28/11/2024',
        'views' => 2100,
    ],
];

include '../includes/header.php';
?>

<!-- Blog Header -->
<div class="bg-gradient-to-r from-rose-500 to-pink-500 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Blog Hoa Tươi</h1>
        <p class="text-lg opacity-90">Chia sẻ kiến thức và kinh nghiệm về hoa</p>
    </div>
</div>

<!-- Blog Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Blog Posts -->
            <div class="lg:col-span-2">
                <div class="space-y-8">
                    <?php foreach ($blog_posts as $post): ?>
                        <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition">
                            <div class="md:flex">
                                <div class="md:w-2/5">
                                    <img src="<?php echo $post['image']; ?>" 
                                         alt="<?php echo htmlspecialchars($post['title']); ?>"
                                         class="w-full h-64 md:h-full object-cover">
                                </div>
                                <div class="p-6 md:w-3/5">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-sm font-medium">
                                            <?php echo $post['category']; ?>
                                        </span>
                                        <span class="text-gray-500 text-sm">
                                            <i class="far fa-calendar mr-1"></i>
                                            <?php echo $post['date']; ?>
                                        </span>
                                    </div>
                                    
                                    <h2 class="text-2xl font-bold mb-3 hover:text-rose-500 transition">
                                        <a href="<?php echo APP_URL; ?>/blog-detail.php?slug=<?php echo $post['slug']; ?>">
                                            <?php echo $post['title']; ?>
                                        </a>
                                    </h2>
                                    
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        <?php echo $post['excerpt']; ?>
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span>
                                                <i class="far fa-user mr-1"></i>
                                                <?php echo $post['author']; ?>
                                            </span>
                                            <span>
                                                <i class="far fa-eye mr-1"></i>
                                                <?php echo number_format($post['views']); ?> lượt xem
                                            </span>
                                        </div>
                                        <a href="<?php echo APP_URL; ?>/blog-detail.php?slug=<?php echo $post['slug']; ?>" 
                                           class="text-rose-500 font-semibold hover:text-rose-600 transition">
                                            Đọc thêm <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination mt-8">
                    <a href="#"><i class="fas fa-chevron-left"></i></a>
                    <span class="active">1</span>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Search -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="font-bold text-lg mb-4">Tìm kiếm</h3>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Tìm kiếm bài viết..." 
                               class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-rose-500">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-rose-500 text-white w-10 h-10 rounded-lg hover:bg-rose-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="font-bold text-lg mb-4">Danh mục</h3>
                    <ul class="space-y-2">
                        <?php
                        $categories = [
                            'Hướng dẫn' => 25,
                            'Kiến thức' => 18,
                            'Xu hướng' => 15,
                            'Mẹo hay' => 30,
                            'Tin tức' => 12,
                        ];
                        foreach ($categories as $cat => $count):
                        ?>
                            <li>
                                <a href="#" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded transition">
                                    <span class="text-gray-700"><?php echo $cat; ?></span>
                                    <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-sm"><?php echo $count; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Popular Posts -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h3 class="font-bold text-lg mb-4">Bài viết phổ biến</h3>
                    <div class="space-y-4">
                        <?php foreach (array_slice($blog_posts, 0, 3) as $post): ?>
                            <a href="<?php echo APP_URL; ?>/blog-detail.php?slug=<?php echo $post['slug']; ?>" 
                               class="flex gap-3 hover:bg-gray-50 p-2 rounded transition">
                                <img src="<?php echo $post['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($post['title']); ?>"
                                     class="w-20 h-20 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-sm line-clamp-2 mb-1">
                                        <?php echo $post['title']; ?>
                                    </h4>
                                    <span class="text-xs text-gray-500">
                                        <i class="far fa-calendar mr-1"></i>
                                        <?php echo $post['date']; ?>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-lg mb-4">Tags phổ biến</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $tags = ['Hoa hồng', 'Hoa sinh nhật', 'Hoa khai trương', 'Hoa tươi', 'Hoa lan', 'Bó hoa', 'Giỏ hoa', 'Lẵng hoa'];
                        foreach ($tags as $tag):
                        ?>
                            <a href="#" class="bg-gray-100 hover:bg-rose-500 hover:text-white px-3 py-1 rounded-full text-sm transition">
                                #<?php echo $tag; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>

