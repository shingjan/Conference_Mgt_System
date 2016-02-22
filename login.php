<?php
    $db=mysql_connect("mysql.comp.polyu.edu.hk","13104448d","suling1234");
    if(!$db)
        die('could not connect:'.mysql_error());
        
    if(isset($_SESSION['admin']))
        header("location:admin-home.php");
    else if (isset($_SESSION['user']))
        header("location:confirm-information.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
    </head>
    <body style="background-color: #EFEFEF;">
        <div class="loginForm">
            <form action="server/login.php" method="POST">
                <div class="loginField">
                    <label for="">Username: </label>
                    <input type="text" name="account" required/>
                </div>
                <div class="loginField">
                    <label for="">Password: </label>
                    <input type="password" name="pwd" required/>
                </div>
                <input class="sButton" type="submit" value="Login"/>
            </form>
        </div>
    </body>
</html>