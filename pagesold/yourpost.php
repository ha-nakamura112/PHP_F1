<?php
  include '../configfinal.php';
  session_start();

  $dbCon = new mysqli($dbSeverName,$dbUserName,$dbpass,$dbname);
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
    switch($_GET['action']){
      case 'edit': 
        //should change
        $userid = $user['user_id'];
        $editCmd = "SELECT * FROM post_tb WHERE user_id= '$userid'";
        $result = $dbCon->query($editCmd);
        $postData = $result->fetch_assoc();
        $_SESSION['post_id']=$postData['post_id'];

        header("Location: http://localhost/fproject/pages/postEdit.php");//postedit
      break;

      case 'delete':
        print_r($postDetail);
        $deleteCmd = "DELETE FROM post_tb WHERE post_id = $postDetail[0]['title']";
        $dbCon->query($deleteCmd);

        header("Location: http://localhost/fproject/pages/yourpost.php");
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
  //should change file place
    if(isset($postArray)){
      foreach($postArray as $postDetail){
        echo '<article class="postList-article"><div class="your-post-wrap">';
        echo '<img src="./img/'.$postDetail['imgName'].'">';
        echo '<div class="your-post-article"><h4>'.$postDetail['title'].'</h4><div><time>'.$postDetail['p_date'].'</time><aside><a class="edit" href="http://localhost/fproject/pages/yourpost.php?action=edit">Edit</a><a  class= "delete" href="./yourpost.php?action=delete">Delete</a></aside></div><p>'.$postDetail['postContent'].'</p>';
        //html changed span to a
        echo '</div></div></article>';
      }else{
        
      }
        echo "you haven't posted";
      }
    }
  ?>
      <a  class= "delete" href="./yourpost.php?action=delete">Delete</a>

    </div>  
    <?php include '../masterpages/dashboard02.php' ?>

<!-- FOOTER -->
<?php include '../masterpages/footer.php' ?>


</body>
</html>