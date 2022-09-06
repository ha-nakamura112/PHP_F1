<?php
  include './configfinal.php';

//$_SESSION['user'] always has user email, and $_SESSION['admin'] is user_id
if(isset($_SESSION['user']) || $_SESSION['timeout'] < time()){ 
  $useremail = $_SESSION['user'];
  $logCmd = "SELECT * FROM user_tb WHERE email='$useremail'";
  $useresult = $dbCon->query($logCmd);
  if($useresult->num_rows > 0){
    $user = $useresult->fetch_assoc(); 
    // $user is about admin
  }
}

  $userArray = [];
  $postCmd = "SELECT user_id, firstName, lastName, atype, dob, email, profImg, refImg, badge1, tamImg, badge2, profileContent FROM user_tb ";
  $result = $dbCon->query($postCmd);
  if($result->num_rows > 0){
    $userData = $result->fetch_assoc();
    while($row = $result->fetch_assoc()){
      array_push($userArray,$row);
    }
  }


  $id = $_SESSION['admin'];   if($_SERVER['REQUEST_METHOD']=='POST'){
    $updateCmd = "UPDATE user_tb SET  badge1='".$_POST['badge1']."', badge2='".$_POST['badge2']."' WHERE user_id='$id'";
    if($dbCon->query($updateCmd) === true){
      $_SESSION['user']= $useremail;
      $_SESSION['timeout'] = time()+900;
      header("Location:http://localhost/fproject/pages/adminuser.php");
    }else{
      echo $dbCon->error;
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

    foreach($userArray as $users){
      echo "<tr>";
      foreach($users as $field=>$userDetail){
        if($users['user_id'] == $id){
          switch($field){
            case 'badge1':
              echo '<td><form method="POST" action="'.$_SERVER['PHP_SELF'].'"><select class="badge-select" name="badge1"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>';
            break;
            case 'badge2' :
              echo '<td><form method="POST" action="'.$_SERVER['PHP_SELF'].'"><select class="badge-select" name="badge2"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>';
            break;
            default :
            echo "<td>".$userDetail."</td>";   
          }
        }else{
          echo "<td>".$userDetail."</td>";
        }
      }

      if($users['user_id'] == $id){
      echo "<td><button class='editUser-save-btn' type='submit'>Updated</button></form></td>";
      }else{
        echo "<td></td>";
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