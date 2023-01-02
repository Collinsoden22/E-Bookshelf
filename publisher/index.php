<?php
session_start();
include("../classes/user.php");

if($_SESSION['role'] == 'ADMIN'){
    $books = ''; //Get all books
}elseif($_SESSION['role'] == 'USER'){
    header("location: ../dashboard/?err=$err");
}else{
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
                            <li><a href="#">My Publications</a></li>
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
                <div class="col-md-3 float-right mr-2">
                    <select type="text" class="form-control" onchange="loadBookCategory(this);">
                        <option value="0" class="text-center">-- Sort --</option>
                        <option value="Kids">Date Published</option>
                        <option value="Kids">Author</option>
                        <option value="Kids">Name</option>
                        <option value="Kids">Date Uploaded</option>
                    </select>
                </div>
                <div class="col-md-3 ml-2 float-left">
                    <input type="text" placeholder="Search books" class="form-control" onchange="searchBook(this);">
                </div>
            </div>

            <div class="row text-center col-md-12 ml-1 mr-1 mt-10">
                <!-- TODO: Loop here -->
                <div class="col-md-4">
                    <div class="step">

                        <a href="#">
                            <div class="wrap-icon icon-1 mt-4">
                                <img src="../assets/img/Ifelolar.jpg" alt="" width="200px">
                            </div>
                        </a>
                        <h6 class="mt-4 post-text">
                            <span class="post-meta"><a href="#"> Ifelolar Benjamin </a> </span>
                        </h6>
                        <a href="#">
                            <h5><b>Generational Barrier </b></h5>
                        </a>
                        <span>December 13, 2019 </span> <br><sub><b>Adult Category</b></sub>
                        <p class="text-danger">$110</p>
                        <p>
                            <a href="#">5 <i class="fa fa-eye"></i></a> &nbsp;
                            <a href="#"> 487 <i class="fa fa-book"></i></a>&nbsp;
                            <a href="#">0 <i class="fa fa-thumbs-up"></i></a>&nbsp;
                            <a href="#">26 <i class="fa fa-star"></i></a>&nbsp;
                            <a href="#">5 <i class="fa fa-download"></i></a>
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="step">
                        <a href="#">
                            <div class="wrap-icon icon-1 mt-4">
                                <img src="../assets/img/Ifelolar.jpg" alt="" width="200px">
                            </div>
                        </a>
                        <h6 class="mt-4 post-text">
                            <span class="post-meta"><a href="#">Ifelolar Benjamin</a></span>
                        </h6>
                        <h5><b>Generational Barrier</b></h5>
                        <span>December 13, 2019 </span><br> <sub><b>Religion</b></sub>
                        <p class="text-danger">$110</p>
                        <p>
                            <a href="#">5 <i class="fa fa-eye"></i></a> &nbsp;
                            <a href="#"> 487 <i class="fa fa-book"></i></a>&nbsp;
                            <a href="#">0 <i class="fa fa-thumbs-up"></i></a>&nbsp;
                            <a href="#">26 <i class="fa fa-star"></i></a>&nbsp;
                            <a href="#">5 <i class="fa fa-download"></i></a>
                        </p>
                    </div>
                </div>


            </div>
            </div>

        </section>

        <!-- ======= Testimonials Section ======= -->
        <section class="section border-top border-bottom">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-md-6">
                        <h2 class="section-heading">Books of the Week</h2>
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
                                        <h3>Book Title</h3>
                                        <blockquote>
                                            <p>Book Summary Goes here </p>
                                        </blockquote>
                                        <p class="review-user">
                                            <img src="../assets/img/person_1.jpg" alt="Image" class="img-fluid rounded-circle mb-3">
                                            <span class="d-block">
                                                <span class="text-black">Author's name</span> &mdash; Year of Publication
                                            </span>
                                        </p>

                                    </div>
                                </div>
                                <!-- End testimonial item -->

                                <!-- New here -->
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Testimonials Section -->

        <!-- ======= CTA Section ======= -->
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
        </section><!-- End CTA Section -->

    </main><!-- End #main -->

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