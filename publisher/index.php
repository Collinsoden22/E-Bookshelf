<?php

session_start();

$searchFormToken = mt_rand() . mt_rand() . mt_rand();
// Set SESSION Token to use for form security
$_SESSION['searchValueFormToken'] = $searchFormToken;
// Check current role and redirect appropriately.
if ($_SESSION['role'] == 'USER') {
    header("location: ../dashboard/?err=$err");
} elseif ($_SESSION['role'] == 'ADMIN') {
    include("../classes/user.php");
    $db = new User();
    // Get all available books
    $books = $db->getAllBooks();
    // Get book of the week
    $bookOfTheWeek = $db->getHighestReadBooks();
} else {
    // Logout user if role cannot be verified
    $err = "Please login again to continue";
    session_destroy();
    header("location: ../login/?err=$err");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>E-BookShelf</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <!-- Favicons -->
        <link href="../assets/img/favicon.png" rel="icon">
        <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!-- Vendor CSS Files -->
        <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="../assets/css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top d-flex align-items-center">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="logo">
                    <h1><a href="index.php">E-Bookshelf</a></h1>
                </div>
                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="active " href="index.php">Home</a></li>
                        <li class="dropdown"><a href="#"><span></span>
                                <i class="fa fa-gear"></i></a>
                            <ul>
                                <li><a href="../publication/">My Publications</a></li>
                                <li><a href="../upload/"> Upload Book </a></li>
                                <li><a href="#">Wallet</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#"><span></span>
                                <i class="fa fa-user fa-3x"></i></a>
                            <ul>
                                <li><a href="#"> Set Payment Method</a></li>
                                <li><a href="#">Profile<i class="fa fa-user"></i></a></li>
                                <li><a href="../logout/">Logout<i class="fa fa-star"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                    <i class="fa fa-list mobile-nav-toggle"></i>
                </nav>
                <!-- .navbar -->
            </div>
        </header>
        <!-- End Header -->
        <main id="main" class="main-body">
            <section class="section  col-md-12">
                <div class="row justify-content-center text-center store-bg">
                    <div class="col-md-5" data-aos="fade-up">
                        <h2 class="section-heading">Store</h2>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <input type="hidden" name="searchValue" id="searchFormToken" value="<?= $searchFormToken ?>">
                    <input type="hidden" name="userID" id="userID" value="<?= $_SESSION['userID'] ?>">
                    <div class="col-md-3 float-right mr-2">
                        <select type="text" class="form-control" onchange="loadBookCategory(this);">
                            <option value="0" class="text-center">-- Select category --</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Dystopian">Dystopian </option>
                            <option value="Adventure">Adventure</option>
                            <option value="Romance">Romance</option>
                            <option value="Detective and Mystery">Detective and Mystery</option>
                            <option value="Horrow">Horror</option>
                            <option value="Thriller">Thriller</option>
                            <option value="Historical Fiction">Historical Fiction</option>
                            <option value="Young Adult">Young Adult</option>
                            <option value="Children's Fiction">Children's Fiction</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Memoir & Autobiography">Memoir & Autobiography</option>
                            <option value="Biography">Biography</option>
                            <option value="Cooking">Cooking </option>
                            <option value="Art & Photography">Art & Photography</option>
                            <option value="Personal Development">Personal Development</option>
                            <option value="Self Help">Self-Help</option>
                            <option value="Motivational/Inspirational">Motivational/Inspirational</option>
                            <option value="Health & Fitness">Health & Fitness</option>
                            <option value="Crafts/Hobies & Home">History</option>
                            <option value="Religion">Religion</option>
                            <option value="Politics">Politics</option>
                            <option value="Money & Business">Money & Business</option>
                            <option value="Travel">Travel</option>
                        </select>
                    </div>
                    <div class="col-md-3 ml-2 float-left">
                        <input type="text" placeholder="Search books" class="form-control" onkeyup="searchBook(this);" value="">
                    </div>
                </div>
                <div class="row text-center ml-1 mr-1 mt-12" id="bookPage">
                    <!-- TODO: Loop here -->
                    <?php
                if (isset($books)) {
                    // If Book is found on the database, show books
                    foreach ($books as $book) {

                ?>
                    <div class="col-md-4">
                        <div class="step">
                            <?php
                                $bookId = $book['id'];
                                $bookLink = "../upload/books/" . $book['category'] . "/" . $book['new_name'];
                                //Link below for free books, books with price > 0 should have a link to payment 
                                ?>
                            <a href="#" onclick="countViews(<?= $bookId ?>, <?= $bookLink ?>);">
                                <div class="wrap-icon icon-1 mt-4">
                                    <img src="../upload/cover/<?= $book['book_cover'] ?>" alt="<?= $book['title'] ?> Cover" height="300px">
                                </div>
                            </a>
                            <h6 class="mt-4 post-text">
                                <span class="post-meta"><a href="#"> <?= $book['author'] ?> </a> </span>
                            </h6>
                            <a href="#" onclick="countViews(<?= $bookId ?>, <?= $bookLink ?>);" title="<?= $book['title'] ?>">
                                <h5><b><?= $book['title'] ?> </b></h5>
                            </a>
                            <span><?= $book['date_published'] ?> <sup> <?= $book['posted_by'] ?></sup> </span> <br><sub><b><?= $book['category'] ?></b></sub>
                            <p class="text-danger">$<?= $book['price'] ?></p>
                            <?php
                                // Get book activities
                                $bookActivities = $db->getBookActivities($bookId);
                                // Get starred books
                                $bookStars = $db->getBookStarCount($bookId);
                                // Get book likes
                                $bookLikes = $db->getLikeCount($bookId);

                                ?>
                            <p>
                                <a href="#" title="Views"><?= number_format($bookActivities['times_viewed']); ?> <i class="fa fa-eye"></i></a> &nbsp;
                                <a href="#" title="Times Read"> <?= number_format($bookActivities['times_read']); ?> <i class="fa fa-book"></i></a>&nbsp;
                                <a href="#" title="Likes">
                                    <?php
                                        if ($bookLikes) {
                                            echo number_format(count($bookLikes['user_id']));
                                        } else {
                                            echo '0';
                                        } ?>
                                    <i class="fa fa-thumbs-up"></i></a> &nbsp;
                                <a href="#" title="Favourites">
                                    <?php
                                        // If book has any star, print total number of stars, else print '0'
                                        if ($bookStars) {
                                            echo number_format(count($bookStars['user_id']));
                                        } else {
                                            echo '0';
                                        } ?>
                                    <i class="fa fa-star"></i></a>&nbsp;
                                <a href="#" title="Downloads" onclick="triggerDownload('<?= $bookId ?> ', '<?= $bookLink ?>');"> <?= number_format($bookActivities['times_downloaded']); ?> <i class="fa fa-download"></i></a>
                            </p>
                        </div>
                    </div>
                    <?php
                    }
                } else { ?>
                    <div class="col-md-12">
                        <div class="step">
                            <h5><b>We could not find this book at the moment.</b></h5>
                            <br><a href="#">Request for this book </a><br>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
                </div>
            </section>
            <!-- ======= Book of the Week Section ======= -->
            <section class="section border-top border-bottom">
                <div class="container">
                    <div class="row justify-content-center text-center mb-5">
                        <div class="col-md-6">
                            <h2 class="section-heading">Book of the Week</h2>
                            <!-- TODO: This will show most read books -->
                        </div>
                    </div>
                    <div class="row justify-content-center text-center">
                        <div class="col-md-7">
                            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="review text-center">
                                            <p class="stars">
                                                <span class="fa fa-star-fill"></span>
                                                <span class="fa fa-star-fill"></span>
                                                <span class="fa fa-star-fill"></span>
                                                <span class="fa fa-star-fill"></span>
                                                <span class="fa fa-star-fill muted"></span>
                                            </p>
                                            <h3><?= $bookOfTheWeek['title'] ?></h3>
                                            <blockquote>
                                                <p><?= html_entity_decode($bookOfTheWeek['description'], ENT_QUOTES, 'UTF-8'); ?> </p>
                                            </blockquote>
                                            <p class="review-user">
                                                <img src="../upload/cover/<?= $bookOfTheWeek['book_cover'] ?>" alt="<?= $bookOfTheWeek['title'] ?> Cover image" class="img-fluid rounded mb-3">
                                                <span class="d-block">
                                                    <span class="text-black"><?= $bookOfTheWeek['author'] ?></span> &mdash; Posted by <?= $bookOfTheWeek['posted_by'] ?>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- New here -->
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section cta-section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
                            <h2>E-Bookshelf mobile app</h2>
                        </div>
                        <div class="col-md-5 text-center text-md-end">
                            <p><a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-apple"></i>
                                    <span>Coming soon</span></a>
                                <a href="#" class="btn d-inline-flex align-items-center"><i class="bx bxl-play-store"></i>
                                    <span>Coming soon</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <?php include("../sections/about.php"); ?>
            <!-- Vendor JS Files -->
            <script src="../assets/vendor/aos/aos.js"></script>
            <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
            <script src="../assets/vendor/php-email-form/validate.js"></script>
            <!-- Template Main JS File -->
            <script src="../assets/js/jquery.min.js"></script>
            <script src="../assets/js/main.js"></script>
            <script src="../assets/js/process.js"></script>
    </body>

</html>