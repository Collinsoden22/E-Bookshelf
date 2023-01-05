<?php
require_once("connect_db.php");

class User extends Connect
{

    // Function to log DB Errors
    public function Log_DBerror_msg($message, $code, $file, $line)
    {
        $err = date("Y-m-d h:i:s -") .  "Error: (Code: " . $code . ") on " . $line . " in " . $file . ": " . $message . "\n";
        // Write error to file
        error_log($err, 3, "../error.log");
        exit();
    }

    // Create account function
    public function createAccount($username, $email, $password)
    {
        $this->connect->beginTransaction();
        // Check username on DB, if not found...
        $user_exist = $this->confirmUserExist($username);
        if ($user_exist) {
            $err = "The username you entered is already taken.";
            session_destroy();
            header("location: ../register/?err=$err");
            exit();
        } else {
            try {
                $sql = "INSERT into user (username, email_address, password) VALUES(:userName, :userEmail, :userPassword)";
                //prepare query
                $q = $this->connect->prepare($sql);
                //execute query
                $q->execute(array(':userName' => $username, ':userEmail' => $email, ':userPassword' => $password));
            } catch (PDOException $e) {
                $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
                session_unset();
                session_destroy();
                $err = 'An error might have occurred in the System';
                header("../register/?err=$err");
                exit();
            }
            $this->connect->commit();
        }
    }
    // Save user details to DB
    // Send User email

    public function confirmUserExist($username)
    {
        try {
            $sql = "SELECT email_address FROM user WHERE username=:Username";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':Username' => $username));
            // Get username
            $userEmail = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../login/?err=$err");
            exit();
        }
        if ($userEmail) {
            return true;
        }
    }
    // Check User password here
    public function checkUserpassword($username, $password)
    {
        try {
            $sql = "SELECT password FROM user WHERE username=:Username";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':Username' => $username));
            // Get username
            $userPassword = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("location: ../login/?err=$err");
            exit();
        }
        if ($userPassword) {
            if ($userPass = password_verify($password, $userPassword['password'])) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function getUserRole($username)
    {
        try {
            $sql = "SELECT role FROM user WHERE username=:Username";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':Username' => $username));
            // Get username
            $userRole = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("location: ../login/?err=$err");
            exit();
        }
        if ($userRole)
            return $userRole['role'];
    }
    public function getAllBooks()
    {
        try {
            $sql = "SELECT id,title,author,date_published,description,posted_by,date_uploaded,new_name,book_cover,price,category FROM books ORDER BY date_uploaded DESC LIMIT 12";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute();
            // Get username
            $allBooks = $q->fetchAll();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($allBooks)
            return $allBooks;
    }
    public function getMyBooks($username)
    {
        try {
            $sql = "SELECT title,author,date_published,description,posted_by,date_uploaded,new_name,book_cover,price,category FROM books WHERE posted_by = :username ORDER BY date_uploaded DESC LIMIT 12";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':username' => $username));
            // Get username
            $allBooks = $q->fetchAll();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($allBooks)
            return $allBooks;
    }

    public function getBookActivities($bookID)
    {
        try {
            $sql = "SELECT times_read,times_downloaded,times_viewed FROM book_activities WHERE book_id = :theBookID";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':theBookID' => $bookID));
            // Get username
            $allAct = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($allAct) {
            return $allAct;
        } else {
            return array("times_read" => 0, "times_downloaded" => 0, "times_viewed" => 0);
        }
    }
    public function getBookStarCount($bookID)
    {
        try {
            $sql = "SELECT user_id FROM favorite_books WHERE book_id = :theBookID";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':theBookID' => $bookID));
            // Get username
            $favourite = $q->fetchAll();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($favourite)
            return $favourite['user_id'];
    }

    public function getLikeCount($bookID)
    {
        try {
            $sql = "SELECT user_id FROM liked_books WHERE book_id = :theBookID";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':theBookID' => $bookID));
            // Get username
            $likedBooks = $q->fetchAll();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($likedBooks)
            return $likedBooks['user_id'];
    }

    public function searchBooks($searchWord)
    {
        try {
            $sql = "SELECT title,author,date_published,description,posted_by,date_uploaded,new_name,book_cover,price,category FROM books WHERE title LIKE '%' :searchKey '%' ORDER BY title DESC";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':searchKey' => $searchWord));
            // Get username
            $allBooks = $q->fetchAll();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($allBooks)
            return $allBooks;
    }

    public function searchBookCategory($category)
    {
        try {
            $sql = "SELECT title,author,date_published,description,posted_by,date_uploaded,new_name,book_cover,price,category FROM books WHERE category = :searchKey ORDER BY title DESC";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':searchKey' => $category));
            // Get username
            $allBooks = $q->fetchAll();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($allBooks)
            return $allBooks;
    }

    public function getHighestReadBooks()
    {
        try {
            // TODO: Make this pick only more read books
            $sql = "SELECT title,author,date_published,description,posted_by,date_uploaded,new_name,book_cover,price,category FROM books ORDER BY date_uploaded DESC LIMIT 1";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute();
            // Get username
            $mostRead = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            $err = 'An error might have occurred in the System';
            header("location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "/?err=$err");
            exit();
        }
        if ($mostRead)
            return $mostRead;
    }

    public function logout($username)
    {
        try {
            $sql = "DELETE FROM online_user WHERE user_id=:Username";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':Username' => $username));
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../login/?err=$err");
            exit();
        }
        return true;
    }


    public function saveLoginSession($username)
    {
        try {
            $sql = "INSERT INTO online_user(user_id, login_time) VALUES(:Username,NOW())";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':Username' => $username));
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../logout/?err=$err");
            exit();
        }
        return true;
    }
    public function registerDownloadClick($bookID, $times)
    {
        try {
            $sql = "INSERT INTO book_activities(book_id, times_downloaded) VALUES(:bookID,:timesDownloaded)";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':bookID' => $bookID, ':timesDownloaded' => $times));
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../logout/?err=$err");
            exit();
        }
        return true;
    }

    public function updateDownloadClick($bookID, $times)
    {
        try {
            $sql = "UPDATE book_activities SET times_downloaded =:timesDownloaded WHERE book_id=:bookID";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':bookID' => $bookID, ':timesDownloaded' => $times));
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../logout/?err=$err");
            exit();
        }
        return true;
    }

    public function registerViewClick($bookID, $times)
    {
        try {
            $sql = "INSERT INTO book_activities(book_id, times_read,times_viewed) VALUES(:bookID,:timesRead,:timesViewed)";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':bookID' => $bookID, ':timesRead' => $times, ':timesViewed' => $times));
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../logout/?err=$err");
            exit();
        }
        return true;
    }

    public function updateViewClick($bookID, $times)
    {
        try {
            $sql = "UPDATE book_activities SET times_viewed =:totalTime, times_read =:totalTime WHERE book_id=:bookID";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':bookID' => $bookID, ':totalTime' => $times));
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../logout/?err=$err");
            exit();
        }
        return true;
    }

    public function processLogin($username, $password)
    {
        $user_exist = $this->confirmUserExist($username);
        if (!$user_exist) {
            $err = "Invalid login, check your login details.";
            header("location: ../login/?err=$err");
            exit();
        }
        try {
            $sql = "SELECT username FROM user WHERE username=:Username";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':Username' => $username));
            // Get username
            $userEmail = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../login/?err=$err");
            exit();
        }
        if ($userEmail) {
            $passwordMatch = $this->checkUserpassword($username, $password);
            if ($passwordMatch) {
                $userRole =  $this->getUserRole($username);
                $this->saveLoginSession($username);
            } else {
                $err = 'Your login details are invalid, kindly crosscheck your sign in information';
                session_destroy();
                header("location: ../login/?err=$err");
                exit();
            }
            if ($userRole) {
                return $userRole;
            } else {
                $err = 'We could not verify your details';
                session_destroy();
                header("location: ../login/?err=$err");
                exit();
            }
        }
    }
    public function uploadBookDetails($category, $author, $title, $bookPrice, $dateofPub, $postedBy, $summary, $oldName, $newName, $cover)
    {
        try {
            $sql = "INSERT into books (title,author,date_published,description,posted_by,date_uploaded,file_name,new_name,book_cover,price,category) " .
                " VALUES(:bookTitle,:bookAuthor,:pubDate,:desc,:postedBy,NOW(),:fileName,:newName,:bookCover,:price,:bookCategory)";
            //prepare query
            $q = $this->connect->prepare($sql);
            //execute query
            $q->execute(array(':bookTitle' => $title, ':bookAuthor' => $author, ':pubDate' => $dateofPub, ':desc' => $summary, ':postedBy' => $postedBy, ':fileName' => $oldName, ':newName' => $newName, ':bookCover' => $cover, ':price' => $bookPrice, ':bookCategory' => $category));
            // Get username
            $userEmail = $q->fetch();
        } catch (PDOException $e) {
            $this->Log_DBerror_msg($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            session_unset();
            session_destroy();
            $err = 'An error might have occurred in the System';
            header("../login/?err=$err");
            exit();
        }
        if ($userEmail) {
            return true;
        }
    }
}