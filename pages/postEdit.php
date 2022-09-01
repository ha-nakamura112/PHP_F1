<?php
  include './configfinal.php';

  if(!isset($_SESSION['post_id'])){
    header("Location: http://localhost/fproject/pages/loginCon.php"); //loginpage
  }else{
    $post = $_SESSION['post_id'];
    $logCmd = "SELECT * FROM post_tb WHERE post_id='$post'";
    $postresult = $dbCon->query($logCmd);
    if($postresult->num_rows > 0){
      $userPost = $postresult->fetch_assoc();
    }else{
      echo $dbCon->error;
    }
  }

?>

<?php include '../masterpages/loggedInHeader.php'
  ?>
  <main class='postedit'>
    <!-- should change action -->
    <?php include '../masterpages/dashboard01.php' ?>
    <form class="postEdit-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <img src="<?php echo './img/post_img/'.
          $userPost['imgName'];?>">
      <label for="postImg">Image</label>
        <article>
          <input type="file"  name="postImg" required>
        </article>
      <label for="title">Title</label>
      <input type="text" name="title" value="<?php echo $userPost['title']; ?>">
      <label for="date">Date</label>
      <input type="date" name="date"  value="<?php echo date("Y-m-d"); ?>"> 

      <label for="content">Content</label>
      
      <textarea name="content" ><?php echo $userPost['postContent']; ?></textarea>

      <!-- check -->

      <div>
        <button type="submit">Save</button>
      </div>
    </form>
    <?php include '../masterpages/dashboard02.php' ?>
<!-- FOOTER -->
<?php include '../masterpages/footer.php' ?>
  
</body>
</html>

<?php
 if($_SERVER['REQUEST_METHOD']=='POST'){
  if(uploadfile('./img/post_img/','postImg')==='true'){
    $postImg = $_FILES['postImg']['name'];
    $updateCmd = "UPDATE post_tb SET title='".$_POST['title']."',postContent='".$_POST['content']."',p_date='".$_POST['date']."',imgName='".$postImg."'  WHERE post_id = '$post'";
  
    if($dbCon->query($updateCmd) === true){
      $dbCon->close();
      echo "<h5>saved<h5>"; 
    }else{
      echo $dbCon->error;
    }
  }
 }
?>