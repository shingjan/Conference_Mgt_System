<?php
    session_start();
    unset($_SESSION['admin']);
    unset($_SESSION['user']);
    
    $db=mysql_connect("mysql.comp.polyu.edu.hk","13104448d","suling1234");
    mysql_select_db("13104448d");
    if(!$db)
        die('could not connect:'.mysql_error());
    else
    {
        $account=$_POST['account'];
        $pwd=$_POST['pwd'];
        $sql1="select * from Admin where Admin_ID='{$account}' and Admin_Password='{$pwd}'";
        $sql2="select * from Attendee where Attendee_Account='{$account}'and Attendee_Password='{$pwd}'";
        $rs1=mysql_query($sql1);
        $rs2=mysql_query($sql2);
        
        $num1=mysql_num_rows($rs1);
        $num2=mysql_num_rows($rs2);

        if($num1)
        {
                $row1=mysql_fetch_array($rs1);
                $_SESSION['admin']=$row1['Admin_ID'];
                header("location: ../admin-home.php");
        }
        else if($num2)
        {
                $row2=mysql_fetch_array($rs2);
                $_SESSION['uid'] = $row2['Attendee_ID'];
                $_SESSION['user'] = $row2['Attendee_Account'];
                header("location: ../confirm-information.php");
        }
        else {echo "UserName not exist or Wrong password";}
    }
?>