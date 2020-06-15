<?php require_once("Includes/db.php"); ?>
<?php require_once("Includes/functions.php"); ?>
<?php require_once("Includes/session.php"); ?>

<!--fetching data-->
<?php
$searchQueryParameter = $_GET['username'];
global $connectingDb;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:Username";
$stmt = $connectingDb->prepare($sql);
$stmt->bindValue(':Username', $searchQueryParameter);
$stmt->execute();
$result = $stmt->rowCount();
if ($result >= 1) {
    while ($dataRows = $stmt->fetch()) {
        $existingName = $dataRows['aname'];
        $existingHeadline = $dataRows['aheadline'];
        $existingBio = $dataRows['abio'];
        $existingImage = $dataRows['aimage'];
    }
} else {
    $_SESSION['errorMessage'] = 'Bad Request :(';
    redirectTo('blog.php?page=1');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="CSS/style.css" />
    <title>Document</title>
    <script src="https://kit.fontawesome.com/2c1c0f2ad6.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        h1 {
            font-weight: 600;
        }
    </style>
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
                        <a href="blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>

                </ul>

                <ul class="navbar-nav ml-auto">
                    <form class="form-inline" action="blog.php">
                        <div class="form-group">
                            <input type="text" class="form-control-sm mr-1" name="search" placeholder="Search here">
                            <button class="btn btn-success btn-sm" name="searchBtn"><i class="fas fa-angle-double-right"></i></button>
                        </div>
                    </form>
                </ul>

            </div>

        </div>

    </nav>
    <!--NAVBAR END-->
    <div style="height: 1.5px; background: lightslategray;"></div>

    <!--HEADER-->
    <header class="bg-light text-dark py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                        <i class="fas fa-user mr-2 text-info"></i> <?= htmlentities($existingName); ?>
                    </h1>
                    <h3><?= htmlentities($existingHeadline) ?></h3>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <br />
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="uploads/<?= $existingImage ?>" alt="" class="block img-fluid mb-3 rounded-circle" width="200px">
            </div>

            <div class="col-md-9" style="min-height: 400px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead"><?= htmlentities($existingBio); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--FOOTER-->
    <footer class="bg-light text-dark">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center small" style="margin-top: 0.8em;">
                        Designed By | Ashton Naidoo | <span id="year"></span><sup>&copy;</sup> ---All rights reserved <sup>&reg;</sup>
                    </p>
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
        $("#year").text(new Date().getFullYear());
    </script>
</body>

</html>