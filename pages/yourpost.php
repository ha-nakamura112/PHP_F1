<?php
  include '../configfinal.php';

  $dbCon = new mysqli($dbServerName,$dbUserName,$dbpass,$dbname);
if($dbCon->connect_error){
  die("connection error");
}
  if(!isset($_SESSION['user'])){
    header("Location: http://localhost/fproject/pages/loginCon.php"); //loginpage
  }
    $email = $_SESSION['user'];
    $logCmd = "SELECT * FROM user_tb WHERE email='$email'";
    $useresult = $dbCon->query($logCmd);
    if($useresult->num_rows > 0){
      $user = $useresult->fetch_assoc();
    }

    $postArray = [];
    $userid = $user['user_id'];
    $postCmd = "SELECT * FROM post_tb WHERE user_id = '$userid'";
    $result = $dbCon->query($postCmd);
    while($row = $result->fetch_assoc()){
      array_push($postArray,$row);
    }


  if(isset($_GET['action'])){
    $userid = $user['user_id'];
    $editCmd = "SELECT * FROM post_tb WHERE user_id= '$userid'";
    $result = $dbCon->query($editCmd);
    $postData = $result->fetch_assoc();
    $_SESSION['post_id']=$postData['post_id'];

    switch($_GET['action']){
      case 'edit': 
        header("Location: http://localhost/fproject/pages/postEdit.php");
      break;

      case 'delete':
        $postid = $postData['post_id'];
        $deleteCmd = "DELETE FROM post_tb WHERE post_id = '$postid'";
        if($dbCon->query($deleteCmd)===true){
          header("Location: http://localhost/fproject/pages/yourpost.php");
        }
        echo $dbCon->error;
      break;
    }
  }

?>



<?php include '../masterpages/loggedInHeader.php'
  ?>

  <!-- DASHBOARD -->
  <main class="yourPost-main">
  <?php include '../masterpages/dashboard01.php' ?>

  <?php
  
      if(!empty($postArray)){ // to check if the array is empty or not
        foreach($postArray as $postDetail){
          echo '<article class="postList-article"><div class="your-post-wrap">';
          echo '<img src="./img/post_img/'.$postDetail['imgName'].'">';
          echo '<div class="your-post-article"><h4>'.$postDetail['title'].'</h4><div><time>'.$postDetail['p_date'].'</time><aside><a class="edit" href="http://localhost/fproject/pages/yourpost.php?action=edit">Edit</a><a class= "delete" href="http://localhost/fproject/pages/yourpost.php?action=delete">Delete</a></aside></div><div class="yourPost-p"><p>'.$postDetail['postContent'].'</p>';
          echo '</div></div></div></article>';
        }
      }else{
        echo " <h4 class='yourposth4'>You haven't posted yet!</h4>";
      }
    
  ?>

    </div>  
    <?php include '../masterpages/dashboard02.php' ?>
<!-- FOOTER -->
<?php include '../masterpages/footer.php' ?>


</body>
</html>