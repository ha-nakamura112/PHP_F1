<?php
  
?>
<!DOCTYPE html>
<html class="navFooter-html" lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- font-awsome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
  <!-- google-font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="../masterpages/CSS/navFooter.css">
  <link rel="stylesheet" href="../masterpages/CSS/logOutHeader.css">
  <link rel="stylesheet" href="../masterpages/CSS/dashBoard.css">
  <link rel="stylesheet" href="../masterpages/CSS/accountSetting.css">
  <link rel="stylesheet" href="../masterpages/CSS/addNewPost.css">
  <link rel="stylesheet" href="../masterpages/CSS/yourPost.css">
  <link rel="stylesheet" href="../masterpages/css/profileDashboard.css">
  <link rel="stylesheet" href="../masterpages/css/logIn.css">
  <link rel="stylesheet" href="../masterpages/css/signUp.css">
  <link rel="stylesheet" href="../masterpages/css/adminUser.css">
  <link rel="stylesheet" href="../masterpages/css/adminpost.css">

<title>Document</title>
</head>
<body class="navFooter-body">
  <header class="navFooter-header">
    <!-- LOGO -->
    <div class="logo">
      <h1>WHS<i class="fa-solid fa-house"></i></h1>
      <p>Wood Housing Solution</p>
    </div>

    <!-- NAV -->
    <nav class="navFooter-nav">
      <ul class="navMenu">
        <li><a href="#">Find Shared room/house</a></li>
        <li><a href="#">Comunity</a></li>
        <li><a href="#">Your Profile</a></li>
      </ul>
    </nav>
    <!-- LOGIN USER NAME -->
    <?php
         echo '<aside class="hello">Hello, '.$user['firstName'].'</aside>';
       ?>
    <!-- SETTING -->
    <div class="setting-wrap">
      <ul class="setting">
        <li class="setting-icon"><a href="#"><i class="fa-solid fa-gear"></i></a>
          <ul class="subMenu">
            <li><a href="./yourPost.php">Dash Board</a></li>
            <li><a href="./yourpost.php?action=exit">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
    </a>
  </header>