<?php
//!important
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

  if(isset($_GET['user'])){
    $deleteCmd = "DELETE FROM post_tb WHERE post_id ='".$_GET['user']."'";
    if($dbCon->query($deleteCmd)===true){
      header("Location: http://localhost/fproject/pages/adminPost.php");
    }
    echo $dbCon->error;
  }

  $postArray = [];
  $postCmd = "SELECT * FROM post_tb";
  $result = $dbCon->query($postCmd);
  if($result->num_rows > 0){
    $postData = $result->fetch_assoc();
    while($row = $result->fetch_assoc()){
      array_push($postArray,$row);
    }
  }

?>

<?php
  include '../masterpages/loggedInHeader.php';
  ?>
<main class="adminPost-main">
<?php
  include '../masterpages/dashboard01admin.php';
  ?>

  <?php
    echo "<table><thead><tr>";
    foreach($postData as $fieldName => $value){
      echo "<th>".$fieldName."</th>";
    }
    echo "<th>Delete</th>";
    echo "</tr><thead><tbody>";

    foreach($postArray as $post){
      echo "<tr>";
      foreach($post as $postDetail){
        echo "<th>".$postDetail."</th>";
      }
      echo "<td><a href='./adminPost.php?user=".$post['post_id']."'>Delete</a></td>";
    }
      echo "</tr>";
      echo "</tbody></table>";
  ?>

<?php
  include '../masterpages/dashboard02.php';
  ?>
<!-- FOOTER -->
<?php include '../masterpages/footer.php' ?>
</body>
</html>