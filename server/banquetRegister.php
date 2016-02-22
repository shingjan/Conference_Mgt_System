<?php
    
    // +-----------------------+--------------+------+-----+-------------------+----------------+
    // | Field                 | Type         | Null | Key | Default           | Extra          |
    // +-----------------------+--------------+------+-----+-------------------+----------------+
    // | Banquet_ID            | int(5)       | NO   | PRI | NULL              | auto_increment |
    // | Banquet_Name          | varchar(255) | NO   |     | NULL              |                |
    // | Banquet_Date          | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
    // | Banquet_Address       | text         | NO   |     | NULL              |                |
    // | Banquet_Location      | text         | NO   |     | NULL              |                |
    // | Banquet_Contact_Fname | varchar(255) | NO   |     | NULL              |                |
    // | Banquet_Contact_Lname | varchar(255) | NO   |     | NULL              |                |
    // | Banquet_Status        | varchar(255) | NO   |     | NULL              |                |
    // | Banquet_Cap           | int(11)      | NO   |     | NULL              |                |
    // +-----------------------+--------------+------+-----+-------------------+----------------+
    // [name] => [date] => [time] => [address] => [location] => [cFname] => [cLname] => [meal1] => [meal2] => [meal3] => [meal4] => [table1] => 14
    
// +-------------------------+--------------+------+-----+---------+-------+
// | Field                   | Type         | Null | Key | Default | Extra |
// +-------------------------+--------------+------+-----+---------+-------+
// | Attendee_ID             | int(11)      | NO   | PRI | NULL    |       |
// | Attendee_Name           | varchar(255) | NO   |     | NULL    |       |
// | Attendee_Address        | varchar(255) | NO   |     | NULL    |       |
// | Attendee_PhoneNum       | char(8)      | NO   |     | NULL    |       |
// | Attendee_Email          | varchar(50)  | NO   |     | NULL    |       |
// | Attendee_AffilicatedOrg | varchar(50)  | NO   |     | NULL    |       |
// | Attendee_Type           | varchar(50)  | NO   |     | NULL    |       |
// | Attendee_Account        | varchar(50)  | NO   |     | NULL    |       |
// | Attendee_Password       | varchar(50)  | NO   |     | NULL    |       |
// +-------------------------+--------------+------+-----+---------+-------+
    
// +------------------+-------------+------+-----+---------+-------+
// | Field            | Type        | Null | Key | Default | Extra |
// +------------------+-------------+------+-----+---------+-------+
// | Record_ID        | int(11)     | NO   | PRI | NULL    |       |
// | Record_Remarks   | text        | YES  |     | NULL    |       |
// | Record_Payment   | varchar(50) | NO   |     | NULL    |       |
// | Attendee_ID      | int(11)     | NO   | MUL | NULL    |       |
// | Drink_ID         | int(11)     | NO   | MUL | NULL    |       |
// | Dish_ID          | int(11)     | NO   | MUL | NULL    |       |
// | Banquet_ID       | int(11)     | NO   | MUL | NULL    |       |
// | Record_Seatnum   | int(11)     | NO   |     | NULL    |       |
// | Record_Table     | int(11)     | NO   |     | NULL    |       |
// | Record_VIPRemark | text        | YES  |     | NULL    |       |
// +------------------+-------------+------+-----+---------+-------+
    

    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    session_start();
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!$db)
        die('could not connect:'.mysql_error());
    else
    {
        $type = $_POST['type'];
        $table = $_POST['table'];
        $seat = $_POST['seat'];
        $meal = $_POST['meal'];
        $drink = $_POST['drink'];
        $remark = $_POST['remark'];
        $payment = "Unpaid";
        
        $banquet = $_GET['bid'];
        $userid = $_SESSION['uid'];//OK?
        
        $sql="insert into Record (Record_Payment, Attendee_ID, Drink_ID, Dish_ID, Banquet_ID, Record_Seatnum, Record_Table, Record_Remarks) values ('{$payment}', '{$userid}', '{$drink}', '{$meal}', '{$banquet}', '{$seat}', '{$table}', '{$remark}')";
        if($query=mysql_query($sql)){
            echo "success.";
            header("location:../user-home.php");
        }
        else echo "error: ".mysql_error($db); 
    }
?>