<?php
/**
 * Component hiển thị card sản phẩm
 * 
 * @param array $product - Thông tin sản phẩm
 * - id: ID sản phẩm
 * - name: Tên sản phẩm
 * - slug: Slug sản phẩm
 * - image: URL hình ảnh
 * - price: Giá gốc
 * - sale_price: Giá khuyến mãi (optional)
 * - rating: Đánh giá (1-5) (optional)
 * - reviews: Số lượt đánh giá (optional)
 * - sold: Số lượng đã bán (optional)
 */

$has_sale = isset($product['sale_price']) && $product['sale_price'] < $product['price'];
$discount_percent = $has_sale ? calculateDiscount($product['price'], $product['sale_price']) : 0;
$display_price = $has_sale ? $product['sale_price'] : $product['price'];
?>

<div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
    <!-- Product Image -->
    <div class="relative overflow-hidden aspect-square">
        <a href="<?php echo APP_URL; ?>/product.php?slug=<?php echo $product['slug']; ?>">
            <img src="<?php echo $product['image']; ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                 loading="lazy">
        </a>
        
        <?php if ($has_sale): ?>
            <div class="absolute top-3 left-3 bg-rose-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                -<?php echo $discount_percent; ?>%
            </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <button onclick="addToWishlist(<?php echo $product['id']; ?>)" 
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-rose-500 hover:text-white transition-colors"
                    title="Yêu thích">
                <i class="far fa-heart"></i>
            </button>
            <button onclick="quickView(<?php echo $product['id']; ?>)" 
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-rose-500 hover:text-white transition-colors"
                    title="Xem nhanh">
                <i class="far fa-eye"></i>
            </button>
        </div>
        
        <!-- Add to Cart Button (appears on hover) -->
        <button onclick="addToCart(<?php echo $product['id']; ?>, 1, {name: '<?php echo addslashes($product['name']); ?>', slug: '<?php echo $product['slug']; ?>', image: '<?php echo $product['image']; ?>', price: <?php echo $product['price']; ?>, sale_price: <?php echo $product['sale_price'] ? $product['sale_price'] : 'null'; ?>})" 
                class="absolute bottom-0 left-0 right-0 bg-rose-500 text-white py-3 font-semibold translate-y-full group-hover:translate-y-0 transition-transform duration-300 hover:bg-rose-600">
            <i class="fas fa-shopping-cart mr-2"></i>Thêm vào giỏ
        </button>
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <a href="<?php echo APP_URL; ?>/product.php?slug=<?php echo $product['slug']; ?>" 
           class="block">
            <h3 class="font-semibold text-gray-800 mb-2 text-lg line-clamp-2 hover:text-rose-500 transition-colors min-h-[3rem]">
                <?php echo htmlspecialchars($product['name']); ?>
            </h3>
        </a>

        <!-- Rating & Reviews -->
        <?php if (isset($product['rating']) && $product['rating'] > 0): ?>
            <div class="flex items-center gap-2 mb-2 text-sm">
                <div class="flex items-center text-yellow-400">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $product['rating']): ?>
                            <i class="fas fa-star"></i>
                        <?php else: ?>
                            <i class="far fa-star"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <span class="text-gray-600">
                    <?php echo number_format($product['rating'], 1); ?>
                </span>
                <?php if (isset($product['reviews'])): ?>
                    <span class="text-gray-400">
                        (<?php echo $product['reviews']; ?> đánh giá)
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Sales Count -->
        <?php if (isset($product['sold']) && $product['sold'] > 0): ?>
            <div class="text-sm text-gray-600 mb-2">
                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                Đã bán <?php echo $product['sold']; ?>
            </div>
        <?php endif; ?>

        <!-- Price -->
        <div class="flex items-center gap-2 mb-3">
            <span class="text-xl font-bold text-rose-500">
                <?php echo formatPrice($display_price); ?>
            </span>
            <?php if ($has_sale): ?>
                <span class="text-sm text-gray-400 line-through">
                    <?php echo formatPrice($product['price']); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Stock Status -->
        <div class="flex items-center justify-between text-sm">
            <span class="text-green-600 font-medium">
                <i class="fas fa-check-circle mr-1"></i>Còn hàng
            </span>
            <button onclick="addToCart(<?php echo $product['id']; ?>, 1, {name: '<?php echo addslashes($product['name']); ?>', slug: '<?php echo $product['slug']; ?>', image: '<?php echo $product['image']; ?>', price: <?php echo $product['price']; ?>, sale_price: <?php echo $product['sale_price'] ? $product['sale_price'] : 'null'; ?>})" 
                    class="text-rose-500 hover:text-rose-600 font-medium transition-colors">
                Mua ngay <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

