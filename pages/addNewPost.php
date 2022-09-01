<?php
  include '../configfinal.php';

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
  // timeout(time(),$dbCon);
  // to reset timeout is it correct?
  ?>


<?php
  include '../masterpages/loggedInHeader.php';
  ?>

  <main>
  <?php
    include '../masterpages/dashboard01.php';
    ?>
    <!-- should change action -->
  <form class="addNewPost-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <label for="postImg">Image</label>
      <article class="addNewPost-article">
          <input type="file"  name="postImg" required>
        </article>
      <label for="title">Title</label>
      <input type="text" name="title" required>
      <label for="date">Date</label>
      <input type="date" name="date" required>
      <label for="content">Content</label>
      <textarea name="content" required></textarea>

      <div class="addNewPost-btn">
        <button type="submit">Save</button>
      </div>
  </form>
  <?php
    include '../masterpages/dashboard02.php';
    ?>
  <?php
    include '../masterpages/footer.php';
    ?>
  
  
<?php 
  // if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['title']!='' && $date = $_POST['date']!= '' && $_POST['content']!=''){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        if(uploadfile('./img/post_img/','postImg')==='true'){

          $title = $_POST['title'];
          $date = $_POST['date'];
          $postImg = $_FILES['postImg']['name'];
          $content = htmlspecialchars($_POST['content']);
          $userid = $user['user_id'];
 
          $postCmd = "INSERT INTO post_tb(title, postContent,user_id, p_date, imgName) VALUES ('".$title."','".$content."','".$userid."','".$date."','".$postImg."')"; 
          if($dbCon->query($postCmd)){
             echo "<h4>Posted!</h4>";
            $_SESSION['user'] = $email;
            $dbCon->close();
          }else{
              echo "<h3>Image is too big</h3>";
          }
        }else{
          echo "<h3>Please Upload an Image</h3>";
        }
      }   
?>

</body>
</html>