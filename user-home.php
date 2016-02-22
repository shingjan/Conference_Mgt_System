<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    $banquet_query = "Select * from Banquet ";
    $banquets = mysql_query($banquet_query, $db);

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
                </div>
            </div>
            <div class="menu">
                <div class="menu-item" style="padding:0; margin:0; height: 40px;">
                </div>
                <a class="menu-item" href="user-home.php">Home</a>
                <div class="logout">
                    <a class="menu-item" href="#">Welcome, <?=$_SESSION['user']?></a>
                    <a class="menu-item" href="server/logout.php">logout</a>
                </div>
            </div>
            <div class="contents">
                <div class="field-group-title">
                    <h3>Registered Banquet: </h3>
                </div>
                <div class="search-result-list">
                    <?php
                        $userbanquet_query = "SELECT * FROM Banquet WHERE Banquet_ID IN (
                            SELECT Banquet_ID FROM Record,Attendee WHERE Attendee.Attendee_Account = '".$_SESSION['user']."' And Record.Attendee_ID = Attendee.Attendee_ID)";
                        $userbanquets = mysql_query($userbanquet_query, $db);
                        while($registed = mysql_fetch_assoc($userbanquets))
                        {
                            ?>
                            <div class="search-result-list-item">
                                Name: <?=$registed['Banquet_Name']?><br/>
                                Time: <?=$registed['Banquet_Date']?><br/>
                                <button class="sButton" onclick = "window.location.href='edit-record.php?bid=<?=$registed['Banquet_ID']?>'">Edit</button>
                                <button class="sButton"  onclick = "window.location.href='server/deleteRecord.php?bid=<?=$registed['Banquet_ID']?>'">Delete</button>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <hr/>
                <div class="field-group-title">
                    <h3>Available Banquet: </h3>
                </div>
                <div class="search-result-list">
                    <?php
                        while($row = mysql_fetch_assoc($banquets))
                        {
                            ?>
                           
                            <div class="search-result-list-item">
                                Name: <?=$row['Banquet_Name']?><br/>
                                Time: <?=$row['Banquet_Date']?><br/>
                                <button class="sButton" onclick = "window.location.href='register.php?bid=<?=$row['Banquet_ID']?>'">Register</button>
                            </div>
                           
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>