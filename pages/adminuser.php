<?php
  include '../configfinal.php';

//$_SESSION['user'] always has user email, and $_SESSION['admin'] is user_id
  if(!isset($_SESSION['user'])){
    header("Location: http://localhost/fproject/pages/loginCon.php"); //loginpage
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
    header("Location: http://localhost/fproject/pages/adminEditUser.php");
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


<?php
  include '../masterpages/loggedInHeader.php';
  ?>
<main class="adminUser-main">
<?php
  include '../masterpages/dashboard01admin.php';
  ?>

<?php
    echo "<table class='horizontal-list'><thead class='item'><tr>";
    foreach($userData as $fieldName => $value){
      echo "<th class='filedName'>".$fieldName."</th>";
    }
    echo "<th class='filedName'>Delete</th>";
    echo "</tr><thead><tbody class='item'>";

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

<?php
  include '../masterpages/dashboard02.php';
  ?>

<!-- FOOTER -->
<?php include '../masterpages/footer.php'; ?>

</body>
</html>