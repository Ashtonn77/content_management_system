<?php require_once("Includes/db.php"); ?>
<?php require_once("Includes/functions.php"); ?>
<?php require_once("Includes/session.php"); ?>
<?php confirmLogin(); ?>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $admin = $_SESSION['username'];
    $currentTime = time();
    $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);

    global $connectingDb;

    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $_SESSION['errorMessage'] = "All fields must be filled";
        redirectTo('admins.php');
    } elseif (strlen($password) < 4) {
        $_SESSION['errorMessage'] = "Your password should be more than 3 characters long";
        redirectTo('admins.php');
    } elseif ($password != $confirmPassword) {
        $_SESSION['errorMessage'] = "Passwords do not match";
        redirectTo('admins.php');
    } elseif (checkIfUsernameExists($username)) {
        $_SESSION['errorMessage'] = "Username taken...try another";
        redirectTo('admins.php');
    } else {
        //query to insert new admin in db
        $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
        $sql .= "VALUES(:DateTime,:Username,:Password,:Aname,:AddedBy)";

        $stmt = $connectingDb->prepare($sql);
        $stmt->bindValue(':DateTime', $dateTime);
        $stmt->bindValue(':Username', $username);
        $stmt->bindValue(':Password', $password);
        $stmt->bindValue(':Aname', $name);
        $stmt->bindValue(':AddedBy', $admin);
        $execute = $stmt->execute();

        if ($execute) {
            $_SESSION['successMessage'] = "New admin added successfully :)";
            redirectTo('admins.php');
        } else {
            $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
            redirectTo('admins.php');
        }
    } //end if category

} //end if isset

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Admin Page</title>
    <script src="https://kit.fontawesome.com/2c1c0f2ad6.js" crossorigin="anonymous"></script>
</head>

<body>
    <div style="height: 1.5px; background: lightslategray;"></div>
    <!--NAVBAR START-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a href="#" class="navbar-brand">
                <div style="font-size: 0.5rem;"><i class="fab fa-centos fa-5x text-secondary"></i></div>
            </a>

            <button class="navbar-toggler" data-toggle='collapse' data-target='#navbarCollapseCMS'>
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--when shrinking screen size-->
            <div class="collapse navbar-collapse" id="navbarCollapseCMS">

                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a href="myProfile.php" class="nav-link"><i class="far fa-user text-success"></i>&nbsp; My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="admins.php" class="nav-link">Manage admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="liveBlog.php?page=1" class="nav-link">Live Blog</a>
                    </li>

                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout &nbsp; <i class="fas fa-sign-out-alt text-danger"></i> </a>
                    </li>
                </ul>

            </div>

        </div>
    </nav>
    <!--NAVBAR END-->
    <div style="height: 1.5px; background: lightslategray;"></div>

    <!--HEADER-->
    <header class="bg-dark text-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user"></i> Manage Admin</h1>
                </div>
            </div>
        </div>

    </header>
    <!--HEADER END-->


    <!--MAIN AREA-->


    <section class="container py-2 mb-4">

        <div class="row">

            <div class="offset-lg-2 col-lg-8">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <form action="admins.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>

                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Username:</span></label>
                                <input class="form-control" type="text" name="username" id="username">
                            </div>

                            <div class="form-group">
                                <label for="name"><span class="fieldInfo">Name:</span></label>
                                <input class="form-control" type="text" name="name" id="name">
                                <small class="text-muted">*Optional</small>
                            </div>

                            <div class="form-group">
                                <label for="password"><span class="fieldInfo">Password:</span></label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword"><span class="fieldInfo">Confirm Pasword:</span></label>
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword">
                            </div>

                            <div class="row">

                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block px-2"><i class="fas fa-angle-double-left"></i> Dashboard</a>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Submit
                                    </button>
                                </div>

                            </div>


                        </div>


                    </div>

                </form>


            </div>

        </div>

    </section>

    <!--MAIN AREA END-->

    <!--FOOTER-->
    <footer class="bg-light text-dark">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center small" style="margin-top: 0.8em;">Designed By | Ashton Naidoo | <span id="year"></span><sup>&copy;</sup> ---All rights reserved <sup>&reg;</sup></p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height: 1.5px; background: lightslategray;"></div>
    <!--FOOTER-->


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>