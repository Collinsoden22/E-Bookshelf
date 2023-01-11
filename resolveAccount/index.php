<?php
session_start();

// Registration Form Begins here
if (isset($_POST['registerForm']) && $_POST['registerForm'] == $_SESSION['registerFormToken']) {
    include "../classes/user.php";
    // Get submitted fields
    $userName = htmlentities(trim($_POST['username']));
    $userEmail = htmlentities(trim($_POST['emailAddr']));
    $userPass = htmlentities(trim($_POST['password']));

    $options = [
        'cost' => 9,
    ];
    // create password hash using password_hash() algo
    $userPass = password_hash($userPass, PASSWORD_BCRYPT, $options);

    $user = new User();
    // create user account
    $user->createAccount($userName, $userEmail, $userPass);
    // TODO: Send confirmation email
    $msg = "Account created, login to continue";
    session_destroy();
    // Take User to login page 
    header("location: ../login/?msg=$msg");
    exit();

    // User Login Process Begins Here
} elseif (isset($_POST['loginForm']) && $_POST['loginForm'] == $_SESSION['loginFormToken']) {

    include "../classes/user.php";
    $userName = htmlentities(trim($_POST['username']));
    $userPass = htmlentities(trim($_POST['password']));

    $user = new User();
    // verify User and save Login session
    $loginRole = $user->processLogin($userName, $userPass);
    if ($loginRole) {
        $_SESSION['userID'] = $userName;
        $_SESSION['role'] = $loginRole;
        if ($loginRole == 'USER') {
            header("location: ../dashboard/?");
        } elseif ($loginRole == 'ADMIN') {
            header("location: ../publisher/?");
        }
        exit();
    }
} else {
    session_destroy();
    header("location: ../");
    exit();
}