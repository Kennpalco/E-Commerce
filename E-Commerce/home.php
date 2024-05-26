<?php

include 'components/connect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

include 'components/wishlist_cart.php';

function renderProduct($product) {
    echo '
    <div class="product-card">
        <form action="" method="post">
            <input type="hidden" name="pid" value="' . htmlspecialchars($product['id']) . '">
            <input type="hidden" name="name" value="' . htmlspecialchars($product['name']) . '">
            <input type="hidden" name="price" value="' . htmlspecialchars($product['price']) . '">
            <input type="hidden" name="image" value="' . htmlspecialchars($product['image_01']) . '">
            <button class="wishlist-btn" type="submit" name="add_to_wishlist"><i class="fas fa-heart"></i></button>
            <a href="quick_view.php?pid=' . htmlspecialchars($product['id']) . '" class="view-btn"><i class="fas fa-eye"></i></a>
            <img src="uploaded_img/' . htmlspecialchars($product['image_01']) . '" alt="' . htmlspecialchars($product['name']) . '">
            <div class="product-info">
                <h3 class="product-name">' . htmlspecialchars($product['name']) . '</h3>
                <div class="product-price">Php ' . htmlspecialchars($product['price']) . '</div>
                <div class="product-qty">
                    <input type="number" name="qty" min="1" max="99" value="1" class="qty-input">
                </div>
                <button type="submit" class="add-to-cart-btn" name="add_to_cart">Add to Cart</button>
            </div>
        </form>
    </div>';
}

function renderCategorySlide($category, $image, $label) {
    echo '
    <div class="category-card">
        <a href="category.php?category=' . htmlspecialchars($category) . '">
            <img src="images/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($label) . '">
            <h3>' . htmlspecialchars($label) . '</h3>
        </a>
    </div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop.Com</title>

    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="home-products">
    <h1 class="heading">Latest products</h1>
    <div class="swiper products-slider">
        <div class="swiper-wrapper">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    renderProduct($fetch_product);
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

<script>
var swiper = new Swiper(".home-slider", {
    loop: true,
    spaceBetween: 20,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

var swiper = new Swiper(".category-slider", {
    loop: true,
    spaceBetween: 20,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        0: { slidesPerView: 2 },
        650: { slidesPerView: 3 },
        768: { slidesPerView: 4 },
        1024: { slidesPerView: 5 },
    },
});

var swiper = new Swiper(".products-slider", {
    loop: true,
    spaceBetween: 20,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        550: { slidesPerView: 2 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
    },
});
</script>

</body>
</html>
