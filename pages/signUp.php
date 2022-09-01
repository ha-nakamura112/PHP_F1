<?php
  include '../configfinal.php';

  if(!isset($_SESSION['token'])){
    $token_rondom = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token_rondom);
    $_SESSION['token'] = $token;
  }
?>

<?php
include '../masterpages/logOutHeader.php';
?>
  <main class="signUp-main">
    <h1>Sign up</h1>
    <!-- should change inside of action -->
    <form class="accountSetting-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
      <h5>
        <div class="required">*</div>is required
      </h5>
      <section class="accountSetting-section">
      <div class="accoutSetting-name">
        <aside>
          <label for="fname">First Name <div class="required">*</div></label>
          <input type="text" name="fname">
        </aside>
        <aside>
          <label for="lname">Last Name<div class="required">*</div></label>
          <input type="text" name="lname">
        </aside>
      </div>
      </section>
      <section  class="accountSetting-section">
      <label for="atype">Select your account type<div class="required">*</div></label>
      <select name="atype">
        <option selected disabled></option>
        <option>Landlord</option>
        <option>Student</option>
        <option>Admin</option>
      </select>
      </section>
      <section  class="accountSetting-section">
      <label for="dob">Date of birth<div class="required">*</div></label>
      <input type="date" name="dob">
      <label for="email">Email<div class="required">*</div></label>
      <input type="email" name="email" placeholder="example@woodhousing.com">
      </section>
      <!-- should change pass and confirm -->
      <section  class="accountSetting-section">
      <label for="pass">Password<div class="required">*</div></label>
      <input type="password" name="pass">
      </section>
      <section  class="accountSetting-section">
      <label for="conPass">Password confirm<div class="required">*</div></label>
      <input type="password" name="conPass">
      </section>
      <section class="accountSettoing-pic">
        <!-- test for accepting img -->
        <!-- required makes this input mandatory -->
        <label for="profImg">Profile Picture<div class="required">*</div></label>
        <article>
   
          <input type="file" name="profImg" accept="image/*" required>
        </article>

        <label for="refImg">References(email confirmed)</label>
        <article>
          
          <input type="file" name="refImg" value="">
          <!-- <input type="hidden" name="badge1" value="b"> -->
        </article>
        <label for="tamImg">References(from Tamwood)</label>
        <article>
          <input type="file" name="tamImg" value="">
        </article>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
      </section>
      <section class="signUp-btn-wrap">
        <button class="signUp-btn" type="submit">Sign up</button>
      </section>
    </form>
    <div class="moveToLogin">
    <a href="./loginCon.php">Do you have an account?</a>
  </div>
<!-- FOOTER -->
<?php
  include '../masterpages/footer.php';
  ?>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
  //check token to verify 
  if(isset($_POST['token']) && $_POST['token'] === $_SESSION['token']){
    if($_POST['fname'] != '' && $_POST['lname'] != '' && $_POST['atype'] != '' && $_POST['dob'] != '' && $_POST['email'] != '' && $_POST['conPass'] != '' && $_POST['pass'] != '' && $_FILES['profImg'] != '' ){
      if(!filter_var(filter_var($_POST["email"],FILTER_SANITIZE_EMAIL),FILTER_VALIDATE_EMAIL)){
        echo 'invalid';
      }else{
        $fname = $_POST['fname'];
        $lname = $_POST['lname']; 
        $atype = $_POST['atype'];
        $dob = $_POST['dob']; 
        $email = $_POST['email'];
    
        // $profdestDir = './img/profile_img/';
        // $refdestDir = './img/ref_img/';
        // $tamdestDir = './img/tam_img/';
        //you don't need to if it's upload or not,but if it's uploaded should
        if (is_uploaded_file($_FILES['profImg']['tmp_name'])){
          if(uploadfile('./img/profile_img/','profImg')==='true'){
          $profImg = $_FILES['profImg']['name'];
          }
          $refImg = $_FILES['refImg']['name'];
          $tamImg = $_FILES['tamImg']['name'];
          }
          // to check if there are values in $refImg & $tamImg to give user badge
          if(file_size('refImg') == true && file_size('tamImg') == true){
            $badge1 = 'waiting';
            $badge2 = 'waiting';
          }elseif(file_size('refImg') == true && file_size('tamImg') != true){
            $badge1 = 'waiting';
            $badge2 = 'unsubmitted';
          }elseif(file_size('refImg') != true && file_size('tamImg') == true){
            $badge1 = 'waiting';
            $badge2 = 'unsubmitted';
          }

        $_SESSION['timeout'] = time()+900;

        if($_POST['pass'] != $_POST['conPass']){
          echo 'password confirmation is not valid';
        }else{
          if(strlen($_POST['pass']) < 8){
            echo '<h1>password should be more longer</h1>';
          }else{

          $pass = password_hash($_POST['pass'],PASSWORD_BCRYPT,["cost"=>5]); 
          $insertCmd = "INSERT INTO user_tb(firstName, lastName, atype, dob, email, pass, profImg, refImg, badge1, tamImg, badge2,profileContent) VALUES ('$fname','$lname','$atype','$dob','$email','$pass','$profImg','$refImg','$badge1','$tamImg','$badge2','no posted')"; 
            if($dbCon->query($insertCmd)){
            echo "<h1>Succesfully</h1>";
            $_SESSION['user'] = $email;
        
            if($atype == 'Admin'){
            $dbCon->close();
            header("Location: http://localhost/fproject/pages/adminuser.php");// adminHP
            }else{
              $dbCon->close();
              header("Location: http://localhost/fproject/pages/yourpost.php"); //userHp
            }
            }
          }
        }
      }
    }else{
      echo 'fill out every answers';
    }   
  }else{
    echo 'invalid';
  }
}

?>


  </body>
  </html>