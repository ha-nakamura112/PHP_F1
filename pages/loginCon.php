<?php
include '../configfinal.php';

$dbCon = new mysqli($dbServerName,$dbUserName,$dbpass,$dbname);
if($dbCon->connect_error){
  die("connection error");
}

?>

<?php
include '../masterpages/logOutHeader.php';
?>
    <main class="login-main">
        <article class="login-article01">
            <h1>
                login
            </h1>
        </article>
        <article class="login-article02">
            <form class="login-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="title">Email</label>
                <input type="email" name="email" placeholder="  example@woodhousing.com">
                <label for="pass">Password</label>
                <input type="password" name="pass">
                <button type="submit">LogIn</button>
                <a href="./signUp.php">Create an account</a>
            </form>
        </article>
    </main>
      <!-- FOOTER -->
  <?php
  include '../masterpages/footer.php';
  ?>
    <?php
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['email'];
        $pass = $_POST['pass'];
        
        $logCmd = "SELECT * FROM user_tb WHERE email= '$username'";
        $result = $dbCon->query($logCmd);
        if($result->num_rows > 0){
          $userDetails = $result->fetch_assoc();
          $hashpass = $userDetails['pass'];
          if(password_verify($pass,$hashpass)){
            $_SESSION['user'] = $username;
  
            $dbCon->close();
            $_SESSION['timeout'] = time()+900;

            if($userDetails['atype']=="Admin"){
              header("Location: http://localhost/pages/fproject/adminuser.php"); //adminHP
            }elseif($userDetails['atype']=="Student" || $userDetails['atype']=="Landlord"){ 
              header("Location: http://localhost/pages/fproject/yourpost.php");
            }
          }else{
            echo 'invalid';
         }
        }    
      }
    ?>
</body>
</html>