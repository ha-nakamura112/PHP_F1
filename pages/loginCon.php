<?php
include '../configfinal.php';

// to make rondom binary and convert it into a hexadecimal string representation
if(!isset($_SESSION['token'])){
  $token_rondom = openssl_random_pseudo_bytes(16);
  $token = bin2hex($token_rondom);
  $_SESSION['token'] = $token;
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
                        <!-- to make token in hidden input -->
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
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
        //check token to verify 
        if(isset($_POST['token']) && $_POST['token'] === $_SESSION['token']){
          if(!isset($_POST['email']) || !isset($_POST['pass'])){
            echo 'input all sections';
          }elseif(!filter_var(filter_var($_POST["email"],FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL)){
            echo 'Invalid';
          }else{

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
              header("Location: http://localhost/fproject/pages/adminuser.php"); 
              //adminHP
            }elseif($userDetails['atype']=="Student" || $userDetails['atype']=="Landlord"){ 
              header("Location: http://localhost/fproject/pages/yourpost.php");
            }
          }else{
            echo 'invalid';
         }
        }    
      }
    }
    echo 'invalid';
  }
    ?>
</body>
</html>