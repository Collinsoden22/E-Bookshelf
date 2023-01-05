<?php
session_start();

// For uploading Book and Cover Page
if (isset($_POST['uploadBookForm']) && $_POST['uploadBookForm'] == $_SESSION['uploadBookFormToken']) {
    include('../classes/user.php');

    $db =  new User();

    // Get post data
    $bookCategory = htmlentities(trim($_POST['category']));
    $bookAuthor = htmlentities(trim($_POST['authorName']));
    $bookTitle = htmlentities(trim($_POST['title']));
    $pubDate = htmlentities(trim($_POST['pubDate']));
    $bookSummary = htmlentities(trim($_POST['summary']));
    // $bookPrice = htmlentities(trim($_POST['price']));
    $bookCover = $_FILES['bookCover']['name'];
    $bookFile = $_FILES['bookFile']['name'];

    // Get  File extensions
    $fileExtension = pathinfo($bookFile, PATHINFO_EXTENSION);
    $coverExtension = pathinfo($bookCover, PATHINFO_EXTENSION);




    // Check if extension is PDF
    if (trim($fileExtension) != 'pdf') {
        $err = "Unsupported Book File Extension, only PDF file can be uploaded";
        header("location: ../upload/?err=$err");
        exit();
    }
    // Check if extension is png, jpg or jpeg
    if (trim($coverExtension) != 'png' && $coverExtension != 'jpg' && $coverExtension != 'jpeg') {
        $err = "Unsupported Book Cover File, only files with .png, .jpg, .jpeg  can be uploaded";
        header("location: ../upload/?err=$err");
        exit();
    }

    // Generate New Book file name for security
    $bookCover = $_FILES['bookCover']['name'];
    $fileNewName = md5(date('Y-M-D h:i:s') . $_SESSION['userID']);
    $fileNewName = $fileNewName . '.pdf';

    // File paths for upload
    $book_file_path = '../upload/books/' . $bookCategory . '/' . $fileNewName;
    if (!is_dir('../upload/books/' . $bookCategory . '/')) {
        mkdir('../upload/books/' . $bookCategory . '/');
    }
    $cover_file_path = '../upload/cover/' . $_FILES['bookCover']['name'];

    // generate name for file, create category for file directory, hash category name
    //  Check if file exists
    if (file_exists($book_file_path)) {
        $fileNewName = md5(date('Y-M-D h:i:s') . $_SESSION['userID']) . '.pdf';
        $book_file_path = '../books/' . $bookCategory . '/' . $fileNewName;
    }
    if (file_exists($cover_file_path)) {
        $bookCover = md5(date('Y-M-D h:i:s') . $_SESSION['userID']) . '.' . $coverExtension;
        $cover_file_path = '../cover/' . $bookCover;
    }
    // Check file size, ensure it doesn't exceed 200mb
    if ($_FILES["bookFile"]["size"] > 20000000) {
        $err =  "The PDF file you're trying to upload is larger than 200mb.";
        header("location: ../upload/?err=$err");
        exit();
    }

    if ($_FILES["bookCover"]["size"] > 500000) {
        $err =  "Your cover image is larger than 5mb.";
        header("location: ../upload/?err=$err");
        exit();
    }
    // echo $_FILES['bookFile']['name'];
    // exit();
    if (move_uploaded_file($_FILES['bookFile']['tmp_name'], $book_file_path)) {
        move_uploaded_file($_FILES['bookCover']['tmp_name'], $cover_file_path);
        $bookPrice = 0;
        $db->uploadBookDetails($bookCategory, $bookAuthor, $bookTitle, $bookPrice, $pubDate, $_SESSION['userID'], $bookSummary, $_FILES['bookFile']['name'], $fileNewName, $bookCover);
        $msg = "Book Uploaded, you can find your book in your store";
        header("location: ../upload/?msg=$msg");
        exit();
    } else {
        $msg = "Your book could not be uploaded, please try again.";
        $db->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
        header("location: ../upload/?err=$msg");
        exit();
    }
} elseif (isset($_POST['searchBoxForm']) && ($_POST['searchBoxForm'] == $_SESSION['searchValueFormToken'])) {

    // Upload Files
    include("../classes/user.php");

    $searchItem = htmlentities(trim($_POST['searchValue']));
    $db = new user();

    // Save Book information
    $books = $db->searchBooks($searchItem);
    if ($books) {
        echo var_dump($books);
    } else {
        echo 'Book not found';
    }
} elseif (isset($_POST['categoryBoxForm']) && ($_POST['categoryBoxForm'] == $_SESSION['searchValueFormToken'])) {
    include("../classes/user.php");

    $searchItem = htmlentities(trim($_POST['searchValue']));
    $db = new user();

    $books = $db->searchBookCategory($searchItem);
    if ($books) {
        echo var_dump($books);
    } else {
        echo 'Book not found';
    }
} elseif (isset($_POST['downloadTriggerForm']) && ($_POST['downloadTriggerForm'] == $_SESSION['searchValueFormToken'])) {
    include("../classes/user.php");

    $bookID = htmlentities(trim($_POST['bookID']));
    $userID = htmlentities(trim($_POST['userID']));
    $db = new user();

    $bookActivities = $db->getBookActivities($bookID);
    $downloadTimes = $bookActivities['times_downloaded'];
    if (empty($downloadTimes)) {
        $books = $db->registerDownloadClick($bookID, 1);
    } else {
        $books = $db->updateDownloadClick($bookID, $downloadTimes + 1);
    }
    if ($books) {
        echo var_dump($books);
    } else {
        echo 'Book not found';
    }
} else {
    session_destroy();
    header("location: ../");
    exit();
}