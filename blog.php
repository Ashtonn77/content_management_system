<?php require_once("Includes/db.php"); ?>
<?php require_once("Includes/functions.php"); ?>
<?php require_once("Includes/session.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Blog</title>
    <script src="https://kit.fontawesome.com/2c1c0f2ad6.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        h1 {
            font-weight: 600;
        }

        .heading {
            font-family: Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005e90;
        }

        .heading:hover {
            cursor: pointer;
            color: #0090db;
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

    <div class="container">
        <div class="row mt-4">

            <!--MAIN AREA-->
            <div class="col-8">

                <h1>Read &raquo; Write &raquo; Explore</h1>
                <h1 class="lead">Adventure awaits...</h1>
                <hr><br>
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <?php
                global $connectingDb;
                //query when search btn is active
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

                    //query when pagination is active    
                } elseif (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    if ($page < 1) {
                        $showPostsFrom = 0;
                    } else {
                        $showPostsFrom = ($page * 3) - 3;
                    }

                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $showPostsFrom,3";
                    $stmt = $connectingDb->query($sql);
                }
                //query when category is active in url
                elseif (isset($_GET['category'])) {
                    $category = $_GET['category'];
                    $sql = "SELECT * FROM posts WHERE category='$category' ORDER BY id desc";
                    $stmt = $connectingDb->query($sql);
                } else {
                    // default sql
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,2";
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
                            <small class="text-muted">Written by <a href="profile.php?username=<?= htmlentities($author); ?>"><?= htmlentities($author); ?></a> on <?= htmlentities($dateTime); ?> - Category: <?= htmlentities($category); ?></small>
                            <span style="float:right;" class="badge">Comments
                                <?= approvedCommentsBadge($id); ?>
                            </span>
                            <hr>
                            <p class="card-text">
                                <?php
                                if (strlen($post) > 150) {
                                    $post = substr($post, 0, 150) . '...';
                                }
                                ?>
                                <?= htmlentities($post) ?></p>
                            <a href="fullPost.php?id=<?= $id; ?>" style="float: right">
                                <span class="btn btn-info btn-sm">Read more <i class="fas fa-angle-double-right"></i>
                                </span></a>

                        </div>
                    </div>
                <?php }; ?>
                <br>
                <!--Pagination-->

                <nav>
                    <ul class="pagination pagination-md">

                        <!--backward btn-->
                        <?php
                        if (isset($page)) {
                            if ($page > 1) {
                        ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?= $page - 1 ?>" class="page-link">&laquo;</a>
                                </li>
                                &nbsp;
                        <?php
                            };
                        }; ?>
                        <!--backward btn end-->

                        <?php
                        global $connectingDb;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $connectingDb->query($sql);
                        $rowsPagination = $stmt->fetch();
                        $totalPosts = array_shift($rowsPagination);
                        $postPagination = ceil($totalPosts / 3);

                        for ($i = 1; $i <= $postPagination; $i++) {
                            if (isset($page)) {
                                if ($i == $page) {
                        ?>
                                    <li class="page-item active">
                                        <a href="blog.php?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                                    </li>
                                    &nbsp;
                                <?php
                                } else {
                                ?>
                                    <li class="page-item">
                                        <a href="blog.php?page=<?= $i ?>" class="page-link"><?= $i ?></a>
                                    </li>
                                    &nbsp;
                                <?php  }
                                ?>
                        <?php }
                        }; ?>

                        <!--forward btn-->
                        <?php
                        if (isset($page) && !empty($page)) {
                            if ($page + 1 <= $postPagination) {
                        ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?= $page + 1 ?>" class="page-link">&raquo;</a>
                                </li>
                                &nbsp;
                        <?php
                            };
                        }; ?>
                        <!--forward btn end-->

                    </ul>
                </nav>

                <!--End Pagination-->

            </div>
            <!--MAIN AREA END-->



            <!--SIDE AREA-->
            <div class="col-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="uploads/blogging.png" alt="ad" class="d-block img-fluid mb-3">
                        <div class="text-center">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores asperiores blanditiis molestias, sunt veniam minus ad repellat excepturi vero dolor consequatur corporis? Molestias accusamus quam dolorum fuga id nobis necessitatibus.Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores asperiores blanditiis molestias, sunt veniam minus ad repellat excepturi vero dolor consequatur corporis? Molestias accusamus quam dolorum fuga id nobis necessitatibus.
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign In!</h2>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success btn-block btn-sm">Join the forum</button>
                        <button class="btn btn-info btn-block btn-sm text mb-3">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter your email"> &nbsp;
                            <button class="btn btn-sm btn-secondary">Subsribe now</button>
                        </div>
                    </div>
                </div><br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $connectingDb;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $connectingDb->query($sql);
                        while ($dataRows = $stmt->fetch()) {
                            $id = $dataRows['id'];
                            $title = $dataRows['title'];
                        ?>
                            <a href="blog.php?category=<?= $title ?>"><span class="heading"><?= $title ?></span></a><br>
                        <?php }; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-info mb-2">
                        <h2 class="lead">Recent posts</h2>
                    </div>
                    <?php
                    global $connectingDb;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $connectingDb->query($sql);
                    while ($dataRows = $stmt->fetch()) {
                        $id = $dataRows['id'];
                        $title = $dataRows['title'];
                        $dateTime = $dataRows['datetime'];
                        $image = $dataRows['image'];
                    ?>
                        <div class="media">
                            <img src="uploads/<?= htmlentities($image)  ?>" width="90" height="94" alt="" class="d-block img-fluid align-self- ml-2">
                            <div class="media-body ml-2">
                                <a href="fullPost.php?id=<?= $id ?>" target="_blank">
                                    <h6 class="lead"><?= htmlentities($title) ?></h6>
                                </a>
                                <p class="small"><?= htmlentities($dateTime) ?></p>
                            </div>
                        </div>
                        <hr>
                    <?php }; ?>
                </div>

            </div>


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