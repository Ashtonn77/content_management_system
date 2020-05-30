<?php require_once("Includes/db.php"); ?>
 <?php require_once("Includes/functions.php"); ?>
 <?php require_once("Includes/session.php"); ?>
 <?php
    if (isset($_GET['id'])) {
        $searchQueryParameter = $_GET['id'];
        $adminName = $_SESSION['adminName'];
        global $connectingDb;
        $sql = "DELETE FROM category WHERE id='$searchQueryParameter'";
        $execute = $connectingDb->query($sql);

        if ($execute) {
            $_SESSION['successMessage'] = "Category deleted!";
            redirectTo('categories.php');
        } else {
            $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
            redirectTo('categories.php');
        }
    }

    ?>