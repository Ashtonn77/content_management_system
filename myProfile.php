 <?php require_once("Includes/db.php"); ?>
 <?php require_once("Includes/functions.php"); ?>
 <?php require_once("Includes/session.php"); ?>
 <?php
    $_SESSION['trackingUrl'] = $_SERVER['PHP_SELF']; //return current page
    confirmLogin(); ?>
 <?php
    //fetching existing admin data
    $adminId = $_SESSION['id'];
    global $connectingDb;
    $sql = "SELECT * FROM admins WHERE id='$adminId'";
    $stmt = $connectingDb->query($sql);
    while ($dataRows = $stmt->fetch()) {
        $existingUsername = $dataRows['username'];
        $existingName = $dataRows['aname'];
        $existingHeadline = $dataRows['aheadline'];
        $existingBio = $dataRows['abio'];
        $existingImage = $dataRows['aimage'];
    }
    //fetching existing admin data end
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $headline = $_POST['headline'];
        $bio = $_POST['bio'];
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($_FILES['image']['name']);

        if (strlen($headline) > 20) {
            $_SESSION['errorMessage'] = "Headline should not be more than 20 characters long";
            redirectTo('myProfile.php');
        } elseif (strlen($bio) > 500) {
            $_SESSION['errorMessage'] = "Post should be less than 500 characters";
            redirectTo('myProfile.php');
        } else {
            global $connectingDb;
            //query to update admin profile
            if (!empty($image)) {
                $sql = "UPDATE admins SET aname='$name', aheadline='$headline', abio='$bio', aimage='$image'
            WHERE id='$adminId '";
            } else {
                $sql = "UPDATE admins SET aname='$name', aheadline='$headline', abio='$bio'
                WHERE id='$adminId '";
            }
            $execute = $connectingDb->query($sql);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            if ($execute) {
                $_SESSION['successMessage'] = "Profile updated successfully :)";
                redirectTo('myProfile.php');
            } else {
                $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
                redirectTo('myProfile.php');
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
     <title>My Profile</title>
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
                     <h1><i class="fas fa-user text-success"></i> @<?= $existingUsername; ?></h1>
                     <small><?= $existingHeadline ?></small>
                 </div>
             </div>
         </div>

     </header>
     <!--HEADER END-->


     <!--MAIN AREA-->


     <section class="container py-2 mb-4">

         <div class="row">

             <!--left area--->
             <div class="col-md-3">
                 <div class="card">
                     <div class="card-header bg-dark text-white text-center">
                         <h3><?= $existingName; ?></h3>
                     </div>

                     <div class="card-body">
                         <img src="uploads/<?= $existingImage; ?>" alt="" class="block img-fluid mb-3" style="max-width: 190px;">
                         <p class="text-center">
                             <?= $existingBio ?>
                         </p>
                     </div>
                 </div>
             </div>


             <!--right area--->
             <div class="col-md-9" style="min-height:400px;">
                 <?php
                    echo errorMessage();
                    echo successMessage();
                    ?>
                 <form action="myProfile.php" method="post" enctype="multipart/form-data">
                     <div class="card bg-dark text-light">
                         <div class="card-header bg-secondary text-light">
                             <h4>Edit Profile</h4>
                         </div>
                         <div class="card-body">
                             <div class="form-group">
                                 <input class="form-control" type="text" name="name" id="name" placeholder="Your name">
                             </div>

                             <div class="form-group">
                                 <input class="form-control" type="text" name="headline" id="headline" placeholder="Headline">
                                 <small class="text-muted">Add a professional headline like 'Engineer' at XYZ or 'Freelance writer'</small>
                                 <span class="text-danger"> Not more than 20 characters</span>
                             </div>

                             <div class="form-group">
                                 <textarea placeholder="Bio" class="form-control" name="bio" id="post" cols="80" rows="10"></textarea>
                             </div>


                             <div class="form-group">
                                 <div class="custom-file">
                                     <input class="custom-file-input" type="File" name="image" id="imageSelect">
                                     <label for="imageSelect" class="custom-file-label">Select Image</label>
                                 </div>
                             </div>


                             <div class="row">

                                 <div class="offset-lg-7 col-lg-2 mb-2">
                                     <a href="dashboard.php" class="btn btn-warning btn-block px-2 btn-sm"><i class="fas fa-angle-double-left"></i> Dashboard</a>
                                 </div>

                                 <div class="col-lg-3 mb-2">
                                     <button type="submit" name="submit" class="btn btn-success btn-block btn-sm">
                                         <i class="fas fa-check"></i> Save changes
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