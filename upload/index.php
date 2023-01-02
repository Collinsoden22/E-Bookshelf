<?php
session_start();
include("../classes/user.php");

if ($_SESSION['role'] == 'ADMIN') {
    $books = ''; //Get all books
} else {
    $err = "You are not allowed to access this page";
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

    <title>Upload | E-BookShelf</title>
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
                            Admin</a>
                        <ul>
                            <li><a href="../publications/">My Publications</a></li>
                            <li><a href="../upload/"> Upload Book </a></li>
                            <li><a href="../wallet">Wallet</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span></span>
                            Setting</a>
                        <ul>
                            <li><a href="#"> Set Payment Method</a></li>
                            <li><a href="../profile/">Profile</a></li>
                            <li><a href="../logout/">Logout</i></a></li>
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
                    <h2 class="section-heading">Upload Book</h2>
                </div>
            </div>
            </div>

            <div class="row justify-content-center col-md-12 ml-1 mr-1 mt-10">
                <div class="col-md-8">
                    <?php
                    $uploadBookFormTokem = mt_rand() . mt_rand() . mt_rand();
                    $_SESSION['uploadBookFormToken'] = $uploadBookFormTokem;
                    ?>
                    <form class="step" method="post" action="../process/" enctype="multipart/form-data">
                        <?php
                        if (isset($_GET['err'])) {
                            $errorMsg = html_entity_decode(trim($_GET['err']));
                            echo "<p class='text-danger'><i class='fa fa-exclamation-triangle'> </i> $errorMsg</p>";
                        } elseif (isset($_GET['msg'])) {
                            $errorMsg = html_entity_decode(trim($_GET['msg']));
                            echo "<p class='text-success'><i class='fa fa-check'> </i> $errorMsg</p>";
                        }
                        ?>
                        <div class="form-group col-md-12 mt-3 d-flex">
                            <input type="hidden" name="uploadBookForm" value="<?= $uploadBookFormTokem; ?>">
                            <div class="col-md-6 mr-1">
                                <select type="text" class="form-control" required name="category" title="Select Book Category">
                                    <option value="0" class="text-center">-- Select Category --</option>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Science Fiction">Science Fiction</option>
                                    <option value="Dystopian">Dystopian </option>
                                    <option value="Adventure">Adventure</option>
                                    <option value="Romance">Romance</option>
                                    <option value="Detective & Mystery">Detective & Mystery</option>
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
                                    <option value="Self-Help/Personal Development">Self-Help/Personal Development</option>
                                    <option value="Motivational/Inspirational">Motivational/Inspirational</option>
                                    <option value="Health & Fitness">Health & Fitness</option>
                                    <option value="Crafts/Hobies & Home">History</option>
                                    <option value="Religion">Religion</option>
                                    <option value="Politics">Politics</option>
                                    <option value="Money & Business">Money & Business</option>
                                    <option value="Travel">Travel</option>
                                </select>
                            </div>
                            <div class="col-md-6 mr-1">
                                <input type="text" class="form-control" placeholder="Book Title" title="Enter Book Title" required name="title">
                            </div>
                        </div>
                        <div class="form-group col-md-12 mt-3 d-flex">
                            <div class="col-md-6 mr-1">
                                <input type="text" class="form-control" placeholder="Author" required name="authorName" title="Author Full Name">
                            </div>
                            <div class="col-md-6 mr-1">
                                <input type="year" max="4" class="form-control" placeholder="Date Published" title="Publication Year" required name="pubDate">
                            </div>
                        </div>
                        <div class="form-group col-md-12 mt-3 d-flex">
                            <div class="col-md-12 mr-1">
                                <label for="text-input">Description (Short Summary)</label>
                                <textarea class="form-control" required name="summary" title="Short Summary of the book"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mt-3 d-flex">
                            <div class="col-md-6 mr-1">
                                <label for="text-input">Upload Book Cover</label>
                                <input type="file" class="form-control" required name="bookCover" accept=".png,.jpg,.jpeg" title="Upload Cover Photo. (Acceptable: png, .jpg, .jpeg)">
                            </div>
                            <div class="col-md-6 mr-1">
                                <label for="text-input">Book File <span class="text-danger">(PDF Format)</span></label>
                                <input type="file" class="form-control" required name="bookFile" title="Upload Book. (File should be in pdf format)">
                            </div>
                        </div>
                        <div class="form-group col-md-3 mt-5 justify-content-center">
                            <button class="btn-secondary btn" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>

        </section>

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-8 mb-md-0">
                    <h3>About E-Bookshelf</h3>
                    <p>E-Bookshelf (Electronic Bookshelf) is an online book store
                        where users can access all types of
                        E-Books at the comfort of their home, without restriction to
                        location.</p>
                </div>
                <div class="col-md-4 ms-auto">
                    <div class="row site-section pt-0">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <h3>Navigation</h3>
                            <ul class="list-unstyled">
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>