<?php
    session_start();
    $result = $_SESSION["connection"]->query("SELECT `PK`,`Name` FROM `user` WHERE NOT `PK` IN (1)");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select User</title>
</head>
<body>
    <form class="login-form" action="../index.php" method="post">
<?php while($row = $result->fetch_assoc()) { ?>
        <button class="login-button" type="submit" value="<?php echo $row["PK"]; ?>" name="userPK"><?php echo $row=["Name"]; ?></button>
<?php } ?>
    </form>
</body>
</html>