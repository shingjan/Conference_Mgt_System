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
                <a class="menu-item" href="login.php">Login</a>
            </div>
            <div class="contents">
                <div class="search-result">
                    <div class="field-group-title">
                        <h2>All banquets</h2>
                    </div>
                    <div class="search-result-list">
                        <?php
                            while($row = mysql_fetch_assoc($banquets))
                            {
                                ?>
                                <div class="search-result-list-item">
                                    Name: <?=$row['Banquet_Name']?><br/>
                                    Time: <?=$row['Banquet_Date']?><br/>
                                    State: <?=$row['Banquet_Status']?><br/>
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