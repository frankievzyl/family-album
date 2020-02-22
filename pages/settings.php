<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
</head>
<body>
<?php
/**1. load user settings and display
 * 2. validate changes and apply or cancel
 */
    if(isset($_POST['submit']))
    {

    }
    
    //if valid; return to previous page; else show errors
?>
    <form action="settings.php" method="post">
        <div class="theme">
            <div class="theme-settings">
                <input type="file" name="" id="">
            </div>
        </div>
        <input type="number" name="stripSize" id="stripSize">
        <input type="number" name="gridSize" id="gridSize">
        <input type="checkbox" name="reverseNote" id="reverseNote">
        <input type="checkbox" name="autoLoad" id="autoLoad"><input type="checkbox" name="bookmarksStart" id="bookmarkStart">
    </form>
</body>
</html>