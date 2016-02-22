<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    $user= $_SESSION['uid'];
    $banquet=$_GET['bid'];
    
    $sql1="select * from Attendee where Attendee_ID='{$user}'";
    $sql2="select * from Banquet where Banquet_ID='{$banquet}'";
    $rs1 = mysql_query($sql1, $db);
    $rs2 = mysql_query($sql2, $db);
    $num1=mysql_num_rows($rs1);
    $num2=mysql_num_rows($rs2);
    $row1=mysql_fetch_array($rs1);
    $row2=mysql_fetch_array($rs2);
    
    $name=$row1['Attendee_Name'];
    $type=$row1['Attendee_Type'];
    $email=$row1['Attendee_Email'];
    $phone=$row1['Attendee_Phonenum']; 
    $address=$row1['Attendee_Address'];
    $org=$row1['Attendee_AffilicatedOrg'];
    $banquetname=$row2['Banquet_Name'];
    
    $table_query="select * from TableSet where Banquet_ID='{$banquet}' and Table_User ='{$type}'";
    $tables_result = mysql_query($table_query, $db);
    $tables_result1 = mysql_query($table_query, $db);
    $rowtable=mysql_fetch_array($tables_result1);

    $meal_query = "select * from Meal_Plan,Dish where Meal_Plan.Banquet_ID = '{$banquet}' and Meal_Plan.Dish_ID = Dish.Dish_ID ";
    $meal_result = mysql_query($meal_query,$db);
    
    $drink = "select * from Drink";
    $drink_result = mysql_query($drink, $db);
    
    $record_query="select * from Record WHERE Banquet_ID = '{$banquet}' And Attendee_ID = '{$user}' ";
    $record_result = mysql_query($record_query, $db);
    $record = mysql_fetch_array($record_result);
                     
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
        <script type="text/javascript">
            function getSeat()
            {
                var table = document.getElementById("table");
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function()
                {
                    if(xhr.readyState == 4 && xhr.status == 200)
                    {
                        document.getElementById("seat").innerHTML = xhr.responseText;
                        console.log(xhr.responseText);
                    }
                };
                xhr.open("GET", "server/getSeat.php?bid=<?=$_GET['bid']?>&aid=<?=$user?>&tid="+table.value, true);
                xhr.send();
            }
        </script>
    </head>
<body onload="getSeat()">
    <div class="container">
        <div class="header">
            <h1 style="margin-left: 30px;">Register</h1>
        </div>
        <div class="menu">
            <div class="menu-item" style="padding:0; margin:0; height: 40px;">
            </div>
            <a class="menu-item" href="user-home.php">Home</a>
            <div class="logout">
                <a class="menu-item" href="#">Welcome, <?=$_SESSION['user']?></a>
                <a class="menu-item" href="logout.php">logout</a>
            </div>
        </div>
        <div class="contents">
            <form action="server/updateRecord.php" method="POST">
                <div>
                    <h2>Update for <?=$banquetname?></h2>
                </div>
                <div class="field-group">
                    <div class="field-group-title">
                        <h3>Information:</h3>
                    </div>
                    <div class="field">
                        <label for="id">
                            <div>Attendee ID: </div>
                        </label>
                        <p class="field-describ"><?=$banquet?></p>
                        <input type="text" name="rid" hidden="hidden" value="<?=$record['Record_ID']?>"/>
                    </div>
                    <div class="field">
                        <label for="type">
                            <div>Type: </div>
                        </label>
                        <p class="field-describ"><?=$type?></p>
                    </div>
                    <div class="field-group">
                        <div class="field">
                            <label for="name">
                                <div>Name: </div>
                            </label>
                          <p class="field-describ"><?=$name?></p>
                        </div>
                    </div>
                    <div class="field">
                        <label for="email">
                            <div>Email: </div>
                        </label>
                        <p class="field-describ"><?=$email?></p>
                    </div>
                    <div class="field">
                        <label for="address">
                            <div>Address: </div>
                        </label>
                        <p class="field-describ"><?=$address?></p>
                    </div>
                    <div class="field">
                        <label for="organization">
                            <div>Affiliated Organization: </div>
                        </label>
                        <p class="field-describ"><?=$org?></p>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field-group-title">
                        <h3>Table and seat:</h3>
                    </div>
                    <div class="field">
                        <label for="table">
                            Select table:
                        </label>
                        <select name="table" id="table" size="1" onchange="getSeat()">
                            <!--在这里写table-->
                        <?php
                            while($table = mysql_fetch_assoc($tables_result))
                            {
                                ?>
                                    <option value="<?=$table['Table_ID']?>" <?=(($table['Table_ID']==$record['Record_Table']) ? ' selected="selected" ' : '')?>>
                                        Table <?=$table['Table_Number']?>
                                    </option>
                                <?php
                            }
                        ?>
                        </select>
                    </div>
                    <div class="field">
                        <label for="seat">
                            Select seat:
                        </label>
                        <select name="seat" id="seat" size="1">
                        </select>
                    </div>
                </div>
                
                <div class="field-group">
                    <div class="field-group-title">
                        <h3>Meal & Drink</h3>
                    </div>
                    <div class="field">
                        <label for="meal">
                            <div>Meal:</div>
                        </label>
                        <div class="radio-group">
                        <?php
                            while($meal = mysql_fetch_assoc($meal_result))
                            {
                                ?>
                                 <div class="radio">        
                                <input type="radio" name="meal" <?=($meal['Dish_ID']==$record['Dish_ID'])?('checked'):('')?> value="<?=$meal['Dish_ID']?>" >
                                   Meal: <?=$meal['Dish_Name']?></div><br/>
                                <?php 
                            }
                        ?>
                        </div>
                    </div>
                    <div class="field">
                        <label for="drink">
                            <div>Drink:</div>
                        </label>
                        <div class="radio-group">
                        <?php
                            while($drink = mysql_fetch_assoc($drink_result))
                            {
                                ?>
                                <div class="radio">
                               <input type="radio" name="drink" <?=($drink['Drink_ID']==$record['Drink_ID'])?('checked'):('')?> value="<?=$drink['Drink_ID']?>" >
                                   Drink: <?=$drink['Drink_Name']?></div><br/>
                                <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label for="remarks">
                        <div>Remarks: </div>
                    </label>
                    <input type="text" name="remark" value="<?=$record['Record_Remarks'].$record['Record_VIPRemark']?>" />
                </div>
                
                <input class="sButton" type="submit" value="Update"/>
            </form>
        </div>
    </div>
</body>
</html>