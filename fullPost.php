<?php require_once("Includes/db.php"); ?>
<?php require_once("Includes/functions.php"); ?>
<?php require_once("Includes/session.php"); ?>
<?php $searchQueryParameter = $_GET['id']; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Blog</title>
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

    <div class="container">
        <div class="row mt-4">

            <!--MAIN AREA-->
            <div class="col-8">

                <h1>My very first Blogging Site</h1>
                <h1 class="lead">An Ashton Naidoo Project</h1>
                <?php
                global $connectingDb;
                if (isset($_GET['searchBtn'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM posts WHERE 
                            datetime LIKE :search 
                            OR title LIKE :search 
                            OR category LIKE :search 
                            OR post LIKE :search";

                    $stmt = $connectingDb->prepare($sql);
                    $stmt->bindValue(':search', '%' . $search . '%');
                    $stmt->execute();
                } else {
                    // default sql
                    $idFromURL = $_GET['id'];
                    if (!isset($idFromURL)) {
                        $_SESSION['errorMessage'] = 'Bad Request :(';
                        redirectTo('blog.php');
                    }

                    $sql = "SELECT * FROM posts WHERE id = '$idFromURL'";
                    $stmt = $connectingDb->query($sql);
                }

                while ($dataRows = $stmt->fetch()) {
                    $id             = $dataRows['id'];
                    $dateTime       = $dataRows['datetime'];
                    $title          = $dataRows['title'];
                    $category       = $dataRows['category'];
                    $author         = $dataRows['author'];
                    $image          = $dataRows['image'];
                    $post           = $dataRows['post'];
                ?>

                    <div class="card">
                        <img src="uploads/<?= htmlentities($image) ?>" alt="postImage" style="max-height:450px;" class="img-fluid card-img-top">
                        <div class="card-body">
                            <h4 class="card-title"><?= htmlentities($title); ?></h4>
                            <small class="text-muted">Written by <?= htmlentities($author); ?> on <?= htmlentities($dateTime); ?></small>
                            <span style="float:right;" class="badge">Comments 5</span>
                            <hr>
                            <p class="card-text"> <?= htmlentities($post) ?></p>

                        </div>
                    </div>
                <?php }; ?>

                <!--comment section-->
                <div class="">
                    <form action="fullPost.php?id=<?= $searchQueryParameter ?>" class="" method="post">
                        <div class="card mt-3">

                            <div class="card-header">
                                <h5 class="fieldInfo">Share your thoughts about this post</h5>
                            </div>

                            <div class="card-body">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="commenterName" placeholder="Name">
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="commenterEmail" placeholder="Email">
                                    </div>

                                </div>
                                
                                <div class="form-group">
                                    <textarea name="commenterThoughts" cols="8" rows="8" class="form-control"></textarea>
                                </div>

                                <div class="">
                                    <button type="submit"  name="submit"  class="btn-secondary btn-sm">Submit Comment</button>                                    
                                </div>

                            </div>

                        </div>


                    </form>

                </div>


            </div>
            <!--MAIN AREA END-->



            <!--SIDE AREA-->
            <div class="col-4" style="min-height: 40px; background:red">

            </div>
            <!--SIDE AREA END-->

        </div>
    </div>

    <!--HEADER END-->
    <br>

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