<?php 
    session_start();
    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");

    $banquetID = $_GET['bid'];
    $tableID = $_GET['tid'];
    $aid = $_GET['aid'];
    
    $table_query = "SELECT * FROM TableSet WHERE Table_ID='".$tableID."'";
    $table_result = mysql_query($table_query, $db);
    $table = mysql_fetch_array($table_result);
    $tablecap = $table['Table_Cap'];
    
    $seat_query = "SELECT * FROM Record WHERE Record_Table='".$tableID."' AND Banquet_ID = '".$banquetID."' ORDER BY Record_Seatnum ASC";
    $seat_result = mysql_query($seat_query, $db);
    
    $seats = array();
    for($i = 1; $i <= $tablecap; $i++)
    {
        array_push($seats, "Seat ".$i);
    }
    while($seat = mysql_fetch_array($seat_result))
    {
        if($seat['Attendee_ID'] == $aid)
            $seats[$seat['Record_Seatnum']-1] = "Selecting " . $seat['Record_Seatnum'];
        else
            $seats[$seat['Record_Seatnum']-1] = "Occupied.";
    }
    
    for($i = 1; $i <= $tablecap; $i++)
    {
        ?>
            <option <?=(($seats[$i-1]=="Occupied.") ? ' disabled="disabled" ' : '')?> <?=(($seats[$i-1]=="Selecting ".$i) ? ' selected="selected" ' : '')?> value="<?=$i?>"><?=$seats[$i-1]?></option>
        <?php
    }
?>