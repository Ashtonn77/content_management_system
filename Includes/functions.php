<?php require_once("Includes/db.php"); ?>
<?php
function redirectTo($newLocation)
{
    header('Location:' . $newLocation);
    exit;
}
function checkIfUsernameExists($username)
{
    global $connectingDb;
    $sql = "SELECT username FROM admins WHERE username=:Username";
    $stmt = $connectingDb->prepare($sql);
    $stmt->bindValue(':Username', $username);
    $stmt->execute();
    $result = $stmt->rowCount();
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}
