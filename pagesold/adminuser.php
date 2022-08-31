<?php
  include '../configfinal.php';
  session_start();
  $dbCon = new mysqli($dbSeverName,$dbUserName,$dbpass,$dbname);
  if($dbCon->connect_error){
    die("connection error");
  }

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

  if(isset($_GET['user'])){ 
    $_SESSION['user']= $_GET['user'];
    $dbCon->close();
    header("Location: http://localhost/fproject/pages/adminEditUser.php");// change url
  }

  $userArray = [];
  $postCmd = "SELECT user_id, firstName, lastName, atype, dob, email, profImg, refImg, tamImg,  profileContent FROM user_tb";
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

<main>
<?php
    include '../masterpages/dashboard01admin.php';
?>

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
      echo "<td><a href='./adminPost.php?user=".$user['user_id']."'>Edit</a></td>";
    }
      echo "</tr>";
      echo "</tbody></table>";
?>

       <?php include '../masterpages/dashboard02.php' ?>
    <?php include '../masterpages/footer.php' ?>

  
</body>
</html>