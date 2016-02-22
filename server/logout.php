<?php
    session_start();
    if(isset($_SESSION['admin']) || isset($_SESSION['user']) )
    {
        $_SESSION = array();
        session_destroy();
    }
    header('location: ../index.php');
?>