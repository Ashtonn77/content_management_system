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

function loginAttempt($username, $password)
{
    global $connectingDb;
    $sql = "SELECT * FROM admins WHERE username=:Username AND password=:Password LIMIT 1";
    $stmt = $connectingDb->prepare($sql);
    $stmt->bindValue(':Username', $username);
    $stmt->bindValue(':Password', $password);

    $stmt->execute();
    $result = $stmt->rowCount();

    if ($result == 1) {
        return $foundRecord = $stmt->fetch();
    } else {
        return null;
    }
}
function confirmLogin()
{
    if (isset($_SESSION['id'])) {
        return true;
    } else {
        $_SESSION['errorMessage'] = "Login required!";
        redirectTo('login.php');
    }
}
