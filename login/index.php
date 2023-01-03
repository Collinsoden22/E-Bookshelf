<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Login | E-BookShelf</title>
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
                    <h1><a href="../">E-Bookshelf</a></h1>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="../ " href="index.php">Home</a></li>
                        <li><a href="../#features">Features</a></li>
                        <li><a href="../#about">About</a></li>
                        <li class="dropdown"><a href="#"><span>Portal</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="#">Login</a></li>
                                <li><a href="../register/">Register</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

            </div>
        </header>
        <!-- End Header -->

        <!-- ======= Hero Section ======= -->
        <section class="hero-section" id="hero">
            <div class="wave">
                <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                            <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
                        </g>
                    </g>
                </svg>
            </div>

            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 hero-text-image">
                        <div class="row">
                            <div class="col-lg-8 text-center text-lg-start text-white">
                                <h1 data-aos="fade-right text-white text-sm">Login to continue...</h1>
                                <?php
                            if (isset($_GET['err'])) {
                                $errorMsg = html_entity_decode(trim($_GET['err']));
                                echo "<p class='text-danger'><i class='fa fa-exclamation-triangle'> </i> $errorMsg</p>";
                            } elseif (isset($_GET['msg'])) {
                                $errorMsg = html_entity_decode(trim($_GET['msg']));
                                echo "<p class='text-success'><i class='fa fa-check'> </i> $errorMsg</p>";
                            }
                            ?>

                                <p class="mb-5" data-aos="fade-right" data-aos-delay="100">
                                <form action="../resolveAccount/" method="post" class="col-md-5">
                                    <div class="form-group">
                                        <?php
                                    $loginFormToken = mt_rand() . mt_rand() . mt_rand();
                                    $_SESSION['loginFormToken'] = $loginFormToken;
                                    ?>
                                        <input type="hidden" name="loginForm" value="<?= $loginFormToken ?>">
                                        <input type="text" class="form-control rounded" name="username" placeholder="Enter Username" required>
                                        <input type="password" class="form-control mt-2 rounded" name="password" placeholder="Enter Password" required>
                                        <button data-aos="fade-right" class="btn btn-info mt-4" type="submit" data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">Login</button>
                                    </div>
                                </form>

                                <p data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500">
                                    Don't have an account? <a href="../register/" class="btn btn-sm btn-outline-white mt-4">Create
                                        Account</a>
                                </p>
                                </p>
                            </div>
                            <div class="col-lg-4 iphone-wrap mt-10">
                                <img src="../assets/img/login.jpg" alt="Image" class="phone-1" data-aos="fade-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->

        <?php include("../sections/about.php"); ?>
        <!-- Vendor JS Files -->
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="../assets/vendor/aos/aos.js"></script>
        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="../assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="../assets/js/main.js"></script>

    </body>

</html>