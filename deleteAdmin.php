<?php require_once("Includes/db.php"); ?>
 <?php require_once("Includes/functions.php"); ?>
 <?php require_once("Includes/session.php"); ?>
 <?php
    if (isset($_GET['id'])) {
        $searchQueryParameter = $_GET['id'];
        $adminName = $_SESSION['adminName'];
        global $connectingDb;
        $sql = "DELETE FROM admins WHERE id='$searchQueryParameter'";
        $execute = $connectingDb->query($sql);

        if ($execute) {
            $_SESSION['successMessage'] = "Admin removed!";
            redirectTo('admins.php');
        } else {
            $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
            redirectTo('admins.php');
        }
    }

    ?>