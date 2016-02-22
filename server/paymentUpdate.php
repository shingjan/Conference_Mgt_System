<?php
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    session_start();
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!isset($_SESSION['admin']))
        header('location: ../index.php');
    
    if(!$db)
        die('could not connect:'.mysql_error());
    else
    {
        $payment=$_POST['payment'];
        $rid=(int)$_POST['recordid'];
        $sql="update Record set Record_Payment='$payment' where Record_ID='$rid'";
        if(mysql_query($sql, $db))
            echo "Success";
        else
            echo mysql_error();
    }
?>