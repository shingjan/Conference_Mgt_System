<?php
    session_start();
 
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    $banquetid = $_GET['bid'];
    $banquet_query="select * from Banquet WHERE Banquet_ID = '{$banquetid}' ";
    $meal_query = "select * from Dish ";
    $meal_result1 = mysql_query($meal_query,$db);
    $meal_result2 = mysql_query($meal_query,$db);
    $meal_result3 = mysql_query($meal_query,$db);
    $meal_result4 = mysql_query($meal_query,$db);
    $banquet_re = mysql_query($banquet_query);
    $row=mysql_fetch_array($banquet_re);
    $mealplan_query="select * from Meal_Plan WHERE Banquet_ID = '{$banquetid}'";
    $datetime = $row['Banquet_Date'];
    $datetimearr = explode(" ",$datetime);
    $date = $datetimearr[0];
    $time = $datetimearr[1];
    $mealresult  = mysql_query($mealplan_query,$db);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
        <script type="text/javascript">
            var tableCount = 1;
            
            function addTable()
            {
                tableCount++;
                var tableList = document.getElementById("tableSettings");
                var newTableList = tableList.lastElementChild.cloneNode(true);
                numberTable(newTableList, tableCount);
                if(tableCount==2)
                    newTableList.appendChild(newDeleteButton());
                tableList.appendChild(newTableList);
                window.scrollBy(0,100);
            }
            
            function deleteNodeById(id)
            {
                tableCount--;
                var node = document.getElementById(id);
                if(node != undefined)
                    node.parentNode.removeChild(node);
                renumberTables();
            }
            
            function renumberTables()
            {
                var tableList = document.getElementById("tableSettings");
                var tables = tableList.children;
                for(var i = 1; i <= tables.length; i++)
                {
                    numberTable(tables[i-1], i);
                }
            }
            
            function numberTable(table, num)
            {
                table.id = "ts" + num;
                var children = table.children;
                for(var i = 0; i < children.length; i++)
                {
                    if(children[i].tagName == "LABEL")
                        children[i].innerHTML = "Table " + num + ":";
                    if(children[i].tagName == "SELECT")
                        children[i].name = children[i].name.replace(/\d/g, num);
                    if(children[i].tagName == "BUTTON")
                        children[i].setAttribute("onclick", "deleteNodeById('ts" + num + "')");
                }
            }
            
            function newDeleteButton()
            {
                var newB = document.createElement("Button");
                newB.className = "sButton";
                newB.setAttribute("type", "button");
                newB.setAttribute("onclick", "deleteNodeById('ts" + tableCount + "')");
                newB.innerHTML = "delete";
                return newB;
            }
        </script>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1 style="margin-left: 30px;">Create new banquet</h1>
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
        </div>
        <div class="contents">
            <div class="main">
                <form action="server/updateBanquet.php" method="POST">
                    <div class="field-group">
                        <div class="field-group-title">
                            <h3>Banquet information:</h3>
                        </div>
                        <div class="field">
                            <label for="name">
                                <div>Banquet Name: </div>
                            </label>
                            <input type="text" name="name" value = <?=$row['Banquet_Name']?> required/>
                        </div>
                        <div class="field">
                            <label for="date">
                                <div>Date: </div>
                            </label>
                            <input type="date" name="date" value = <?=$date?> required/>
                        </div>
                        <div class="field">
                            <label for="time">
                                <div>Time: </div>
                            </label>
                            <input type="time" name="time" value = <?=$time?> required/>
                        </div>
                        <div class="field">
                            <label for="address">
                                <div>Address: </div>
                            </label>
                            <input type="text" name="address" value = <?=$row['Banquet_Address']?> required/>
                        </div>
                        <div class="field">
                            <label for="location">
                                <div>Location: </div>
                            </label>
                            <input type="text" name="location" value = <?=$row['Banquet_Location']?> required/>
                        </div>
                    </div>
                    <div class="field-group">
                        <div class="field-group-title">
                            <h3>Banquet contact:</h3>
                        </div>
                        <div class="field">
                            <label for="cFname">
                                <div>First Name: </div>
                            </label>
                            <input type="text" name="cFname" value = <?=$row['Banquet_Contact_Fname']?> required/>
                        </div>
                        <div class="field">
                            <label for="cLname">
                                <div>Last Name: </div>
                            </label>
                            <input type="text" name="cLname" value = <?=$row['Banquet_Contact_Lname']?> required/>
                        </div>
                    </div>
                    <div class="field-group">
                        <div class="field-group-title">
                            <h3>Meals: </h3>
                        </div>
                        <div class="field">
                              <label for="meal1">
                                  <div>Meal 1: </div>
                              </label>
                               <div class="radio-group">
                            <?php
                                $rowmeal = mysql_fetch_array($mealresult);
                                while($meal1 = mysql_fetch_assoc($meal_result1))
                                {
                                    ?>
                                    <div class="radio">        
                                    <input type="radio" name="meal1" <?=($meal1['Dish_ID']==$rowmeal['Dish_ID'])?('checked'):('')?> value="<?=$meal1['Dish_ID']?>" >
                                       Meal: <?=$meal1['Dish_Name']?></div><br/>
                                    <?php 
                                }
                            ?>
                            </div>
                        </div>
                        <div class="field">
                              <label for="meal2">
                                  <div>Meal 2: </div>
                              </label>
                               <div class="radio-group">
                           <?php
                                $rowmeal = mysql_fetch_array($mealresult);
                                while($meal2 = mysql_fetch_assoc($meal_result2))
                                {
                                    ?>
                                    <div class="radio">        
                                    <input type="radio" name="meal2" <?=($meal2['Dish_ID']==$rowmeal['Dish_ID'])?('checked'):('')?> value="<?=$meal2['Dish_ID']?>">
                                       Meal: <?=$meal2['Dish_Name']?></div><br/>
                                    <?php 
                                }
                            ?>
                            </div>
                        </div>
                        <div class="field">
                              <label for="meal3">
                                  <div>Meal 3: </div>
                              </label>
                               <div class="radio-group">
                             <?php
                                $rowmeal = mysql_fetch_array($mealresult);
                                while($meal3 = mysql_fetch_assoc($meal_result3))
                                {
                                    ?>
                                    <div class="radio">        
                                    <input type="radio" name="meal3" <?=($meal3['Dish_ID']==$rowmeal['Dish_ID'])?('checked'):('')?> value="<?=$meal3['Dish_ID']?>">
                                       Meal: <?=$meal3['Dish_Name']?></div><br/>
                                    <?php 
                                }
                            ?>
                            </div>
                        </div>
                        <div class="field">
                              <label for="meal4">
                                  <div>Meal 4: </div>
                              </label>
                               <div class="radio-group">
                            <?php
                                $rowmeal = mysql_fetch_array($mealresult);
                                while($meal4 = mysql_fetch_assoc($meal_result4))
                                {
                                    ?>
                                    <div class="radio">        
                                    <input type="radio" name="meal4" <?=($meal4['Dish_ID']==$rowmeal['Dish_ID'])?('checked'):('')?> value="<?=$meal4['Dish_ID']?>">
                                       Meal: <?=$meal4['Dish_Name']?></div><br/>
                                    <?php 
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="field-group">
                        <div class="field-group-title">
                            <h3>Table setting:</h3>
                        </div>
                        <div class="field">
                            <div id="tableSettings">
                                <?php
                                    $tables_query = "Select * from TableSet WHERE Banquet_ID = '{$banquetid}' ";
                                    $tables_result = mysql_query($tables_query, $db);
                                    $i = 1;
                                    while($table = mysql_fetch_assoc($tables_result))
                                    {
                                        ?>
                                            <div class="table-setting" id="ts<?=$table['Table_ID']?>">
                                                <label for="tableName">Table <?=$i++?>:</label>
                                                <div class="table-setting-item">Shape: </div>
                                                <select name="table<?=$table['Table_ID']?>shape" size="1" required>
                                                    <option <?=("Circle"==$table['Table_Type'])?('selected="selected"'):('')?>>Circle</option>
                                                    <option <?=("Oval"==$table['Table_Type'])?('selected="selected"'):('')?>>Oval</option>
                                                    <option <?=("Square"==$table['Table_Type'])?('selected="selected"'):('')?>>Square</option>
                                                </select>
                                                <div class="table-setting-item">For: </div>
                                                <select name="table<?=$table['Table_ID']?>for" size="1" required>
                                                    <option <?=("VIP"==$table['Table_User'])?('selected="selected"'):('')?>>VIP</option>
                                                    <option <?=("Sponsors"==$table['Table_User'])?('selected="selected"'):('')?>>Sponsors</option>
                                                    <option <?=("Others"==$table['Table_User'])?('selected="selected"'):('')?>>Others</option>
                                                </select>
                                                <div class="table-setting-item">Seat: </div>
                                                <select name="table<?=$table['Table_ID']?>" size="1" required>
                                                    <option <?=(14==$table['Table_Cap'])?('selected="selected"'):('')?>>14</option>
                                                    <option <?=(13==$table['Table_Cap'])?('selected="selected"'):('')?>>13</option>
                                                    <option <?=(12==$table['Table_Cap'])?('selected="selected"'):('')?>>12</option>
                                                    <option <?=(11==$table['Table_Cap'])?('selected="selected"'):('')?>>11</option>
                                                    <option <?=(10==$table['Table_Cap'])?('selected="selected"'):('')?>>10</option>
                                                    <option <?=(9==$table['Table_Cap'])?('selected="selected"'):('')?>>9</option>
                                                    <option <?=(8==$table['Table_Cap'])?('selected="selected"'):('')?>>8</option>
                                                    <option <?=(7==$table['Table_Cap'])?('selected="selected"'):('')?>>7</option>
                                                    <option <?=(6==$table['Table_Cap'])?('selected="selected"'):('')?>>6</option>
                                                    <option <?=(5==$table['Table_Cap'])?('selected="selected"'):('')?>>5</option>
                                                    <option <?=(4==$table['Table_Cap'])?('selected="selected"'):('')?>>4</option>
                                                    <option <?=(3==$table['Table_Cap'])?('selected="selected"'):('')?>>3</option>
                                                    <option <?=(2==$table['Table_Cap'])?('selected="selected"'):('')?>>2</option>
                                                    <option <?=(1==$table['Table_Cap'])?('selected="selected"'):('')?>>1</option>
                                                </select>
                                            </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <input hidden="hidden" type="text" name="bid" value="<?=$_GET['bid']?>"/>
                    <input class="sButton" type="submit" value="Update"/>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>