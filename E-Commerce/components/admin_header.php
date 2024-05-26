<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">Home</a>
         <a href="../admin/products.php">Products</a>
         <a href="../admin/placed_orders.php">Orders</a>
         <a href="../admin/admin_accounts.php">Admins</a>
         <a href="../admin/users_accounts.php">Users</a>
         <a href="../admin/messages.php">Messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="../admin/update_profile.php" class="btn">Update Profile</a>
         <div class="flex-btn">
            <a href="../admin/register_admin.php" class="option-btn">Register</a>
            <a href="../admin/admin_login.php" class="option-btn">Login</a>
         </div>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Logout</a> 
      </div>

   </section>

</header>

<style>
/* Message Styling */
.message {
   background-color: #ffdddd;
   border-left: 6px solid #f44336;
   margin: 10px 0;
   padding: 15px;
   position: relative;
   border-radius: 5px;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   display: flex;
   justify-content: space-between;
   align-items: center;
}
.message span {
   font-size: 16px;
}
.message i {
   cursor: pointer;
   color: #f44336;
}

/* Header Styling */
.header {
   background-color: #333;
   color: #fff;
   padding: 15px 20px;
}
.header .flex {
   display: flex;
   justify-content: space-between;
   align-items: center;
}
.header .logo {
   font-size: 24px;
   font-weight: bold;
   color: #fff;
   text-decoration: none;
}
.header .logo span {
   color: #007bff;
}
.header .navbar a {
   color: #fff; 
   text-decoration: none;
   margin: 0 10px;
   font-size: 18px;
   transition: color 0.3s;
}
.header .navbar a:hover {
   color: #fff;
}
.header .icons {
   display: flex;
   align-items: center;
}
.header .icons .fas {
   font-size: 20px;
   color: #fff;
   cursor: pointer;
   margin-left: 15px;
}
.header .profile {
   background-color: #fff;
   color: #333;
   padding: 15px;
   position: absolute;
   top: 70px;
   right: 20px;
   width: 250px;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   border-radius: 5px;
   display: block;
}
.header .profile p {
   font-size: 18px;
   margin-bottom: 10px;
}
.header .profile .btn, .header .profile .option-btn, .header .profile .delete-btn {
   display: block;
   text-align: center;
   margin: 5px 0;
   padding: 10px;
   border-radius: 5px;
   text-decoration: none;
   transition: background-color 0.3s;
}
.header .profile .btn {
   background-color: #007bff;
   color: #fff;
}
.header .profile .option-btn {
   background-color: #f0f0f0;
   color: #333;
}
.header .profile .delete-btn {
   background-color: #f44336;
   color: #fff;
}
.header .profile .btn:hover {
   background-color: #0056b3;
}
.header .profile .option-btn:hover {
   background-color: #ddd;
}
.header .profile .delete-btn:hover {
   background-color: #d32f2f;
}
</style>

<script>
   document.getElementById('menu-btn').onclick = () => {
      document.querySelector('.header .navbar').classList.toggle('show');
   };
</script>
