<?php

    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    $banquetID=$_POST['bid'];
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!isset($_SESSION['admin']))
    {
        header("location: ../index.php");
    }
    
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
        $status=$_POST['Status'];
        
        $mel1 = $_POST['meal1'];
        $mel2 = $_POST['meal2'];
        $mel3 = $_POST['meal3'];
        $mel4 = $_POST['meal4'];
        
        $tbls = array();
        $i = 1;
        while(!isset($_POST['table'.$i]))
            $i++;
        
        $firstTableID = $i;
        
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
        
        $update = "Update Banquet SET Banquet_Name = '".$name."', Banquet_Date='".$bdat."', Banquet_Address='".$addr."', Banquet_Location='".$loca."', 
            Banquet_Contact_Fname= '".$cofn."', Banquet_Contact_Lname='".$coln."', Banquet_Status=".$status.", Banquet_Cap = ".$capa."
            Where Banquet_ID = '{$banquetID}'";
        $update = mysql_query($update, $db);
        
        for($j = 0; $j < count($tbls); $j++)
        {
            $table = $tbls[$j];
            $updateTable = "Update TableSet Set Table_Type = '".$table[0]."', Table_User = '".$table[1]."', Table_Cap = '".$table[2]."' where Table_ID = ".($j + $firstTableID);
            $query = mysql_query($updateTable, $db);
            echo mysql_error();
        }
        
        $resetMealPlan = "Delete from Meal_Plan where Banquet_ID = ".$banquetID;
        mysql_query($resetMealPlan, $db);
        
        $mealplaninsertion1 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel1."', '".$banquetID."')";
        $mealplaninsertion2 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel2."', '".$banquetID."')";
        $mealplaninsertion3 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel3."', '".$banquetID."')";
        $mealplaninsertion4 = "INSERT INTO Meal_Plan(Dish_ID, Banquet_ID) value ('".$mel4."', '".$banquetID."')";
        $mealquery1=mysql_query($mealplaninsertion1, $db);
        $mealquery2=mysql_query($mealplaninsertion2, $db);
        $mealquery3=mysql_query($mealplaninsertion3, $db);
        $mealquery4=mysql_query($mealplaninsertion4, $db);
        
        header("location: ../admin-home.php");
        
    }
?>