<!-- add two hidden forms,1's value badge1 +3 default: a:edit -->
<?php
  include '../configfinal.php';
  session_start();
  $dbCon = new mysqli($dbSeverName,$dbUserName,$dbpass,$dbname);
  if($dbCon->connect_error){
    die("connection error");
  }
?>

<?php
include '../masterpages/logOutHeader.php';
?>

  <main class="signUp-main">
    <h1>Sign up</h1>
    <!-- should change inside of action -->
    <form  class="accountSetting-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
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
          
          <input type="file" name="refImg">
          <!-- <input type="hidden" name="badge1" value="b"> -->
        </article>
        <label for="tamImg">References(from Tamwood)</label>
        <article>
          <input type="file" name="tamImg">
        </article>
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

  if($_POST['fname'] != '' && $_POST['lname'] != '' && $_POST['atype'] != '' && $_POST['dob'] != '' && $_POST['email'] != '' && $_POST['conPass'] != '' && $_POST['pass'] != '' && $_FILES['profImg'] != '' ){
    $fname = $_POST['fname'];
    $lname = $_POST['lname']; 
    $atype = $_POST['atype'];
    $dob = $_POST['dob']; 
    $email = $_POST['email'];
    
    //should check img
    $profdestDir = './img/profile_img/';
    if(uploadfile($profdestDir,'profImg')==='true'){
      $profImg = $_FILES['profImg']['name'];
      $refImg = $_FILES['refImg']['name'];
      $tamImg = $_FILES['tamImg']['name'];
    }

    $_SESSION['timeout'] = time()+900;
    if($_POST['pass'] == $_POST['conPass']){
        $pass = password_hash($_POST['pass'],PASSWORD_BCRYPT,["cost"=>5]); 
        // I hash pass here,is it correct?or after like when you store value
      }else{
        echo 'password confirmation is not valid';
      }
      
      // to check if there are values in $refImg & $tamImg to give user badge
      if($refImg !=" " && $tamImg != ""){
        //user can get 2 pending badge(value=b)
        $badge1 = 'b';
        $badge2 = 'b';
      }elseif($refImg !=" " && $tamImg == ""){
        //user can get 1 panding badge(value=b)
        $badge1 = 'b';
        $badge2 = "a";
      }elseif($refImg ==" " && $tamImg != ""){
        //user can get 1 panding badge(value=b)
        $badge1 = "a";
        $badge1 = 'b';
      }
      
      $insertCmd = "INSERT INTO user_tb(firstName, lastName, atype, dob, email, pass, profImg, refImg, badge1, tamImg, badge2,profileContent) VALUES ('$fname','$lname','$atype','$dob','$email','$pass','$profImg','$refImg','$badge1','$tamImg','$badge2','no posted')"; 
      if($dbCon->query($insertCmd)){
        echo "<h1>Succesfully</h1>"; //checkmark icon 
        $_SESSION['user'] = $email;
      
        if($atype == 'Admin'){
          $dbCon->close();
          header("Location: http://localhost/fproject/adminuser.php");// adminHP
        }else{
          $dbCon->close();
          header("Location: http://localhost/fproject/yourpost.php"); //userHp
        }
      }else{
        echo "<h1>database error</h1>";
      }
      $dbcon->close();
      } 
    }

?>

  </body>
  </html>