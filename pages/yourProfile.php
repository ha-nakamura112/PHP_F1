<?php
  include './configfinal.php';

  if(!isset($_SESSION['user']) || $_SESSION['timeout'] < time()){
    header("Location: http://localhost/fproject/pages/loginCon.php"); //loginpage
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
        <form class="yourProfile-form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <?php echo '<img src="./img/profile_img/'.$user['profImg'].'">';?>
            <label for="profImg">Profile image</label>
              <article class="yourProfile-article">
                <input type="file"  name="profImg">
              </article>
            <label for="content">Content</label>
            <textarea class="yourProfile-textarea" name="content"></textarea>
            <div class="yourProfile-btn">
              <button type="submit">Save</button>
            </div>
          </form>
          <?php include '../masterpages/dashboard02.php' ?>
          <!-- FOOTER -->
    <?php include '../masterpages/footer.php' ?>

    <?php

if($_SERVER['REQUEST_METHOD']=='POST'){
  $_SESSION['timeout'] = time()+900;
  
  if(uploadfile('./img/profile_img/','profImg')=='true'){
    unlink("./img/profile_img/".$user['profImg']);
    $profImg = $_FILES['profImg']['name'];
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES);
  
    $useremail = $user['email'];
    $profCmd = "UPDATE user_tb SET profImg='".$profImg."', profileContent='".$content."' WHERE email='$useremail'";
    if($dbCon->query($profCmd) === true){
      $dbCon->close();
      header("Location: http://localhost/fproject/pages/yourpost.php");
    }
    echo $dbCon->error;
  }
}
?>

</body>
</html>