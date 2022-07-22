<?php include './partials/connection.php' ;?>
<?php session_start(); ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
    <title>Let's Read</title>
</head>

<body>
    <!-- Nav Bar-->
    <nav class="navbar navbar-expand-lg navbar-dark bglavender">
        <div class="container-fluid">
            <a class="navbar-brand page-name" href="index.php">Let's Read</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                               
                    <li class="nav-item">
                        <a class="nav-link" href="partials/about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="partials/feedback.php">Feedback</a>
                    </li>   
                    
                </ul>
                <form class="d-flex" action='partials/search.php' method='GET' >
                    <input class="form-control me-2" name='search' type="search" placeholder="Search" aria-label="Search" required="">
                    <input class="btn animated-btn" value="Search" type="submit">
                </form>
                <div class="mx-2">
                    <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) : ?>
                        <button class="btn btn-primary" data-bs-target="#login" onclick="window.location.href='http://localhost/library/library/partials/loginpage.php'">
                            Login</button>
                        <button class="btn btn-primary" data-bs-target="#signup" onclick="window.location.href='http://localhost/library/library/partials/signup.php'">
                            SignUp</button>
                        <?php else : ?>
                        <div class="navbar-collapse collapse">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item active">
                                        <img src="assests/icons8-user-50.png">
                                        <?php echo "Welcome " . $_SESSION['name'] ?>
                                </li>
                            </ul>
                            <button class="btn btn-primary" data-bs-target="#login" onclick="window.location.href='http://localhost/library/library/partials/logout.php'">
                                Logout</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- Our code starts here -->


    <!-- Carousel starts here -->

    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block ">
                    <h3><strong>Welcome to<br> <em>Let's Read!</em></strong></h3>
                    <a class="btn btn-danger" href='#books'>Books</a>
                    <button class="btn btn-success"
                        onclick="window.location.href='http:/library/library/news/news.html'">News</button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block ">
                    <h3><strong>Welcome to<br> <em>Let's Read!</em></strong></h3>
                    <button class="btn btn-danger">Books</button>
                    <button class="btn btn-success"
                        onclick="window.location.href='http:/library/library/news/news.html'">News</button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/2.jpg" class="d-block w-100 " alt="...">
                <div class="carousel-caption d-none d-md-block ">
                    <h3><strong>Welcome to <br><em>Let's Read!</em></strong></h3>
                    <button class="btn btn-danger">Books</button>
                    <button class="btn btn-success"
                        onclick="window.location.href='http:/library/library/news/news.html'">News</button>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <!-- <h3><a style="color:#b87e9a; text-decoration: none;" href='#'>Humanity</a></h3> -->
    <!-- cards -->
    <div class="container my-4" id='books'>
        <div class="row mb-2">
    <?php
            if(isset($_GET['sub_name'])){
                $cat_name=$_GET['sub_name'];
            }
            $book_sql = "SELECT * FROM 
            ( SELECT book_id,book_name,sub_name,cat_name,author,total_pages,ratings,book_file_url,book_cover_url,ROW_NUMBER() 
            OVER ( PARTITION BY books.sub_id ORDER BY books.book_id ASC ) 
            AS ROW_NUMBER FROM `books` JOIN `sub_catagory` ON books.sub_id = sub_catagory.sub_id 
            JOIN `catagories` ON books.cat_id=catagories.cat_id ) AS groups WHERE groups.ROW_NUMBER <=3;";
            $book_result = mysqli_query($conn, $book_sql);
             if ($book_result) {
                if (mysqli_num_rows($book_result)>0) {
                    while ($row = mysqli_fetch_assoc($book_result)) {
                        if($row['ROW_NUMBER']==1){
                            echo "<h3><a style='color:#75485E; text-decoration: none;' href='partials/catagories.php?sub_name={$row['sub_name']}'>" . $row['sub_name'] . "</a></h3>";
                        }
                        ?>
                        
                        <div class="col-md-4">
                            <div class="card mb-3" style="height: 200px;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="<?php echo "partials/".$row['book_cover_url']; ?>" style="width: 170px;height: 170px;" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                            <h5 class="card-title"><?php echo $row["book_name"] ?></h5>
                                            <h6 class="card-text text-muted">By <?php echo "<i>".$row['author'] ."</i>";?></h6>
                                            <h6 class="card-text text-muted">Total Pages: <?php echo $row['total_pages'];?></h6>
                                            <h6 class="card-text text-muted">Ratings: <?php echo $row['ratings']. "&#11088"?></h6>
                                            <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) : ?>
                                                <a href="http://localhost/library/library/partials/loginpage.php" class="btn btn-primary">Read</a>
                                            <?php else:?>
                                                <a href=<?php echo "http://localhost/library/library/partials/read.php?id=" . $row["book_id"] ?> class="btn btn-primary">Read</a>
                                            <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
        <!-- cards end -->
    <!-- testimonials -->
    <section class="testimonial">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="sec-heading text-center">
                        <h6>" Client's Says "</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="clients-carousel owl-carousel">
                    <div class="single-box">
                        <div class="img-area"><img alt="" class="img-fluid"
                                src="https://images.pexels.com/photos/3525908/pexels-photo-3525908.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940">
                        </div>
                        <div class="content">
                            <h4>Jason Doe</h4>
                            <h7>Researcher,University of California</h7>

                            <p>"I have found this library to be very useful.Thankyou!"</p>
                            <section class="rating-star">
                                 <div class="icons">
                                     <i class="fa fa-star"></i>
                                     <i class="fa fa-star"></i>
                                     <i class="fa fa-star"></i>
                                     <i class="fa fa-star"></i>
                                     <i class="fa-solid fa-star-sharp-half"></i>

                                    </div>
                            </section> 
                        </div>
                    </div>
                    <div class="single-box">
                        <div class="img-area"><img alt="" class="img-fluid"
                                src="https://images.pexels.com/photos/5042302/pexels-photo-5042302.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940">
                        </div>
                        <div class="content">
                            <h4>Dave Wood</h4>
                            <h6>Student,Stanford University</h6>
                            <p>"This library has been quite useful for me.I found a wide range of contents here."</p>
                            <section class="rating-star">
                                 <div class="icons">
                                     <i class="fa fa-star"></i>
                                     <i class="fa fa-star"></i>
                                     <i class="fa fa-star"></i>
                                     <i class="fa fa-star-o"></i>

                                    </div>
                            </section> 
                        </div>
                    </div>
                <!-- end testimonial -->


        <footer class="container">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>© 2022 Let's Read, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
        </footer>


        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>