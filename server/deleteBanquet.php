<?php
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    if(!isset($_SESSION['admin']))
        header("location: ../index.php");
    
    $banquet = $_GET['bid'];
    $deletion1 = "DELETE FROM TableSet WHERE Banquet_ID = '{$banquet}'";
    $deletion2 = "DELETE FROM Record WHERE Banquet_ID = '{$banquet}'";
    $deletion3 = "DELETE FROM Meal_Plan WHERE Banquet_ID = '{$banquet}'";
    $deletion4 = "DELETE FROM Banquet WHERE Banquet_ID = '{$banquet}'";
    $rs1 = mysql_query($deletion1, $db);
    $rs2 = mysql_query($deletion2, $db);
    $rs3 = mysql_query($deletion3, $db);
    $rs4 = mysql_query($deletion4, $db);
 
    header("location: ../admin-home.php");
 
?>