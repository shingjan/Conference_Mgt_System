<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    $banquet_query = "Select * from Banquet";
    $banquets = mysql_query($banquet_query, $db);
    $Account = $_SESSION['user'];
    $sql1="select * from Attendee where Attendee_Account='$Account'";
    $rs1=mysql_query($sql1);
    $row1=mysql_fetch_array($rs1);
    $type = $row1['Attendee_Type'];
    $Name1 = $row1['Attendee_Name'];
    $Phone1 = $row1['Attendee_PhoneNum'];
    $Address1 = $row1['Attendee_Address'];
    $Email1 = $row1['Attendee_Email'];
    $Org1 = $row1['Attendee_AffilicatedOrg'];
    
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">
                    <h1 style="margin-left: 30px;">Home</h1>
                    <h1 style="margin-left: 30px;">hello,user <?php echo($_SESSION['user']) ?>  <?php echo '<a href="logOut.php"> Log Out</a>';?></h1>
                </div>
            </div>
            <div class="menu">
                <div class="menu-item" style="padding:0; margin:0; height: 40px;">
                </div>
                <a class="menu-item" href="user-home.php">Home</a>
                <a class="menu-item" href="personalinfo.php">Personal information</a>
            </div>
            <div class="contents">
                <div class="field-group-title">
                    <h3>My information: </h3>
                       <form name="myform" method="POST">
                        Name: <input type="text" name="Name" value="<?php echo $Name;?>" /><br>
                        Address: <input type="text" name="Address" value="<?php echo $Address;?>"  /><br>
                        Phone: <input type="text" name="Phone" value="<?php echo $Phone;?>" /><br>
                        Email: <input type="text" name="Email" value="<?php echo $Email;?>" /><br>
                        Organization: <input type="text" name="Org" value="<?php echo $Org;?>" /><br>
                        Type:<?php echo $type; ?><br>
                        <input class="sButton" type="submit" value="update"/>
                      </form>
                </div>
            </div>
      </body>
</html>


// <?php
//      $Name2 = $_POST["Name"];
//      $Phone2 = $_POST["Phone"];
//      $Address2 = $_POST["Address"];
//      $Email2 = $_POST["Email"];
//      $Org2 = $_POST["Org"];
//       $sql2="UPDATE Attendee SET Attendee_Name = '$Name2', Attendee_PhoneNum='$Phone2', Attendee_Address='$Address2', Attendee_Email='$Email2', Attendee_AffilicatedOrg='$Org2'";
//      $execute=mysql_query($sql2);
//      ?>