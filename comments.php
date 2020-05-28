                       <?php require_once("Includes/db.php"); ?>
                      <?php require_once("Includes/functions.php"); ?>
                      <?php require_once("Includes/session.php"); ?>
                      <?php
                        $_SESSION['trackingUrl'] = $_SERVER['PHP_SELF'];//return current page
                        confirmLogin(); ?>
                      <!DOCTYPE html>
                      <html lang="en">

                      <head>
                          <meta charset="UTF-8" />
                          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
                          <link rel="stylesheet" href="CSS/style.css" />
                          <title>Comments</title>
                          <script src="https://kit.fontawesome.com/2c1c0f2ad6.js" crossorigin="anonymous"></script>
                      </head>

                      <body>
                          <div style="height: 1.5px; background: lightslategray;"></div>
                          <!--NAVBAR START-->
                          <nav class="navbar navbar-expand-lg navbar-light bg-light">
                              <div class="container">
                                  <a href="#" class="navbar-brand">
                                      <div style="font-size: 0.5rem;">
                                          <i class="fab fa-centos fa-5x text-secondary"></i></div>
                                  </a>

                                  <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapseCMS">
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
                                              <a href="logout.php" class="nav-link">Logout &nbsp; <i class="fas fa-sign-out-alt text-danger"></i>
                                              </a>
                                          </li>
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
                                              <i class="fas fa-comments"></i> Manage Comments
                                          </h1>
                                      </div>
                                  </div>
                              </div>
                          </header>
                          <!--HEADER END-->

                          <section class="container py-2 mb-4">

                              <div class="row" style="min-height:30px;">
                                  <div class="col-lg-12" style="min-height:30px;">
                                      <h2>Un-approved comments</h2>

                                      <table class="table  table-striped table-hover">
                                          <thead class="thead-dark">
                                              <tr>
                                                  <th>No. </th>
                                                  <th>Date & Time </th>
                                                  <th>Name </th>
                                                  <th>Comment </th>
                                                  <th>Approve </th>
                                                  <th>Delete </th>
                                                  <th>Details </th>
                                              </tr>
                                          </thead>


                                          <?php
                                            global $connectingDb;
                                            $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                                            $execute = $connectingDb->query($sql);
                                            $srNo = 0;
                                            while ($dataRows = $execute->fetch()) {
                                                $commentId = $dataRows['id'];
                                                $dateTime = $dataRows['datetime'];
                                                $commenterName = $dataRows['name'];
                                                $commentContent = $dataRows['comment'];
                                                $postId = $dataRows['post_id'];
                                                $srNo++;
                                            ?>
                                              <tbody>
                                                  <tr>
                                                      <td><?= htmlEntities($srNo) ?></td>
                                                      <td data-toggle="tooltip" title="<?= $dateTime ?>">
                                                          <?= htmlEntities($dateTime) ?></td>
                                                      <td data-toggle="tooltip" title="<?= $commenterName ?>">
                                                          <?= htmlEntities($commenterName) ?></td>
                                                      <td><?= htmlEntities($commentContent) ?></td>
                                                      <td><a class="btn btn-success btn-sm" href="approveComment.php?id=<?= $commentId ?>">Approve</a></td>
                                                      <td><a class="btn btn-danger btn-sm" href="deleteComment.php?id=<?= $commentId ?>">Delete</a></td>
                                                      <td><a class="btn btn-primary btn-sm" href="fullPost.php?id=<?= $postId ?>" target="_blank">Live Preview</a></td>
                                                  </tr>
                                              </tbody>
                                          <?php }; ?>
                                      </table>

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