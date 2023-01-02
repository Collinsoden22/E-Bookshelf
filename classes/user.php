<?php

class User
{

    public $connect;
    public function __Construct()
    {
        $host = "localhost";
        $db_name = "ebook_shelf";
        $user = "root";
        $pass = "";

        try {
            $this->connect = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);

            // Make all DB errors throw exceptionas
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $err =  "Error on line " . $e->getLine() . " in " . $e->getFile() . ": " . $e->getMessage() . "\n";
            // Write error to file
            // echo $err;
            error_log($err, 3, "../error.log");
            // echo "There was an error completing your request";
            die();
        }
        return TRUE;
    }


    public function Log_DBerror_msg($message, $code, $file, $line)
    {
        $err = date("Y-m-d h:i:s -") .  "Error: (Code: " . $code . ") on " . $line . " in " . $file . ": " . $message . "\n";
        // Write error to file
        error_log($err, 3, "../error.log");
        exit();
    }

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
    public function uploadBookDetails($category, $author, $title, $bookPrice, $dateofPub, $postedBy, $summary, $oldName, $newName, $cover){
            try {
                $sql = "INSERT into books (title,author,date_published,description,posted_by,date_uploaded,file_name,new_name,book_cover,price,category) ". 
                " VALUES(:bookTitle,:bookAuthor,:pubDate,:desc,:postedBy,NOW(),:fileName,:newName,:bookCover,:price,:bookCategory)";
                //prepare query
                $q = $this->connect->prepare($sql);
                //execute query
                $q->execute(array(':bookTitle'=>$title,':bookAuthor' =>$author,':pubDate'=>$dateofPub,':desc'=> $summary, ':postedBy' =>$postedBy,':fileName' => $oldName, ':newName' =>$newName, ':bookCover' =>$cover, ':price' =>$bookPrice, ':bookCategory'=>$category));
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