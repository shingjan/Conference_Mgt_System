<?php
    session_start();
    if(!isset($_SESSION['admin']))
        header("location: index.php");

    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    if(isset($_POST['name']))
    {
        $banquet_query = "Select * from Banquet WHERE Banquet_Name LIKE '%".$_POST['name']."%'";
        $banquets = mysql_query($banquet_query, $db);
        $display = true;
        
        echo mysql_error();
    }
    else if(isset($_POST['fromDate']) && isset($_POST['toDate']))
    {
        $banquet_query = "Select * from Banquet WHERE Banquet_Date BETWEEN '".$_POST['fromDate']." 00:00:00"."' AND '".$_POST['toDate']." 23:59:59"."'";
        $banquets = mysql_query($banquet_query, $db);
        $display = true;
        
        echo mysql_error();
    }
    else
        $display = false;
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
                    <h1 style="margin-left: 30px;">Search banquet</h1>
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
                <div class="search-option">
                    <div class="field-group">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <label for="name">Name: </label><input type="text" name="name"/>
                            <input class="sButton" type="submit" value="Search"/>
                        </form>
                    </div>
                    <div class="field-group">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <label for="fromDate">From: </label><input type="date" name="fromDate"/>
                            <label for="toDate" style="width: 30px;">to: </label><input type="date" name="toDate"/>
                            <input class="sButton" type="submit" value="Search"/>
                        </form>
                    </div>
                </div>
                <hr/>
                <div class="search-result">
                    <div class="search-result-list" >
                        <?php
                            while($display && $row = mysql_fetch_assoc($banquets))
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