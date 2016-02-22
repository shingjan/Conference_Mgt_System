<?php 
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    session_start();
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!isset($_SESSION['admin']) && !isset($_SESSION['user']))
        header("location: ../index.php");
    
    if(!$db)
    {
        die('could not connect:'.mysql_error());
        echo "failed";
    }
    else
    {
        $recordid = $_POST['rid'];
        $meal = $_POST['meal'];
        $drink = $_POST['drink'];
        $remark = $_POST['remark'];
        $table = $_POST['table'];
        $seat = $_POST['seat'];
        
        $sql="update Record set Drink_ID = {$drink}, Dish_ID = {$meal}, Record_Seatnum = {$seat}, Record_Table = {$table}, Record_Remarks = '{$remark}' WHERE Record_ID = {$recordid} ";
        echo "<br/>";
        echo $sql;
        echo "<br/>";
        echo "<br/>";
        
        $query=mysql_query($sql, $db);
        if($query=mysql_query($sql, $db))
            header("location:../user-home.php");
        else 
            echo mysql_error();
    }
?>