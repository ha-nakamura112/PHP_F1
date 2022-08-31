<?php
include './configfinal.php';
$dbCon = new mysqli($dbServerName,$dbUserName,$dbpass,$dbname);
if($dbCon->connect_error){
  die("connection error");
}

if(isset($_SESSION['user'])){ 
  $useremail = $_SESSION['user'];
  $logCmd = "SELECT * FROM user_tb WHERE email='$useremail'";
  $useresult = $dbCon->query($logCmd);
  if($useresult->num_rows > 0){
    $userdetail = $useresult->fetch_assoc(); 
    // $userdetail is about admin
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

 //get action isset
//delete
$id = $_SESSION['admin']; 
if($_SERVER['REQUEST_METHOD']=='POST'){
  $updateCmd = "UPDATE user_tb SET  badge1='".$_POST['badge1']."', badge2='".$_POST['badge2']."' WHERE user_id='".$id."'";
  if($dbCon->query($updateCmd) === true){
    $_SESSION['user']= $useremail;
    // print_r($useremail);
    header("Location:http://localhost/fproject/adminuser.php");
  }else{
    echo $dbCon->error;
  }

  // $dbcon->close();
  // unset($_SESSION['user']);
  // header("Location: http://localhost/fproject/adminuser.php");
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

<?php
  echo "<table><thead><tr>";
    foreach($userData as $fieldName => $value){
      switch($fieldName){
        case 'atype' :
          echo "<th>Account type</th>";
        break;
        case 'dob' :
          echo '<th>Date of birth</th>';
        break;
        default:
        echo "<th>".$fieldName."</th>";
      }
    }
    echo "<th>Save</th>";
    echo "</tr><thead><tbody>";

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


</body>
</html>

<!-- echo '<td><form method="POST" action="echo "'.$_SERVER['PHP_SELF'].'"><select name="badge1"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>';
            break;
            case 'badge2' :
              echo '<td><form method="POST" action="echo "'.$_SERVER['PHP_SELF'].'"><select name="badge2"><option>unsubmitted</option><option>waiting</option><option>verified</option></select></td>'; -->