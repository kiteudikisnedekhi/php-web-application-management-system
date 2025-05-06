<!-- Product Listing Page -->
<div class="bg-gray-50 min-h-screen">
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                <div class="flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" 
                               id="searchInput"
                               value="<?= htmlspecialchars($currentSearch) ?>"
                               placeholder="Search products..."
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <!-- Sort Dropdown -->
                    <select id="sortSelect" 
                            class="pl-4 pr-8 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        <option value="newest" <?= $currentSort === 'newest' ? 'selected' : '' ?>>Newest First</option>
                        <option value="price_low" <?= $currentSort === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_high" <?= $currentSort === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="rating" <?= $currentSort === 'rating' ? 'selected' : '' ?>>Highest Rated</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Category Filter Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="font-semibold text-gray-800 mb-4">Categories</h2>
                    <div class="space-y-2">
                        <a href="/products" 
                           class="block px-3 py-2 rounded-lg <?= !$currentCategory ? 'bg-primary text-white' : 'hover:bg-gray-100' ?>">
                            All Products
                        </a>
                        <?php foreach ($categories as $category): ?>
                        <a href="/products?category=<?= $category['id'] ?>" 
                           class="block px-3 py-2 rounded-lg <?= $currentCategory == $category['id'] ? 'bg-primary text-white' : 'hover:bg-gray-100' ?>">
                            <div class="flex items-center justify-between">
                                <span><?= htmlspecialchars($category['name']) ?></span>
                                <span class="text-sm <?= $currentCategory == $category['id'] ? 'text-white/80' : 'text-gray-500' ?>">
                                    <?= $category['product_count'] ?>
                                </span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1">
                <?php if (empty($products)): ?>
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                </div>
                <?php else: ?>
                <!-- Results Count -->
                <div class="mb-4 text-sm text-gray-600">
                    Showing <?= ($currentPage - 1) * 12 + 1 ?>-<?= min($currentPage * 12, $totalProducts) ?> 
                    of <?= $totalProducts ?> products
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($products as $product): ?>
                    <a href="/product/<?= $product['id'] ?>" 
                       class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Product Image -->
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

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-medium text-gray-900 mb-1 truncate">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                            <p class="text-sm text-gray-500 mb-2">
                                <?= htmlspecialchars($product['category_name']) ?>
                            </p>
                            
                            <!-- Price -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-lg font-bold text-primary">
                                        ₹<?= number_format($product['price'], 2) ?>
                                    </span>
                                    <?php if ($product['original_price'] > $product['price']): ?>
                                    <span class="ml-2 text-sm text-gray-500 line-through">
                                        ₹<?= number_format($product['original_price'], 2) ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Rating -->
                                <?php if ($product['review_count'] > 0): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="ml-1 text-sm text-gray-600">
                                        <?= number_format($product['avg_rating'], 1) ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="mt-8 flex justify-center">
                    <div class="flex space-x-2">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?><?= $currentCategory ? '&category=' . $currentCategory : '' ?><?= $currentSearch ? '&search=' . urlencode($currentSearch) : '' ?><?= $currentSort ? '&sort=' . $currentSort : '' ?>" 
                           class="px-4 py-2 rounded-lg <?= $i === $currentPage ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                            <?= $i ?>
                        </a>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    let searchTimeout;

    // Handle search input
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateURL();
        }, 500);
    });

    // Handle sort selection
    sortSelect.addEventListener('change', function() {
        updateURL();
    });

    function updateURL() {
        const params = new URLSearchParams(window.location.search);
        
        // Update search parameter
        if (searchInput.value) {
            params.set('search', searchInput.value);
        } else {
            params.delete('search');
        }
        
        // Update sort parameter
        if (sortSelect.value !== 'newest') {
            params.set('sort', sortSelect.value);
        } else {
            params.delete('sort');
        }
        
        // Reset to first page when filters change
        params.delete('page');
        
        // Construct new URL
        const newURL = `${window.location.pathname}${params.toString() ? '?' + params.toString() : ''}`;
        window.location.href = newURL;
    }
});
</script>
