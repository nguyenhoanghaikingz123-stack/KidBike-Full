<?php 
session_start();
ob_start();
include_once('admin/connect.php');


?>


<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KidsBike - Xe Đạp Trẻ Em Hàng Đầu Việt Nam</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/home.css" />
  <link rel="stylesheet" href="css/about.css" />
  <link rel="stylesheet" href="css/products.css" />
  <link rel="stylesheet" href="css/search.css" />
  <link rel="stylesheet" href="css/product-detail.css" />
  
  <link rel="stylesheet" href="css/contact.css" />
  <link rel="stylesheet" href="css/cart.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <!-- ===== NAVBAR ===== -->
  <?php 
    include_once('master/header.php')
  ?>

  
  

  <!-- ===== Main Content ===== -->
  <?php 
  if(isset($_GET['page'])){
    switch($_GET['page']){
      case 'products': include_once('products.php'); break;
      case 'product-detail': include_once('product-detail.php'); break;
      case 'search': include_once('search.php'); break;
      case 'cart': include_once('cart.php'); break;
      case 'about': include_once('about.php'); break;
      default: include_once('dashboard.php'); break;
    }
  } else {
    include_once('dashboard.php'); // Trang chủ mặc định
  }
  
  
  
  ?>

  <!-- ===== FOOTER ===== -->
  <?php 
    include_once('master/footer.php')
  
  ?>

  <script src="js/common.js"></script>
  <script src="js/home.js"></script>
</body>

</html>