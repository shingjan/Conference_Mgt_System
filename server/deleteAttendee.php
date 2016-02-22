<?php
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    if(!isset($_SESSION['admin']))
        header("location: ../index.php");
    
    $banquet = $_GET['bid'];
    $attendee = $_GET['aid'];
    $deletion1 = "DELETE FROM Record WHERE Banquet_ID = '{$banquet}' AND Attendee_ID = '{$attendee}'";

    $rs1 = mysql_query($deletion1, $db);
    header("location: ../search-attendee.php");
 
?>