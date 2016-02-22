<?php
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    $banquet_query = "Select * from Banquet";
    $banquets = mysql_query($banquet_query, $db);
    
    $sortType = $_GET['sortType'];
    $sortAD = $_GET['sortAD'];
    
    if(isset($_GET['bid']))
    {
        $attendee_query = "Select * from Record, Attendee, Dish, Drink, TableSet 
            WHERE Record.Attendee_ID = Attendee.Attendee_ID 
            AND Record.Record_Table = TableSet.Table_ID 
            AND Record.Dish_ID = Dish.Dish_ID 
            AND Record.Drink_ID = Drink.Drink_ID 
            AND Record.Banquet_ID = '".$_GET['bid']."' ";
        $display = true;
    }
    else if(isset($_GET['keywordType']))
    {
        $attendee_query = "Select * from Record, Attendee, Dish, Drink, TableSet 
        WHERE Record.Attendee_ID = Attendee.Attendee_ID 
        AND Record.Record_Table = TableSet.Table_ID 
        AND Record.Dish_ID = Dish.Dish_ID 
        AND Record.Drink_ID = Drink.Drink_ID 
        AND Record.Banquet_ID = '".$_GET['bid2']."' 
        AND ".$_GET['keywordType']."= '" . $_GET['keyword']."' ";
        
        $display = true;
    }
    else
        $display = false;
        
    if($display)
    {
        if(isset($_GET['sortType']))
            $attendee_query .= "Order By " .$sortType." ".$sortAD;
        $attendee = mysql_query($attendee_query, $db);
        // echo mysql_error();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
        <script type="text/javascript">
            function withBanquet()
            {
                document.getElementById("bid2").value = document.getElementById("bid").value;
                return true;
            }
            
            function sortBy(type, ad)
            {
                if(window.location.href.indexOf('&sortType=') != -1)
                {
                    var link = window.location.href;
                    var pos = link.indexOf("&sortType");
                    window.location.href = link.substr(0, pos)+"&sortType="+type+"&sortAD="+ad;
                }
                else
                    window.location.href = window.location.href+"&sortType="+type+"&sortAD="+ad;
            }
        </script>
        <script type="text/javascript">
            function payment(e){
                var paid=document.getElementById("payment"+e).value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function()
                {
                    if(xhr.readyState == 4 && xhr.status == 200)
                        alert(xhr.responseText);
                }
                xhr.open("POST", "server/paymentUpdate.php", true);
                xhr.send("recordid="+e+"&payment="+paid);
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">
                    <h1 style="margin-left: 30px;">Search attendee</h1>
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
                            <select name="bid" id="bid" size="1">
                                <?php
                                while($row = mysql_fetch_assoc($banquets))
                                {
                                    ?>
                                    <option <?=($row['Banquet_ID']==($_GET['bid'].$_GET['bid2']))?('selected="selected"'):('')?> value="<?=$row['Banquet_ID']?>">
                                    <?=$row['Banquet_Name']?><br/>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button class="sButton">Show</button>
                        </form>
                    </div>
                </div>
                <div class="search-option">
                    <div class="field-group">
                        <form>
                            <label style="width: 130px;" for="name">
                                <select stylie="width: 200px;" name="keywordType" size="1">
                                    <option value="Attendee_Name" <?=("Attendee_Name"==$_GET['keywordType'])?('selected="selected"'):('')?>>Name</option>
                                    <option value="Table_Number" <?=("Table_Number"==$_GET['keywordType'])?('selected="selected"'):('')?>>Table</option>
                                    <option value="Attendee_Type" <?=("Attendee_Type"==$_GET['keywordType'])?('selected="selected"'):('')?>>Type</option>
                                    <option value="Attendee_AffilicatedOrg" <?=("Attendee_AffilicatedOrg"==$_GET['keywordType'])?('selected="selected"'):('')?>>Company</option>
                                    <option value="Dish.Dish_Name" <?=("Dish_Name"==$_GET['keywordType'])?('selected="selected"'):('')?>>Meal</option>
                                    <option value="Drink.Drink_Name" <?=("Drink_Name"==$_GET['keywordType'])?('selected="selected"'):('')?>>Drink</option>
                                </select>
                            </label><input type="text" name="keyword" value="<?=$_GET['keyword']?>"/>
                            <input hidden="hidden" id="bid2" name="bid2"/>
                            <button class="sButton" onclick="withBanquet()">Search</button>
                        </form>
                    </div>
                </div>
                <hr/>
                <div class="search-result">
                    <div class="search-result-list">
                        <table>
                            <tr class="search-result-list-row-header">
                                <th onclick="sortBy('Attendee_Name', '<?=("Attendee_Name"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Attendee_Name"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Name</th>
                                <th onclick="sortBy('Table_Number', '<?=("Table_Number"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Table_Number"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Table</th>
                                <th onclick="sortBy('Record_Seatnum', '<?=("Record_Seatnum"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Record_Seatnum"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Seat</th>
                                <th onclick="sortBy('Attendee_Type', '<?=("Attendee_Type"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Attendee_Type"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Type</th>
                                <th onclick="sortBy('Attendee_AffilicatedOrg', '<?=("Attendee_AffilicatedOrg"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Attendee_AffilicatedOrg"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Company</th>
                                <th onclick="sortBy('Dish.Dish_ID', '<?=("Dish.Dish_ID"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Dish.Dish_ID"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Meal</th>
                                <th onclick="sortBy('Drink.Drink_ID', '<?=("Drink.Drink_ID"==$_GET['sortType'])?('DESC'):('ASC')?>')" <?=("Drink.Drink_ID"==$_GET['sortType'])?('class="'.(("DESC"==$_GET['sortAD'])?('DESC'):('ASC')).'"'):('')?>>Drink</th>
                                <th>remark</th>
                                <th>Payment</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            <?php
                                if($attendee && (mysql_num_rows($attendee) > 0))
                                while($row = mysql_fetch_assoc($attendee))
                                {
                                    ?>
                                    <tr class="search-result-list-row">
                                        <td><?=$row['Attendee_Name']?></td>
                                        <td><?=$row['Table_Number']?></td>
                                        <td><?=$row['Record_Seatnum']?></td>
                                        <td><?=$row['Attendee_Type']?></td>
                                        <td><?=$row['Attendee_AffilicatedOrg']?></td>
                                        <td><?=$row['Dish_Name']?></td>
                                        <td><?=$row['Drink_Name']?></td>
                                        <td><?=$row['Record_Remarks'].$row['Record_VIPRemark']?></td>
                                        <td><select id="payment<?=$row['Record_ID'] ?>" name = "payment" size="1">
                                            <option value='Unpaid' <?=("Unpaid"==$row['Record_Payment'])?('selected="selected"'):('')?>>Unpaid</option>
                                            <option value='Cash' <?=("Cash"==$row['Record_Payment'])?('selected="selected"'):('')?>>Paid by Cash</option>
                                            <option value='CreditCard' <?=("CreditCard"==$row['Record_Payment'])?('selected="selected"'):('')?>>Paid by CreditCard</option>
                                            <option value='EPS'<?=("EPS"==$row['Record_Payment'])?('selected="selected"'):('')?>>Paid by EPS</option>
                                            <option value='Cheque'<?=("Cheque"==$row['Record_Payment'])?('selected="selected"'):('')?>>Paid by Cheque</option>
                                        </select><button class="sButton" onclick = "payment(<?=$row['Record_ID'] ?>);">Save</button></td>
                                        <td><button class="sButton" onclick = "window.location.href='edit-attendee.php?attendeeid=<?=$row['Attendee_ID'] ?>'">Edit</button></td>
                                        <td><button class="sButton" onclick = "window.location.href='server/deleteAttendee.php?aid=<?=$row['Attendee_ID'] ?>&bid=<?=$row['Banquet_ID']?>'">Delete</button></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>