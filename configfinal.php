<?php
$dbUserName = "root";
$dbServerName = "localhost";
$dbpass = "";
$dbname = "final_db"; //dbname connects to specific 
session_start();

function specify($value){
  if(!isset($value)){
    header("Location: http://localhost/fproject/loginCon.php"); //loginpage
  }else{
    $user = $value;
  }
}


 //place should be like './files/img'
 function uploadfile($destDir,$pName){
    $sourceFile = $_FILES[$pName];
    $sourceFileDetails = pathinfo($sourceFile['name']);
    $imgArray = (" jpg,png,jpeg,gif,tiff,psd,pdf,eps");
    if(strpos($imgArray,$sourceFileDetails['extension']) !=0 && getimagesize($sourceFile['tmp_name'])){
      if($sourceFile['size']<4000000000){
          if(move_uploaded_file($sourceFile['tmp_name'],$destDir.$sourceFile['name'])){
            return 'true';
          }else{
            echo 'Error';
          }
        }
      }
  }

  //should think
  function badge_check($name,$name2){
    $badge1 =" ";
    $badge2 =" ";
    if(isset($_FILES['$name']) && isset($_FILES['$name2'])){
      $badge1 = 'waiting';
      $badge2 = 'waiting';
    }elseif(isset($_FILES['$name']) && !isset($_FILES['$name2'])){
      $badge1 = 'waiting';
      $badge2 = "unsubmitted";
    }elseif(!isset($_FILES['$name']) && isset($_FILES['$name2'])){
      $badge1 = "unsubmitted";
      $badge2 = 'waiting';
    }

    return ['$badge1', '$badge2'];
  }




    // function Connect(){



      //     $dbUserName = "root";
//     $dbServerName = "localhost";
//     $dbpass = "";
//     $dbname = "final_db";
//     $dbCon = new mysqli($dbServerName,$dbUserName,$dbpass,$dbname);
//     if($dbCon->connect_error){
//       die('connection error');
//       return 'false';
//     }else{
//       return $dbCon;
//     }
//   }
  
//   function find_userName($tableName,$userName,$fieldname){
//     $dbCon = db_connect();
//     if($dbCon !== false){
//       $selectCmd = "SELECT * FROM $tableName WHERE $fieldname = '$userName'";
//       $result = $dbCon->query($selectCmd);
//       if($result->num_rows() > 0){
//         $user = $result->fetch_assoc();
//         $dbCon->close();
//         return $user;
//       }else{
//         $dbCon->close();
//         return false;
//       }

//     }
//   }

  function sanitize($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
  }
?>