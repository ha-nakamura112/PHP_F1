<?php
  include './configfinal.php';

  $dbCon = new mysqli($dbServerName,$dbUserName,$dbpass,$dbname);
  if($dbCon->connect_error){
    die("connection error");
  }
//$_SESSION['user'] always has user email, and $_SESSION['admin'] is user_id
  if(!isset($_SESSION['user'])){
    header("Location: http://localhost/fproject/loginCon.php"); //loginpage
  }else{
    $email = $_SESSION['user'];
    $logCmd = "SELECT * FROM user_tb WHERE email='$email'";
    $useresult = $dbCon->query($logCmd);
    if($useresult->num_rows > 0){
      $user = $useresult->fetch_assoc();
    }
  }

  //
  if(isset($_GET['user'])){ 
    $_SESSION['user']=$user['email'];
    $_SESSION['admin']= $_GET['user'];//
    $dbCon->close();
    print_r($_SESSION['user']); //akane
    print_r($_SESSION['admin']); //16
    header("Location: http://localhost/fproject/adminEditUser.php");
  }

  $userArray = [];
  $postCmd = "SELECT user_id, firstName, lastName, atype, dob, email, profImg, refImg, badge1, tamImg, badge2, profileContent FROM user_tb";
  $result = $dbCon->query($postCmd);
  if($result->num_rows > 0){
    $userData = $result->fetch_assoc();
    while($row = $result->fetch_assoc()){
      array_push($userArray,$row);
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>adminuser</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="stylesheet" href="./CSS/yourpost.css">
</head>
<body>

<header>
    <!-- LOGO -->
      <div class="logo"><h1>WHS<i class="fa-solid fa-house"></i></h1><p>Wood Housing Solution</p></div>

    <!-- NAV -->
    <nav>
      <ul>
        <li><a href="#">Find Shared room/house</a></li>
        <li><a href="#">Comunity</a></li>
        <li><a href="#">Your Profile</a></li>
      </ul>
    </nav>
    <!-- LOGIN USER NAME -->
    <?php
         echo '<aside>Hello,'.$user['firstName'].'</aside>';
       ?>
    <!-- SETTING -->
    <a class="setting-icn" href="#"><i class="fa-solid fa-gear"></i></a>
</header>

<main>
<div class="side">
      <ul>
        <li><a href="./adminuser.php"><i class="fa-solid fa-file-lines"></i>User</a></li>
        <li><a href="./adminPost.php"><i class="fa-solid fa-user"></i>Post</a></li>
      </ul>
  </div>

<?php
    echo "<table><thead><tr>";
    foreach($userData as $fieldName => $value){
      echo "<th>".$fieldName."</th>";
    }
    echo "<th>Delete</th>";
    echo "</tr><thead><tbody>";

    foreach($userArray as $user){
      echo "<tr>";
      foreach($user as $userDetail){
          echo "<th>".$userDetail."</th>";
      }
      echo "<td><a href='./adminuser.php?user=".$user['user_id']."'>Edit</a></td>";
    }
      echo "</tr>";
      echo "</tbody></table>";
?>
</main>
<!-- FOOTER -->
<footer>&copy; Wood housing solution</footer>

</body>
</html>