<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!$db)
        die('could not connect:'.mysql_error());
    else{
        $banquet_query = "Select * from Banquet";
        $banquets = mysql_query($banquet_query, $db);
        $tableAmount=mysql_num_rows($banquets);
        for($i=0;$i<$tableAmount;$i++){
            
        }
    }
        
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
        <script type="text/javascript">
            function seatPlan(){
                var select=document.getElementById("banquetName").value;
                window.open("server/seatPlan.php?banquetid="+select);
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">
                    <h1 style="margin-left: 30px;">Genertae Seat Plan</h1>
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
                        <form>
                            <label for="name">
                                <div style="margin-right: 20px">Banquet: </div>
                            </label>
                            <select name="banquetName" id="banquetName" size="1">
                                <?php
                                while($row = mysql_fetch_assoc($banquets))
                                {
                                    ?>
                                    <option value="<?=$row['Banquet_ID']?>">
                                    <?=$row['Banquet_Name']?><br/>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button class="sButton" onClick="seatPlan();">Generate</button>
                        </form>
                    </div>
                </div>
                <hr/>
            </div>
        </div>
    </body>
</html>