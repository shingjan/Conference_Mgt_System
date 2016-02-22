<?php
 $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    session_start();
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!$db)
        die('could not connect:'.mysql_error());
    else
    {
        $id=$_POST['recordid'];
        $meal=$_POST['meal'];
        $drink=$_POST['drink'];
        $remark=$_POST['remark'];
        
        $sqlType="select Attendee_Type from Attendee, Record where Attendee.Attendee_ID=Record.Attendee_ID and Record.Record_ID='$id'";
        $queryType=mysql_query($sqlType, $db);
        $row = mysql_fetch_assoc($queryType);
        $type = $row['Attendee_Type'];
        
        if($type!="Other")
            $sql="update Record set Drink_ID='$drink', Dish_ID='$meal', Record_VIPRemark='$remark' where Record_ID='$id'";
        else
            $sql="update Record set Drink_ID='$drink', Dish_ID='$meal', Record_Remarks='$remark' where Record_ID='$id'";
            
        if($query=mysql_query($sql)){
            echo "Success";   
        }
    }
?>