<!-- Top Section - Advertisements Carousel -->
<div class="relative bg-gray-100">
    <div class="swiper-container advertisement-slider">
        <div class="swiper-wrapper">
            <?php if (empty($ads)): ?>
                <!-- Default Advertisement -->
                <div class="swiper-slide">
                    <div class="relative h-48 md:h-64">
                        <img src="https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg" 
                             alt="Welcome to HAVMORICE" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-transparent flex items-center">
                            <div class="px-6">
                                <h2 class="text-white text-2xl md:text-3xl font-bold">Welcome to HAVMORICE</h2>
                                <p class="text-white mt-2">Your daily essentials delivered at your doorstep</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($ads as $ad): ?>
                <div class="swiper-slide">
                    <div class="relative h-48 md:h-64">
                        <img src="<?= htmlspecialchars($ad['image_url']) ?>" 
                             alt="<?= htmlspecialchars($ad['title']) ?>" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
                            <div class="px-6">
                                <h2 class="text-white text-2xl md:text-3xl font-bold"><?= htmlspecialchars($ad['title']) ?></h2>
                                <p class="text-white mt-2"><?= htmlspecialchars($ad['description']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- Wallet Balance Card -->
<div class="bg-white p-4 mx-4 mt-4 rounded-xl shadow-md">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Wallet Balance</h3>
            <p class="text-2xl font-bold text-primary">₹<?= number_format($wallet['balance'], 2) ?></p>
        </div>
        <div class="text-right">
            <h3 class="text-lg font-semibold text-gray-800">HG Coins</h3>
            <p class="text-2xl font-bold text-secondary"><?= number_format($wallet['hg_coins'], 0) ?></p>
        </div>
    </div>
    <button onclick="window.location.href='/wallet/recharge'" 
            class="mt-3 w-full bg-primary text-white py-2 rounded-lg hover:bg-primary-dark transition-colors">
        Add Money
    </button>
</div>

<!-- Categories Section -->
<div class="px-4 mt-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Categories</h2>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
        <?php foreach ($categories as $category): ?>
        <a href="/category/<?= $category['id'] ?>" class="group">
            <div class="bg-white rounded-xl p-4 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 mx-auto mb-2 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                    <i class="<?= htmlspecialchars($category['icon_class']) ?> text-primary text-xl"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-800"><?= htmlspecialchars($category['name']) ?></h3>
                <p class="text-xs text-gray-500"><?= $category['product_count'] ?> items</p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Featured Products Section -->
<div class="px-4 mt-8 mb-20">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Featured Products</h2>
        <a href="/products" class="text-primary hover:text-primary-dark text-sm font-medium">View All</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php foreach ($products as $product): ?>
        <a href="/product/<?= $product['id'] ?>" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="relative pb-[100%]">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>" 
                     class="absolute inset-0 w-full h-full object-cover">
                <?php if ($product['is_subscribable']): ?>
                <div class="absolute top-2 left-2 bg-secondary text-white text-xs px-2 py-1 rounded-full">
                    Subscription Available
                </div>
                <?php endif; ?>
            </div>
            <div class="p-3">
                <h3 class="font-medium text-gray-800 truncate"><?= htmlspecialchars($product['name']) ?></h3>
                <p class="text-sm text-gray-500 truncate"><?= htmlspecialchars($product['category_name']) ?></p>
                <div class="mt-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-lg font-bold text-primary">₹<?= number_format($product['price'], 2) ?></span>
                        <?php if ($product['original_price'] > $product['price']): ?>
                        <span class="ml-2 text-xs text-gray-500 line-through">₹<?= number_format($product['original_price'], 2) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($product['avg_rating'] > 0): ?>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                        <span class="ml-1 text-sm text-gray-600"><?= number_format($product['avg_rating'], 1) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Initialize Swiper -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.advertisement-slider', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });
});
</script>

<!-- Custom Styles -->
<style>
.swiper-container {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    background: #fff;
}

.swiper-pagination-bullet-active {
    background: #FF6B6B !important;
}
</style>
