<?php
include '../configfinal.php';
session_start();
$dbCon = new mysqli($dbSeverName, $dbUserName, $dbpass, $dbname);
if ($dbCon->connect_error) {
  die("connection error");
}

if (!isset($_SESSION['user'])) {
  header("Location: http://localhost/fproject/pages/loginCon.php"); //loginpage
} else {
  $email = $_SESSION['user'];
  $logCmd = "SELECT * FROM user_tb WHERE email='$email'";
  $useresult = $dbCon->query($logCmd);
  if ($useresult->num_rows > 0) {
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
  <form class="accountSetting-form" method="POST" action="#" enctype="multipart/form-data">
    <h5>
      <div class="required">*</div>is required
    </h5>
    <section class="accountSetting-section">
      <div class="accoutSetting-name">
        <aside>
          <label for="fname">First Name</label>
          <?php
          echo '<input type="text" name="fname" value="' . $user['firstName'] . '">';
          ?>
        </aside>
        <aside>
          <label for="lname">Last Name</label>
          <?php
          echo '<input type="text" name="lname" value="' . $user['lastName'] . '">';
          ?>
        </aside>
    </section>
    <section class="accountSetting-section">
      <label for="atype">Select your account type<div class="required">*</div></label>
      <select name="atype" required>
        <option selected disabled></option>
        <option>Landord</option>
        <option>Student</option>
      </select>
    </section>
    <section class="accountSetting-section">
      <label for="dob">Date of birth</label>
      <?php
      echo '<input type="text" name="dob" value="' . $user['dob'] . '">';
      ?>
    </section>
    <section class="accountSetting-section">
      <label for="email">Email</label>
      <?php
      echo '<input type="email" name="email" value="' . $user['email'] . '" placeholder ="example@tamhousing.jp">';
      ?>
    </section>
    <!-- should change pass and confirm -->
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
          echo '<input type="file" name="profImg" value="' . $user['profImg'] . '">';
          ?>
        </article>
      </section>
      </section>
      <section class="accountSetting-section">
        <label for="refImg">References(email confirmed)</label>
        <article>
          <?php
          echo '<input type="file" name="refImg" value="' . $user['refImg'] . '">';
          ?>
        </article>
      </section>
      <section class="accountSetting-section">
        <label for="tamImg">References(from Tamwood)</label>
        <article>
          <?php
          echo '<input type="file" name="tamImg" value="' . $user['tamImg'] . '">';
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
  include '../masterpages/footer.php';
  ?>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // check order and edit
    if ($_FILES['refImg'] != " " && $_FILES['tamImg'] != "") {
      $badge1 = 'b';
      $badge2 = 'b';
    } elseif ($_FILES['refImg'] != " " && $_FILES['tamImg'] == "") {
      $badge1 = 'b';
      $badge2 = "a";
    } elseif ($_FILES['refImg'] == " " && $_FILES['tamImg'] != "") {
      $badge1 = "a";
      $badge2 = 'b';
    }

    $updateCmd = "UPDATE user_tb SET firstName='" . $_POST['fname'] . "',lastName='" . $_POST['lname'] . "',atype='" . $_POST['atype'] . "',dob='" . $_POST['dob'] . "',email='" . $_POST['email'] . "',pass='" . $_POST['pass'] . "',profImg='" . $_FILES['profImg']['name'] . "',refImg='" . $_FILES['refImg']['name'] . "',badge1='" . $badge1 . "',tamImg='" . $_FILES['tamImg']['name'] . "',badge2='" . $badge2 . "' WHERE user_id='" . $user['user_id'] . "'";


    if ($dbCon->query($updateCmd) === true) {
      $dbCon->close();
      echo "<h5>saved<h5>";
    } else {
      echo "failed";
    }
  }
  ?>

  </body>

  </html>