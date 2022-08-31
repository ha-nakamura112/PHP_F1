<?php

// timeout function, I'm going to remake
function timeout($time,$dbCon){
  if($time < time()){
    session_unset();
    session_destroy();
    $dbCon->close();
    header("Location: http://localhost/php/loginCon.php");
  }
}
//$db


//-------------------------------------------------------
//session value
//fname,lname,type, bdate, email, pass, profimg, reimg,tamimg,post[(postimg,title,content),(postimg,title,content),...]

//signup---------------------------------------------------
// when user is writing, should make sure pass and repass is same


if($_SERVER['REQUEST_METHOD']=='POST'){
  // check if they write every mandatory question and store as session
  // to specify each info, maybe use number or some way
  if($_POST['fname'] != '' && $_POST['lname'] != '', //... every post ){
    $_POST['fname'] = $fname;
    $_POST['lname'] = $lname; //...every post
    $_SESSION['timeout1'] == time()+600;
    $_SESSION['timeout2'] == time()+720;

    // should decide time
    $_FILES['profimg'] = $progImg;
    ...

    //put everything in session['userdata']
    //connect to mysqli
    //check connection and insert
    // INSERT INTO `user_tb`(`user_id`, `firstName`, `lastName`,...) VALUES ('$fname','$lname',...)

    //to have badge, put hidden input with value. if imgs are filled we accept hidden value.

    
  }
  // then direct to homepage(switch)
  if($type='admin'){
    header("location adminhp")
  }else{
    header userhp;
  }
  
  //to change pages


//---------------------------------------------------------
//login : 
// make sure they fill name and pass
//!using session and its key,check and login
// if there is → go to the user's homepage: ,if not just error

//if there is specific value with hidden input(to have badge)


$selectCmd1 = "SELECT * FROM `user_tb` WHERE email = '$userName' ";
$result = $dbConn->query($selectCmd1);
//using fetch and put all values session['userData]
if($result->num_rows > 0){
  echo badge1; //pending badge
}
if($result->num_rows > 0){
  echo badge2; // real badge(landroad can edit this value)
}




//----------------------------
//homepage for admin
//two article with link.?action=user or post
//switch and include file

//dashbord
a href=""?action=student,landlord
switch(aciton){
  student:
  studentpage
  landlord:
  landlordpage
}




//-------------------------------------------------------
//homepage for landroad and student
// get info from database, then display
// use email to specify user

if(isset($_SESSION['userData'])){
  echo "<table>"; //..
  foreach($_SESSION['userData'] as $fieldName=> $value){
    <td>$fieldName<td>
  }
  </tr><tr>
  foreach($_SESSION['userData'] as $fieldName=> $value){
    <td>$value<td>;
  }
  </tr></table>
}

//---------------------------------------------------------
//dashbord
//each button should have href="<?php echo $_SERVER['PHP_SELF'].'?action=exit,yourpost..' 
if(isset($_GET['action'])){
  $action = $_GET['action'];
  switch($action){ 

    // each action should reset timecounter with func
    // case "exit" :
    //   session_unset();
    //   session_destroy();
    //   header("Location: http://localhost/php/session1.php");
    //   break;

      case "yourpost":
        include 'yourpost.php';
        //get info from database and display as a table
        // prev and next works with numbers 

        
      case "profile":
        include 'profile.php';
         //if( == post), if it is a img(check with extention), upload img and display. don't forget to encrypt 
        // store datebase with func insert

        //! prof sentences edit datebase
        // should use specialchara function for secure ↓
        //htmlspecialchars(string,flags,character-set,double_encode)
      
      case "post":
        include 'post.php';

        //if( == post), if it is a img(check with extention), get img and display. 
        // store in datebase 

        //! post sentences edit datebase
        // should use specialchara function for secure ↓
        //htmlspecialchars(string,flags,character-set,double_encode)

      case "setting":
        include 'setting.php';
        // display prev info (like coursework) 
      break;
  }
}else{
   echo "hi";
}

?>