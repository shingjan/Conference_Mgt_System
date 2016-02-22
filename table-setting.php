<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheet.css" type="text/css" />
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1 style="margin-left: 30px;">Create new banquet</h1>
        </div>
        <div class="menu">
                <div class="menu-item" style="padding:0; margin:0; height: 40px;">
                </div>
                <div class="menu-item">
                    <a href="#">Create Banquet</a>
                </div>
                <div class="menu-item">
                    <a href="#">Search Banquet</a>
                </div>
            </div>
        <div class="contents">
            <div class="main">
                <form action="#" method="POST">
                    <div class="field-group">
                        <div class="field-group-title">
                            <h3>Banquet information:</h3>
                        </div>
                        <div class="field">
                            <label for="name">
                                <div>Banquet Name: </div>
                            </label>
                            <input type="text" name="name"/>
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
                            <input type="text" name="cFname"/>
                        </div>
                        <div class="field">
                            <label for="cLname">
                                <div>Last Name: </div>
                            </label>
                            <input type="text" name="cLname"/>
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
                              <input type="text" name="meal1"/>
                        </div>
                        <div class="field">
                              <label for="meal2">
                                  <div>Meal 2: </div>
                              </label>
                              <input type="text" name="meal2"/>
                        </div>
                        <div class="field">
                              <label for="meal3">
                                  <div>Meal 3: </div>
                              </label>
                              <input type="text" name="meal3"/>
                        </div>
                        <div class="field">
                              <label for="meal4">
                                  <div>Meal 4: </div>
                              </label>
                              <input type="text" name="meal4"/>
                        </div>
                    </div>
                    <input class="sButton" type="submit" value="Create"/>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>