<?php
  include './configfinal.php';

  if(!isset($_SESSION['user']) || $_SESSION['timeout'] < time()){
    header("Location: http://localhost/fproject/pages/loginCon.php"); //loginpage
  }else{
    $email = $_SESSION['user'];
    $logCmd = "SELECT * FROM user_tb WHERE email='$email'";
    $useresult = $dbCon->query($logCmd);
    if($useresult->num_rows > 0){
      $user = $useresult->fetch_assoc();
    }
  }

  ?>

<?php
include '../masterpages/loggedInHeader.php';
?>
  <main class="accountSetting-main">
    <!-- Side Nav on dashboard -->
    <?php
  include '../masterpages/dashboard01.php';
  ?>
  <!-- should change inside of action -->
  <form   class="accountSetting-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <h5><div class="required">*</div>is required</h5>
    <section class="accountSetting-section">
      <div class="accoutSetting-name">
      <aside>
        <label for="fname">First Name</label>
       <?php
         echo '<input type="text" name="fname" value="'.$user['firstName'].'">';
       ?>
      </aside>
      <aside>
        <label for="lname">Last Name</label>
        <?php
         echo '<input type="text" name="lname" value="'.$user['lastName'].'">';
       ?>
      </aside>
      </div>
    </section>
    <label for="atype">Select your account type<div class="required">*</div></label>
    <select name="atype" required>
      <option selected disabled></option>
      <option>Landord</option>
      <option>Student</option>
    </select>
    <section class="accountSetting-section">
    <label for="dob">Date of birth</label>
    <?php
         echo '<input type="text" name="dob" value="'.$user['dob'].'">';
       ?>
     </section>
     <section class="accountSetting-section">
    <label for="email">Email</label>
    <?php
         echo '<input type="email" name="email" value="'.$user['email'].'" placeholder ="example@tamhousing.jp">';
       ?>
      </section>
    <section class="accountSetting-section">
    <label for="pass">Password<div class="required">*</div></label>
    <?php
         echo '<input type="password" name="pass"  required>';
       ?>
     </section>
     <section class="accountSetting-section">
    <section class="pic">
      <label for="profImg">Profile Picture</label>
      <article>
      <?php
         echo '<input type="file" name="profImg">';
       ?>
      </article>
      </section>
      </section>
      <section class="accountSetting-section">
      <label for="refImg">References(email confirmed)</label>
      <article>
      <?php
         echo '<input type="file" name="refImg" value="'.$user['refImg'].'">';
       ?>
      </article>
      <label for="tamImg">References(from Tamwood)</label>
      <article>
      <?php
         echo '<input type="file" name="tamImg" value="'.$user['tamImg'].'">';
       ?>
      </article>
    </section>
    <section class="accountSetting-btn">
      <button class="save-btn" type="submit">Save</button>
    </section>
  </form>
  <!-- Dashboard closing -->
  <?php
  include '../masterpages/dashboard02.php';
  ?>
  <!-- FOOTER -->

<?php 
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $_SESSION['timeout'] = time()+900;
    
    if(!is_uploaded_file($_FILES['profImg']['tmp_name'])){
      $profImg = $user['profImg'];
    }else{
      if(uploadfile('./img/profile_img/','profImg')=='true'){
        unlink("./img/profile_img/".$user['profImg']."");
        $profImg = $_FILES['profImg']['name'];
      }else{
        echo '<div class= "account-saved"><h4>upload error<h4></div>';
      }
    }
    //if user already submitted document and it's still waiting
    if(isset($user['refImg']) && $user['badge1'] != 'verified'){
      //file name is updated or still same, and badge1 is waiting
      $refImg = $_FILES['refImg']['name'];
      $badge1 ='waiting';
    }else{
      //if there is no document and then user submit document
      if(uploadfile('./img/ref_img/','refImg')=='true'){
        $refImg = $_FILES['refImg']['name'];
        $badge1 ='waiting';
      }else{
        $refImg = "";
        $badge1 ='unsubmitted';
      }
    }
    if(isset($user['tamImg']) &&  $user['badge2'] != 'verified'){
      $tamImg = $_FILES['tamImg']['name'];
      $badge2 = 'waiting';
    }else{
      if(uploadfile('./img/tam_img/','tamImg')=='true'){
        $tamImg = $_FILES['tamImg']['name'];
        $badge2 = 'waiting';
      }else{
        $tamImg = '';
        $badge2 ='unsubmitted';
      }
    }
    
    if(password_verify($_POST['pass'],$user['pass'])){
      $pass = password_hash($_POST['pass'],PASSWORD_BCRYPT,["cost"=>5]); 
      $updateCmd = "UPDATE user_tb SET firstName='".$_POST['fname']."',lastName='".$_POST['lname']."',atype='".$_POST['atype']."',dob='".$_POST['dob']."',email='".$_POST['email']."',pass='".$pass."',profImg='".$profImg."',refImg='".$refImg."',badge1='".$badge1."',tamImg='".$tamImg."',badge2='".$badge2."' WHERE user_id='".$user['user_id']."'";
      
      if($dbCon->query($updateCmd) === true){
        $dbCon->close();
        echo '<div class= "account-saved"><i class="fa-solid fa-circle-check"></i><h4>saved<h4></div>'; 
      }else{
        echo '<div class= "account-saved"><h4>failed<h4></div>';
      }
    }
  }
  ?>

  <?php
  include '../masterpages/footer.php';
  ?>
  </body>
  </html>