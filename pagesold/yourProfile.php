<?php
  include '../configfinal.php';
  session_start();
  $dbCon = new mysqli($dbSeverName,$dbUserName,$dbpass,$dbname);
  if($dbCon->connect_error){
    die("connection error");
  }

  if(!isset($_SESSION['user'])){
    header("Location: "); //loginpage
  }else{
    $email = $_SESSION['user'];
    $logCmd = "SELECT * FROM user_tb WHERE email='$email'";
    $useresult = $dbCon->query($logCmd);
    if($useresult->num_rows > 0){
      $user = $useresult->fetch_assoc();
    }
  }
  ?>
  <?php
  include '../masterpages/loggedInHeader.php';
  ?>

    <main class="yourProfile-main">
    <?php include '../masterpages/dashboard01.php' ?>
        <form class="yourProfile-form" method="POST" action="#" enctype="multipart/form-data">
            <label for="profImg">Profile image</label>
              <article class="yourProfile-article">
                
                <input type="file"  name="profImg" value="<?php echo $user['profImg']; ?>">
                <!-- value or required -->
              </article>
            <label for="content">Content</label>
            <textarea class="yourProfile-textarea"  name="content"></textarea>
            <div class="yourProfile-btn">
        <button type="submit">Save</button>
      </div>
          </form>
          <?php include '../masterpages/dashboard02.php' ?>
    <?php include '../masterpages/footer.php' ?>
  
  <?php

if($_SERVER['REQUEST_METHOD']=='POST'){
  if(uploadfile('./img/profile_img','profImg')==='true'){
    $profImg = $_FILES['profImg']['name'];
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES);
  }
  
  $useremail = $user['email'];
  
  $profCmd = "UPDATE user_tb SET profImg='".$profImg."', profileContent='".$content."' WHERE email='$useremail'";
  if($dbCon->query($profCmd) === true){
    $dbCon->close();
    // session_unset();
    // session_destroy();
    header("Location: http://localhost/fproject/yourpost.php");
  }
  echo $dbCon->error;
}


// $destDir = './img/profile_img';
// $sourceFile = $_FILES['profImg'];
// $sourceFileDetails = pathinfo($sourceFile['name']);
// print_r($sourceFileDetails);
// $imgArray = (" jpg,png,jpeg,gif,tiff,psd,pdf,eps");
// if(strpos($imgArray,$sourceFileDetails['extension']) !=0 && getimagesize($sourceFile['tmp_name'])){
//     if($sourceFile['size']<400000){
//         if(move_uploaded_file($sourceFile['tmp_name'],$destDir.$sourceFile['name'])){
?>

</body>

</html>