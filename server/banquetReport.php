<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    date_default_timezone_set("Asia/Hong_Kong");
    
    if(!$db)
        die('could not connect:'.mysql_error());
    
    $banquetid = $_GET['banquetid'];
    
    $banquetInfoSQL = "Select * from Banquet where Banquet_ID = '". $banquetid."'";
    $banquet_result = mysql_query($banquetInfoSQL);
    $banquet_row = mysql_fetch_assoc($banquet_result);
    
    $attendeeSQL = "select Attendee_Name, Record_Seatnum, Record_Table from Attendee, Record where Attendee.Attendee_ID=Record.Attendee_ID and Banquet_ID='$banquetid' order by Attendee_Name";
    $attendee_result = mysql_query($attendeeSQL, $db);
?>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
    </head>
    <body>
        <div class="contents" style="width: 800px; margin: 0 auto;">
            <div class="field-group-title" style="text-align:center">
                <h1>Report for <?=$banquet_row['Banquet_Name']?></h1>
            </div>
            <div class="field-group-title">
                <h2>Banquet Information:</h2>
            </div>
            
            <div class="field">
                <label for="ID">ID:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_ID']?></p>
            </div>
            <div class="field">
                <label for="Name">Name:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_Name']?></p>
            </div>
            <div class="field">
                <label for="Date">Date:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_Date']?></p>
            </div>
            <div class="field">
                <label for="Address">Address:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_Address']?></p>
            </div>
            <div class="field">
                <label for="Location">Location:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_Location']?></p>
            </div>
            <div class="field">
                <label for="Contact">Contact:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_Contact_Fname']." ".$banquet_row['Banquet_Contact_Lname']?></p>
            </div>
            <div class="field">
                <label for="Status">Status:</label>
                <p class="field-describ"><?=$banquet_row['Banquet_Status']?></p>
            </div>
            <div class="field">
                <label for="totalAttendee">Total attendee:</label>
                <p class="field-describ"><?=mysql_num_rows($attendee_result)?></p>
            </div>
            <hr/>
            <div class="field-group-title">
                <h2>Meal Summary</h2>
            </div>
            <?php
                $mealSummary = "Select count(*) as count, Dish_Name from Dish, Record Where Dish.Dish_ID = Record.Dish_ID AND Record.Banquet_ID = {$banquetid} Group By Record.Dish_ID;";
                $drinkSummary = "Select count(*) as count, Drink_Name from Drink, Record Where Drink.Drink_ID = Record.Drink_ID AND Record.Banquet_ID = {$banquetid} Group By Record.Drink_ID;";
                $meal_result = mysql_query($mealSummary, $db);
                $drink_result = mysql_query($drinkSummary, $db);
                echo mysql_error();
                ?>
                <div class="field">
                    <h4>Dishes summary:</h4>
                </div>
                <div class="search-result-list" style="margin: 10px 30% 0; text-align: center">
                    <table border="1">
                        <tr class="search-result-list-row-header">
                            <th>Dish Name</th>
                            <th>Total order</th>
                        </tr>
                        <?php
                        while($meal = mysql_fetch_assoc($meal_result))
                        {
                            ?>
                            <tr class="search-result-list-row">
                                <td><?=$meal['Dish_Name']?></td>
                                <td><?=$meal['count']?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="field">
                    <h4>Drinks summary:</h4>
                </div>
                <div class="search-result-list" style="margin: 10px 30% 0; text-align: center">
                    <table border="1">
                        <tr class="search-result-list-row-header">
                            <th>Dish Name</th>
                            <th>Total order</th>
                        </tr>
                        <?php
                        while($drink = mysql_fetch_assoc($drink_result))
                        {
                            ?>
                            <tr class="search-result-list-row">
                                <td><?=$drink['Drink_Name']?></td>
                                <td><?=$drink['count']?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            <hr/>
            <div class="field-group-title">
                <h2>Tables</h2>
            </div>
            <?php
            $tableSQL = "select * from TableSet where Banquet_ID = '$banquetid'";
            if($table_result = mysql_query($tableSQL))
            {
                $tableNumber = mysql_num_rows($table_result);
                $tableCount = 1;
            }
            while($table = mysql_fetch_assoc($table_result))
            {
                
                $seat = "select * from Record where Record_Table='".$table['Table_ID']."'";
                $seat_result = mysql_query($seat);
                $amount = mysql_num_rows($seat_result);
                ?>
                <div class="field-group">
                    <div class="field-group-title">
                        Table<?=$tableCount++?>:
                    </div>
                    <div class="field">
                        Type: <?=$table['Table_Type']?>
                    </div>
                    <div class="field">
                        User: <?=$table['Table_User']?>
                    </div>    
                    <div class="field">
                        Capacity: <?=$table['Table_Cap']?>
                    </div>
                </div>
                <div class="search-result-list" style="margin: 10px 20% 0; text-align: center">
                    <table border="1">
                        <tr class="search-result-list-row-header">
                            <th>Seat No</th>
                            <th>Guest</th>
                            <th>Meal</th>
                            <th>Drink</th>
                            <?php 
                                $total = $table['Table_Cap'];
                                for($i = 1; $i <= $total; $i++){
                                    echo "<tr class='search-result-list-row'>";
                                    echo "<td>".$i."</td>";
                                    for($j=0, $hit=0; $j < $amount; $j++)
                                    {
                                        if(@mysql_result($seat_result, $j, 7) == $i)
                                        {
                                            $hit = 1;
                                            break;
                                        }
                                    }
                                    if($hit == 1)
                                    {//seat有人
                                        $temp="select Attendee_Name from Attendee where Attendee_ID='".mysql_result($seat_result, $j, 3)."'";
                                        $run=mysql_query($temp);
                                        $guest=mysql_result($run, 0, 0);
                                            echo "<td>".$guest."</td>";
                                        $temp="select Dish_Name from Dish where Dish_ID='".mysql_result($seat_result, $j, 5)."'";
                                        $run=mysql_query($temp);
                                        $dish=mysql_result($run, 0, 0);
                                            echo "<td>".$dish."</td>";
                                        $temp="select Drink_Name from Drink where Drink_ID='".mysql_result($seat_result, $j, 4)."'";
                                        $run=mysql_query($temp);
                                        $drink=mysql_result($run, 0, 0);
                                            echo "<td>".$drink."</td>";
                                    }
                                    else {
                                        echo "<td>"."</td>";
                                        echo "<td>"."</td>";
                                        echo "<td>"."</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </tr>
                    </table>
                </div>
                <?php
            }
            ?>
            <hr/>
            <div class="field-group-title">
                <h2>Attendee List</h2>
            </div>
            <div class="field">
                <p>Total attendee number: <?=mysql_num_rows($attendee_result)?></p>
            </div>
            <div class="search-result-list" style="margin: 10px 30% 0; text-align: center">
                <table border="1">
                    <tr class="search-result-list-row-header">
                        <th>Name</th>
                        <th>Table</th>
                        <th>Seat</th>
                    </tr>
                <?php
                    while($attendee = mysql_fetch_assoc($attendee_result))
                    {
                        echo "<tr class='search-result-list-row'>";
                        echo "<td>".$attendee['Attendee_Name']."</td>";
                        echo "<td>".$attendee['Record_Table']."</td>";
                        echo "<td>".$attendee['Record_Seatnum']."</td>";
                        echo "</tr>";
                    }
                ?>
                </table>
            </div>
            <hr/>
            <div style="text-align: right">
                <button class="sButton" onclick="window.print()">Print</button>
            </div>
        </div>
    </body>
</html>