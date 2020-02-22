<?php 
    session_start();

    $result = $_SESSION["connection"]->query("SELECT * FROM `media` WHERE `PK` IN (SELECT `Media_pk` FROM `media_album` WHERE `Album_pk` = " . $_GET["albumPK"] . ")");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo '<style src="../themes/'.$_SESSION["userData"]["Theme"].'.css"></style>'; ?>
    <title><?php echo $_GET['albumName']; ?></title>
</head>
<body>
    <?php 
        /*1. get and apply settings
        2. load all media in album and display
        3. go to media */
    ?>
    <div class="interface">
        <div class="menu"></div>
        <div class="view">
            <div class="grid-container media">
<?php 
    while($row = $result->fetch_assoc()) { 
        if($row["Player"]){
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/media.php?albumPK='.$_GET["albumPK"].'&mediaPK='.$row["PK"].'&Player=true"><img src="../media/icons/mediaplayer.png" alt="Media Player Icon"></a></div>';
        }
        else{
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/media.php?albumPK='.$_GET["albumPK"].'&mediaPK='.$row["PK"].'&Player=false"><img src="../media/icons/'.$row["Filename"].'" alt="'.$row["Filename"].' Icon"></a></div>';
        }
    } 
?>
            </div>
        </div>
    </div>
</body>
</html>