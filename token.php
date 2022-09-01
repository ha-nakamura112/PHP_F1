<?php
// to make rondom binary and convert it into a hexadecimal string representation
  $token_rondom = openssl_random_pseudo_bytes(16);
  $token = bin2hex($token_rondom);

  $_SESSION['token'] = $token;
?>