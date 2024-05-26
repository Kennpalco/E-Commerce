<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
    exit;
}

if (isset($_POST['order'])) {

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
    $address = 'flat no. ' . filter_var($_POST['flat'], FILTER_SANITIZE_STRING) . ', ' 
               . filter_var($_POST['district'], FILTER_SANITIZE_STRING) . ', ' 
               . filter_var($_POST['city'], FILTER_SANITIZE_STRING) . ', ' 
               . filter_var($_POST['region'], FILTER_SANITIZE_STRING) . ', ' 
               . filter_var($_POST['country'], FILTER_SANITIZE_STRING) . ' - ' 
               . filter_var($_POST['pin_code'], FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if ($check_cart->rowCount() > 0) {

        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

        $message[] = 'Order placed successfully!';
    } else {
        $message[] = 'Your cart is empty';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="css/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items = [];
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ')';
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p><?= $fetch_cart['name']; ?> <span>(<?= 'Php.' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity']; ?>)</span></p>
      <?php
            }
            $total_products = implode(', ', $cart_items);
         } else {
            echo '<p class="empty">Your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products); ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <div class="grand-total">Grand Total: <span>Php.<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>Place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Name :</span>
            <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Number :</span>
            <input type="number" name="number" placeholder="Enter your number" class="box" min="0" max="9999999999" oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);" required>
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <select name="method" class="box" required>
               <option value="Cash on Delivery">Cash On Delivery</option>
               <option value="Credit Card">Credit Card</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. Flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Address Line 02 :</span>
            <input type="text" name="district" placeholder="District" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="City" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Province:</span>
            <input type="text" name="region" placeholder="Region" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="Country" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>ZIP CODE :</span>
            <input type="number" name="pin_code" placeholder="e.g. 56400" min="0" max="999999" oninput="if(this.value.length > 6) this.value = this.value.slice(0, 6);" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Place order">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
