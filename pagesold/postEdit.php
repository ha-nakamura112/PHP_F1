<?php
//need check
  include '../configfinal.php';
  session_start();
  $dbCon = new mysqli($dbSeverName,$dbUserName,$dbpass,$dbname);
  if($dbCon->connect_error){
    die("connection error");
  }


  if(!isset($_SESSION['post_id'])){
    header("Location: http://localhost/fproject/loginCon.php"); //loginpage
  }else{
    $post = $_SESSION['post_id'];
  }

?>

<?php include '../masterpages/loggedInHeader.php'
  ?>
  <main>
  <?php include '../masterpages/dashboard01.php' ?>
    <!-- should change action -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <label for="postImg">Image</label>
        <article>
          <label for="postImg">select your file<i class="fa-solid fa-file-arrow-up"></i></label>
          <input type="file"  name="postImg" required>
        </article>
      <label for="title">Title</label>
      <input type="text" name="title" value="<?php echo $post['title']; ?>">
      <label for="date">Date</label>
      <input type="date" name="date"  value="<?php echo time(); ?>"> 
      <!-- should change format of time -->
      <label for="content">Content</label>
      <textarea name="content" value="<?php echo $post['content']; ?>" ></textarea>

      <!-- check -->

      <div>
        <button type="submit">Save</button>
      </div>
    </form>
    <?php include '../masterpages/dashboard02.php' ?>
 <!-- FOOTER -->
<?php include '../masterpages/footer.php' ?> 


<?php
 if($_SERVER['REQUEST_METHOD']=='POST'){
  $updateCmd = "UPDATE post_tb SET title='".$_POST['title']."',postContent='".$_POST['content']."',p_date='".$_POST['p_date']."'";

  if($dbCon->query($updateCmd) === true){
    $dbCon->close();
    echo "<h5>saved<h5>"; 
  }else{
    echo "failed";
  }
 }
?>
</body>
</html>