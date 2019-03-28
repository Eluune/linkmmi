<?php
session_start();
session_destroy();

  //$_SESSION['id'] = -1;

  header('location:../');
  exit;
?>
