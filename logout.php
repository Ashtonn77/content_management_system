<?php require_once("Includes/functions.php"); ?>
<?php require_once("Includes/session.php"); ?>
<?php
$_SESSION['id'] = null;
$_SESSION['username'] = null;
$_SESSION['adminName'] = null;
session_destroy();
redirectTo('login.php')
?>