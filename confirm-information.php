<?php
    session_start();
    if(!isset($_SESSION['user']))
        header("location: index.php");

    $db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
    mysql_select_db("13104448d");
    
    $person_query = "SELECT * from Attendee WHERE Attendee_ID = '". $_SESSION['uid']."'";
    $person = mysql_query($person_query, $db);

    echo mysql_error();
    $row = mysql_fetch_assoc($person);
  
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1 style="margin-left: 30px;">Confirm Personal Information</h1>
        </div>
        <div class="menu">
            <div class="menu-item" style="padding:0; margin:0; height: 40px;">
            </div>
        </div>
        <div class="contents">
            <div class="main">
                <form action="server/updateInfo.php" method="POST">
                    <input class="sButton" type="submit" value="Confirm"/>
                    <div class="field-group">
                        <div class="field-group-title">
                            <h3>Personal information:</h3>
                        </div>
                        <div class="field">
                            <label for="name">
                                <div>Name: </div>
                            </label>
                            <input type="text" name="name" value="<?=$row['Attendee_Name']?>" required/>
                        </div>
                        <div class="field">
                            <label for="address">
                                <div>Address: </div>
                            </label>
                            <input type="text" name="address" value="<?=$row['Attendee_Address']?>" required/>
                        </div>
                        <div class="field">
                            <label for="phonenum">
                                <div>Phone Number: </div>
                            </label>
                            <input type="text" name="phonenum" value="<?=$row['Attendee_PhoneNum']?>" required/>
                        </div>
                        <div class="field">
                            <label for="email">
                                <div>email: </div>
                            </label>
                            <input type="email" name="email" value="<?=$row['Attendee_Email']?>" required/>
                        </div>
                        <div class="field">
                            <label for="org">
                                <div>Affilicated Organization: </div>
                            </label>
                            <input type="text" name="org" value="<?=$row['Attendee_AffilicatedOrg']?>" required/>
                        </div>
                        <div class="field">
                            <label for="type">
                                <div>Type: </div>
                            </label>
                            <select name="type" size="1" required>
                                <option value="VIP" <?=($row['Attendee_Type']=="VIP")?('selected="selected"'):('')?>>VIP</option>
                                <option value="Sponsors" <?=($row['Attendee_Type']=="Sponsors")?('selected="selected"'):('')?>>Sponsors</option>
                                <option value="Others" <?=($row['Attendee_Type']=="Others")?('selected="selected"'):('')?>>Others</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>

<?php
 
?>