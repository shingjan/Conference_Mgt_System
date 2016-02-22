<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    $banquet_query = "Select * from Banquet";
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
                    <h1 style="margin-left: 30px;">Dashboard</h1>                                 
                </div>
            </div>
            <div class="menu">
                <div class="menu-item" style="padding:0; margin:0; height: 40px;">
                </div>
                <a class="menu-item" href="admin-home.php">Home</a>
                <a class="menu-item" href="create-banquet.php">Create Banquet</a>
                <a class="menu-item" href="search-banquet.php">Search Banquet</a>
                <a class="menu-item" href="search-attendee.php">Search Attendee</a>
                <a class="menu-item" href="seat-plan.php">Generate Seat</a>
                <a class="menu-item" href="report.php">Generate Report</a>
                <div class="logout">
                    <a class="menu-item" href="#">Welcome, <?=$_SESSION['admin']?></a>
                    <a class="menu-item" href="server/logout.php">logout</a>
                </div>
            </div>
            <div class="contents">
                <div class="search-result">
                    <div class="search-result-list">
                        <?php
                            while($row = mysql_fetch_assoc($banquets))
                            {
                                ?>
                                <div class="search-result-list-item">
                                    Name: <?=$row['Banquet_Name']?><br/>
                                    Time: <?=$row['Banquet_Date']?><br/>
                                    <button class="sButton" onclick='window.location.href="edit-banquet.php?bid=<?=$row['Banquet_ID']?>"'>Edit</button>
                                    <button class="sButton" onclick='window.location.href="server/deleteBanquet.php?bid=<?=$row['Banquet_ID']?>"'>Delete</button>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>