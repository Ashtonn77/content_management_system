<?php require_once("Includes/db.php"); ?>
 <?php require_once("Includes/functions.php"); ?>
 <?php require_once("Includes/session.php"); ?>
 <?php
    if (isset($_GET['id'])) {
        $searchQueryParameter = $_GET['id'];
        $adminName = $_SESSION['adminName'];
        global $connectingDb;
        $sql = "UPDATE comments SET status='OFF', approvedby='$adminName' WHERE id='$searchQueryParameter'";
        $execute = $connectingDb->query($sql);

        if ($execute) {
            $_SESSION['successMessage'] = "Comment disapproved!";
            redirectTo('comments.php');
        } else {
            $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
            redirectTo('comments.php');
        }
    }

    ?>