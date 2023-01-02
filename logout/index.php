<?php
    session_start();
    
    include("../classes/user.php");

    $log = new User();
    $log->logout($_SESSION['userID']);
    session_destroy();
    header("location: ../?");
