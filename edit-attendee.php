<?php
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    session_start();
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!$db)
        die('could not connect:'.mysql_error());
    else
    {
        $id=$_GET['attendeeid'];
        $sql="select * from Attendee where Attendee_ID='$id'";
        $query=mysql_query($sql);
        $row1=mysql_fetch_array($query);
        // echo mysql_num_rows($query);
    $Type = $row1['Attendee_Type'];
    $Name = $row1['Attendee_Name'];
    $Phone = $row1['Attendee_PhoneNum'];
    $Address = $row1['Attendee_Address'];
    $Email = $row1['Attendee_Email'];
    $Org = $row1['Attendee_AffilicatedOrg'];
    // // echo "name".$Type.$Name;
    $record="select * from Record, Dish, Drink where Record.Drink_ID=Drink.Drink_ID and Record.Dish_ID=Dish.Dish_ID and Attendee_ID='$id'";
    $query2=mysql_query($record);
    
    // $sqlDish="select * from Dish";
    // $queryDish=mysql_query($sqlDish);
    // $sqlDrink="select * from Drink";
    // $queryDrink=mysql_query($sqlDrink);
    
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
        <script type="text/javascript">
            function editRecord(e){
                var meal=document.getElementById("Meal"+e).value;
                var drink=document.getElementById("Drink"+e).value;
                var remark=document.getElementById("Remark"+e).value;
                
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function()
                {
                    if(xhr.readyState == 4 && xhr.status == 200)
                        alert(xhr.responseText);
                }
                xhr.open("POST", "server/editRecord.php", true);
                xhr.send("recordid="+e+"&meal="+meal+"&drink="+drink+"&remark="+remark);
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">
                    <h1 style="margin-left: 30px;">Edit Attendee</h1>
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
                <div class="logout">
                    <a class="menu-item" href="#">Welcome, <?=$_SESSION['admin']?></a>
                    <a class="menu-item" href="server/logout.php">logout</a>
                </div>
            </div>
            <div class="contents">
                <div class="field-group-title">
                    <h3>My information: </h3>
                    <form name="myform" action="server/updateInfo.php" method="POST">
                        <div class="field">
                            <label for="Name">
                                <div>Name:</div>
                            </label>
                            <input type="text" name="Name" value="<?=$Name?>" />
                        </div>
                        <div class="field">
                            <label for="Address">
                                <div>Address:</div>
                            </label>
                            <input type="text" name="Address" value="<?=$Address?>"  />
                        </div>
                        <div class="field">
                            <label for="Phone">
                                <div>Phone:</div>
                            </label>
                            <input type="text" name="Phone" value="<?=$Phone?>" />
                        </div>
                        <div class="field">
                            <label for="Email">
                                <div>Email:</div>
                            </label>
                            <input type="text" name="Email" value="<?=$Email?>" />
                        </div>
                        <div class="field">
                            <label for="Organization">
                                <div>Organization:</div>
                            </label>
                            <input type="text" name="Org" value="<?=$Org?>" />
                        </div>
                        <div class="field">
                            <label for="Type">
                                <div>Type:</div>
                            </label>
                            <input type="text" name="Type" value="<?=$Type?>" />
                        </div>
                        <input class="sButton" type="submit" value="Update"/>
                    </form>
                    <?php 
                        if(mysql_num_rows($query2)>0){
                            while($row = mysql_fetch_assoc($query2)){
                            ?>
                                <div class="field">Record ID: <?=$row['Record_ID']?></div>
                                <div class="field">
                                    <label for="meal">
                                        Meal:
                                    </label>
                                    <select id="Meal<?=$row['Record_ID']?>" name="meal">
                                        <?php
                                            $sqlDish="select * from Dish";
                                            $queryDish=mysql_query($sqlDish);
                                            while($dishRow=mysql_fetch_assoc($queryDish)){
                                                ?>
                                                <option value=<?=$dishRow['Dish_ID']?> <?php if($row['Dish_ID']==$dishRow['Dish_ID']) echo "selected=\"selected\""; ?>><?=$dishRow['Dish_Name']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="drink">
                                        Drink:
                                    </label>
                                    <select id="Drink<?=$row['Record_ID']?>" name="drink">
                                        <?php
                                            $sqlDrink="select * from Drink";
                                            $queryDrink=mysql_query($sqlDrink);
                                            while($drinkRow=mysql_fetch_assoc($queryDrink)){
                                                ?>
                                                <option value=<?=$drinkRow['Drink_ID']?> <?php if($row['Drink_ID']==$drinkRow['Drink_ID']) echo "selected=\"selected\""; ?>><?=$drinkRow['Drink_Name']?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="remark">
                                        Remark:</label>
                                    <input style="margin-left: 10px" type="text" id="Remark<?=$row['Record_ID']?>" value="<?=$row['Record_Remarks'].$row['Record_VIPRemark']; ?>"/>
                                </div>
                                <input style="margin-top: 20px; margin-bottom: 20px;" class="sButton" type="button" onClick="editRecord(<?=$row['Record_ID']?>);" value="Update"/>
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
      </body>
</html>