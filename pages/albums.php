<?php 
    session_start();

    $result = $_SESSION["connection"]->query("SELECT * FROM `album` WHERE `PK` = 1 OR `Owner` = " . $_SESSION["userData"]["PK"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo '<style src="../themes/'.$_SESSION["userData"]["Theme"].'.css"></style>'; ?>
    <title>My Albums</title>
</head>
<body>
    <div class="interface">
        <div class="menu"></div>
        <div class="view">
            <div class="grid-container albums">
<?php 
    while($row = $result->fetch_assoc()) { 
        if($row["Icon"]){
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/mediagrid.php?albumPK='.$row["PK"].'&albumName='.$row["Name"].'"><img src="../media/icons/'.$row["Icon"].'" alt="'.$row["Name"].' Icon"></a></div>';
        }
        else{
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/mediagrid.php?albumPK='.$row["PK"].'&albumName='.$row["Name"].'"></a></div>';
        }
    } 
?>
            </div>
        </div>
    </div>
</body>
</html>