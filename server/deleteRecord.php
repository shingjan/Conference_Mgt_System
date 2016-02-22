<?php
    session_start();
    $user=$_SESSION['uid'];
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    $banquet = $_GET['bid'];
    $deletion1 = "DELETE FROM Record WHERE Banquet_ID = '{$banquet}' and Attendee_ID = '{$user}'";
    $rs1 = mysql_query($deletion1, $db);

 header("location: ../user-home.php");
 
?>