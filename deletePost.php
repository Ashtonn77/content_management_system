 <?php require_once("Includes/db.php"); ?>
<?php require_once("Includes/functions.php"); ?>
<?php require_once("Includes/session.php"); ?>
<?php
$_SESSION['trackingUrl'] = $_SERVER['PHP_SELF'];//return current page
confirmLogin(); ?>
<?php
$searchQueryParameter = $_GET['id'];
//fetching existing content
global $connectingDb;
$sql = "SELECT * FROM posts WHERE id='$searchQueryParameter'";
$stmt = $connectingDb->query($sql);

while ($dataRows = $stmt->fetch()) {
    $titleToBeDeleted = $dataRows['title'];
    $categoryToBeDeleted = $dataRows['category'];
    $imageToBeDeleted = $dataRows['image'];
    $postToBeDeleted = $dataRows['post'];
}
if (isset($_POST['submit'])) {

    global $connectingDb;
    $sql = "DELETE FROM posts WHERE id='$searchQueryParameter'";
    $execute = $connectingDb->query($sql);

    if ($execute) {
        $targetPathOfImageToBeDeleted = "uploads/$imageToBeDeleted";
        unlink($targetPathOfImageToBeDeleted);
        $_SESSION['successMessage'] = "Post deleted successfully :)";
        redirectTo('posts.php');
    } else {
        $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
        redirectTo('posts.php');
    }
} //end if isset

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Delete Post</title>
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
                    <h1><i class="fas fa-edit"></i>Delete Post</h1>
                </div>
            </div>
        </div>

    </header>
    <!--HEADER END-->


    <!--MAIN AREA-->


    <section class="container py-2 mb-4">

        <div class="row">

            <div class="offset-lg-1 col-lg-10">
                <?php
                echo errorMessage();
                echo successMessage();

                ?>
                <form action="deletePost.php?id=<?= $searchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">

                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Post Title:</span></label>
                                <input disabled class="form-control" type="text" name="postTitle" id="title" placeholder="Type title here" value="<?= $titleToBeDeleted; ?>">
                            </div>

                            <div class="form-group">

                                <span class="fieldInfo"> Exising Image:
                                    <img class="mb-2" src="uploads/<?= $imageToBeDeleted; ?>" alt="" width="170px" height="170px">
                                </span>

                            </div>

                            <div class="form-group">
                                <label for="post"><span class="fieldInfo">Post:</span></label>
                                <textarea disabled class="form-control" name="postDescription" id="post" cols="80" rows="10"><?= $postToBeDeleted ?></textarea>
                            </div>

                            <div class="row">

                                <div class="offset-lg-8 col-lg-2 mb-2">
                                    <a href="dashboard.php" class="btn btn-warning btn-block px-2 btn-sm"><i class="fas fa-angle-double-left"></i> Dashboard</a>
                                </div>

                                <div class="col-lg-2 mb-2">
                                    <button type="submit" name="submit" class="btn btn-danger btn-block btn-sm">
                                        <i class="fas fa-trash"></i> Delete
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