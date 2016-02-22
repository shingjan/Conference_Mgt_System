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

    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!$db)
        die('could not connect:'.mysql_error());
    else
    {
        $name = $_POST['name'];
        $date = strtotime($_POST['date'] . " " . $_POST['time']);
        $bdat = date("Y-m-d H:i:s", $date);
        $addr = $_POST['address'];
        $loca = $_POST['location'];
        $cofn = $_POST['cFname'];
        $coln = $_POST['cLname'];
        
        $mel1 = $_POST['meal1'];
        $mel2 = $_POST['meal2'];
        $mel3 = $_POST['meal3'];
        $mel4 = $_POST['meal4'];
        
        $tbls = array();
        $i = 1;
        while(isset($_POST['table'.$i]))
        {
            array_push($tbls, array($_POST['table'.$i.'shape'], $_POST['table'.$i.'for'], $_POST['table'.$i]));
            $i++;
        }
        $capa = 0;
        foreach($tbls as $table)
        {
            $capa += (int)$table[2];
        }
        
        
        $insertion = "INSERT INTO Banquet (Banquet_Name, Banquet_Date, Banquet_Address, Banquet_Location, 
            Banquet_Contact_Fname, Banquet_Contact_Lname, Banquet_Status, Banquet_Cap) value ('"
            .$name."','".$bdat."','".$addr."','".$loca."','".$cofn."','".$coln."','"."undergo"."',".$capa.")";
        $insert = mysql_query($insertion, $db);
        
        $select ="select Banquet_ID from Banquet order by Banquet_ID desc LIMIT 1";
        $query=mysql_query($select);
        $banquetID = mysql_result($query,0,0);
        
        for($i = 0; $i < count($tbls); $i++)
        {
            $table = $tbls[$i];
            $createTable = "insert into TableSet (Table_Number, Table_Type, Table_User, Table_Cap, Banquet_ID) values (". ($i+1) .", '".$table[0]."', '".$table[1]."', '".$table[2]."', '".$banquetID."')";
            $query = mysql_query($createTable, $db);
            echo mysql_error();
        }
        
        $mealplaninsertion1 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel1."', '".$banquetID."')";
        $mealplaninsertion2 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel2."', '".$banquetID."')";
        $mealplaninsertion3 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel3."', '".$banquetID."')";
        $mealplaninsertion4 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel4."', '".$banquetID."')";
        $mealquery1=mysql_query($mealplaninsertion1,$db);
        $mealquery2=mysql_query($mealplaninsertion2,$db);
        $mealquery3=mysql_query($mealplaninsertion3,$db);
        $mealquery4=mysql_query($mealplaninsertion4,$db);
        
        header("location: ../admin-home.php");
        
        
    }
?>