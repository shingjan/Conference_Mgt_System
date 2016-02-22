<?php
    $db=mysql_connect("mysql.comp.polyu.edu.hk","13104448d","suling1234");
    if(!$db)
        die('could not connect:'.mysql_error());
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
                    <input type="text" name="username"/>
                </div>
                <div class="loginField">
                    <label for="">Password: </label>
                    <input type="password" name="password"/>
                </div>
                <input class="sButton" type="submit" value="Login"/>
            </form>
        </div>
    </body>
</html>