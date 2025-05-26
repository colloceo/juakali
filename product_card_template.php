<?php

$badge = '';
$badge_class = '';
$quantity = isset($product['quantity']) ? (int)$product['quantity'] : 0;
$created_at_timestamp = isset($product['created_at']) ? strtotime($product['created_at']) : 0;
$price = isset($product['price']) ? (float)$product['price'] : 0;

if ($quantity <= 0) {
    $badge = 'Sold Out';
    $badge_class = 'bg-red-600 text-white';
} elseif ($created_at_timestamp > strtotime('-14 days')) {
    $badge = 'New';
    $badge_class = 'bg-green-600 text-white';
} elseif ($price < 50 && $price > 0) {
    $badge = 'Sale';
    $badge_class = 'bg-indigo-700 text-white';
} else {
    $badge = 'Hot';
    $badge_class = 'bg-yellow-400 text-gray-900';
}

$card_base_class = isset($is_products_page) && $is_products_page ? 'product-card-products' : 'product-card-home';
?>
<div class="<?php echo htmlspecialchars($card_base_class); ?> relative flex flex-col items-center" onclick="window.location.href='product_details.php?id=<?php echo htmlspecialchars($product['id']); ?>'">
    <?php if (!empty($badge)): ?>
        <span class="absolute top-1 left-1 <?php echo htmlspecialchars($badge_class); ?> text-[9px] font-semibold px-1.5 py-0.5 rounded-full z-10">
            <?php echo htmlspecialchars($badge); ?>
        </span>
    <?php endif; ?>
    <img alt="<?php echo htmlspecialchars($product['name']); ?>" class="mb-2 w-20 h-20 object-contain rounded-md border border-gray-100" src="<?php echo htmlspecialchars($product['image_url'] ?? 'https://placehold.co/80x80/f3f4f6/6b7280?text=Product'); ?>">
    <div class="text-xs font-semibold text-gray-900 mb-1 text-center truncate w-full px-1">
        <?php echo htmlspecialchars($product['name']); ?>
    </div>
    <div class="text-xs text-gray-600 text-center w-full">
        KES <?php echo number_format($product['price'], 2); ?>
    </div>
    <div class="mt-2 flex space-x-2">
        <form method="POST" class="inline-block" onclick="event.stopPropagation();">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <button type="submit" name="add_to_cart" class="text-indigo-600 hover:text-indigo-900 text-xs flex items-center px-2 py-1 rounded-md hover:bg-indigo-50 transition-colors duration-150">
                <i class="fas fa-shopping-cart mr-1"></i>Add to Cart
            </button>
        </form>
        <form method="POST" class="inline-block" onclick="event.stopPropagation();">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <button type="submit" name="add_to_wishlist" class="text-indigo-600 hover:text-indigo-900 text-xs flex items-center px-2 py-1 rounded-md hover:bg-indigo-50 transition-colors duration-150">
                <i class="fas fa-heart mr-1"></i>Add to Wishlist
            </button>
        </form>
    </div>
</div>
