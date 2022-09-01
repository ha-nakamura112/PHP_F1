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
      switch($fieldName){
        case 'atype' :
          echo "<th class='filedName'>Account type</th>";
        break;
        case 'dob' :
          echo '<th class="filedName">Date of birth</th>';
        break;
        default:
        echo "<th class='filedName'>".$fieldName."</th>";
      }
    }
    echo "<th class='filedName'>Save</th>";
    echo "</tr><thead><tbody class='item'>";

    foreach($userArray as $user){
      echo "<tr>";
      foreach($user as $field=>$userDetail){
        if($user['user_id'] == $id){
          switch($field){
            case 'badge1':
              echo '<td><form method="POST" action="#"><select name="badge1"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>';
            break;
            case 'badge2' :
              echo '<td><form method="POST" action="#"><select name="badge2"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>';
            break;
            default :
            echo "<td>".$userDetail."</td>";   
          }
        }else{
          echo "<td>".$userDetail."</td>";
        }
      }

      if($user['user_id'] == $id){
      echo "<td><button type='submit'>Updated</button></form></td>";
      }else{
        echo "<td></td>";
        //other place, how to design
      }
    }
      echo "</tr>";
      echo "</tbody></table>";
  ?>
 <!-- Dashboard closing -->
 <?php
  include '../masterpages/dashboard02.php';
  ?>
  <!-- FOOTER -->
  <?php
  include '../masterpages/footer.php';
  ?>


</body>
</html>

<!-- echo '<td><form method="POST" action="echo "'.$_SERVER['PHP_SELF'].'"><select name="badge1"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>';
            break;
            case 'badge2' :
              echo '<td><form method="POST" action="echo "'.$_SERVER['PHP_SELF'].'"><select name="badge2"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>'; -->