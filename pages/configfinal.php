<?php
$dbUserName = "root";
$dbServerName = "localhost";
$dbpass = "";
$dbname = "final_db"; 

session_start();
$dbCon = new mysqli($dbServerName,$dbUserName,$dbpass,$dbname);
  if($dbCon->connect_error){
    die("connection error");
  }

if(isset($_GET['action']) && $_GET['action'] == 'exit'){
      $dbCon->close;
      session_unset();
      session_destroy();
      header("Location: http://localhost/fproject/pages/loginCon.php");
}

//function part
//destDir should be like './files/img'
function uploadfile($destDir,$pName){
  $sourceFile = $_FILES[$pName];
  $sourceFileDetails = pathinfo($sourceFile['name']);
  $imgArray = ("jpg,png,jpeg,gif,tiff,psd,pdf,eps");
  if(strpos($imgArray,$sourceFileDetails['extension']) !=0 && getimagesize($sourceFile['tmp_name'])){
    if($sourceFile['size']<400000000){
        if(move_uploaded_file($sourceFile['tmp_name'],$destDir.$sourceFile['name'])){
          return 'true';
        }else{
          echo 'Error';
        }
      }
    }
  }


  // function file_size($name){
  //   $sourceFile = $_FILES[$name];
  //   if($sourceFile['size'] > 0){
  //     return $sourceFile['size'];
  //     return true;
  //   }else{
  //     return true;
  //   }

  // }

  //should think
  function badge_check($name1,$name2){
    $badge1 =" ";
    $badge2 =" ";
    //first if condition changed by Akane
    if(!isset($_FILES['$name1']) && !isset($_FILES['$name1'])){
      $badge1 = 'waiting';
      $badge2 = 'waiting';
    }elseif(isset($_FILES['$name']) && !isset($_FILES['$name2'])){
      $badge1 = 'waiting';
      $badge2 = "unsubmitted";
    }elseif(!isset($_FILES['$name']) && isset($_FILES['$name2'])){
      $badge1 = "unsubmitted";
      $badge2 = 'waiting';
    }
    return ['$badge1','$badge2'];
  }

  
  function sanitize($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
  }
?>