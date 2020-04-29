<?php require_once("Includes/db.php");?>
<?php require_once("Includes/functions.php");?>
<?php require_once("Includes/session.php");?>
<?php
if(isset($_POST['submit'])){
    $postTitle = $_POST['postTitle'];
    $category = $_POST['category'];
    $image = $_FILES["image"]["name"];

    $target = "uploads/".basename($_FILES["image"]["name"]);
    $postText = $_POST['postDescription'];
    $admin = 'Ashton';
    $currentTime = time();
    $dateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
    
    global $connectingDb;

    if(empty($postTitle)){
        $_SESSION['errorMessage'] = "Post title can't be empty";
        redirectTo('addNewPost.php');
    }
    elseif(strlen($postTitle) < 5){
        $_SESSION['errorMessage'] = "Post title should be more than 5 characters long";
        redirectTo('addNewPost.php');
    }
    elseif(strlen($postText) > 999){
        $_SESSION['errorMessage'] = "Post should be less than 1000 characters";
        redirectTo('addNewPost.php');
    }
    else{
        //query to insert post in db
        $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
        $sql .= "VALUES(:DateTime,:Title,:Category,:Author,:Image,:Post)";

        $stmt = $connectingDb->prepare($sql);
        $stmt->bindValue(':DateTime',$dateTime);
        $stmt->bindValue(':Title',$postTitle);
        $stmt->bindValue(':Category',$category);
        $stmt->bindValue(':Author',$admin);
        $stmt->bindValue(':Image',$image);       
        $stmt->bindValue(':Post',$postText);
        
        $execute = $stmt->execute();
        move_uploaded_file($_FILES['image']['tmp_name'],$target);
        //move_uploaded_file($_FILES["image"]["tmp_name"],'uploads/'.$new_file_name); //saves image to uploads directory

        if($execute){
            $_SESSION['successMessage'] = "Post with id : ".$connectingDb->lastInsertId()." added successfully :)";
            redirectTo('addNewPost.php');
        }
        else{
            $_SESSION['errorMessage'] = "Something went wrong :( Try again ! ";
            redirectTo('addNewPost.php');
        }

    }//end if category

}//end if isset

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>New Post</title>
    <script src="https://kit.fontawesome.com/2c1c0f2ad6.js" crossorigin="anonymous"></script>
</head>
<body>
    <div style="height: 1.5px; background: lightslategray;"></div>
    <!--NAVBAR START-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a href="#" class="navbar-brand"><div style="font-size: 0.5rem;"><i class="fab fa-centos fa-5x text-secondary"></i></div></a>

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
                        <a href="manageAdmins.php" class="nav-link">Manage Admins</a>
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
                        <h1><i class="fas fa-edit"></i>Add New Post</h1>
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
                <form action="addNewPost.php" method="post" enctype="multipart/form-data">
                        <div class="card bg-secondary text-light mb-3">
                         
                                <div class="card-body bg-dark">
                                    <div class="form-group">
                                        <label for="title"><span class="fieldInfo">Post Title:</span></label>
                                        <input class="form-control" type="text" name="postTitle" id="title" placeholder="Type title here">
                                    </div>

                                    <div class="form-group">
                                        <label for="categoryTitle"><span class="fieldInfo">Choose category:</span></label>
                                            <select class="form-control" name="category" id="categoryTitle">
                                          
                                                    <?php
                                                        global $connectingDb;
                                                        $sql = "SELECT id, title FROM category";
                                                        $stmt = $connectingDb->query($sql);
                                                        while($dataRows = $stmt->fetch()){
                                                            $id = $dataRows['id'];
                                                            $categoryName = $dataRows['title'];
                                                    ?>
                                                             <option value=""><?=$categoryName;?></option>
                                                        <?php } ?>     
                                            </select>
                                    </div>

                                    <div class="form-group">                                    
                                        <div class="custom-file">
                                        <input class="custom-file-input" type="File" name="image" id="imageSelect">
                                        <label for="imageSelect" class="custom-file-label">Select Image</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="post"><span class="fieldInfo">Post:</span></label>
                                        <textarea class="form-control" name="postDescription" id="post" cols="80" rows="10"></textarea>
                                    </div>

                                    <div class="row">

                                        <div class="offset-lg-8 col-lg-2 mb-2">
                                            <a href="dashboard.php" class="btn btn-warning btn-block px-2"><i class="fas fa-angle-double-left"></i> Dashboard</a>
                                        </div>

                                        <div class="col-lg-2 mb-2">
                                            <button type="submit" name="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-check"></i> Publish
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