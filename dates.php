<?php

    $arrLength = 0;

    if(isset($_POST["date1"]))
    {
        $conn = new mysqli("localhost", "root", "", "media_collection");
     $arrLength = $_POST["arraylength"];

    //build statement
    $stmnt = "INSERT INTO `media` (`Created`, `Filename`, `Owner`) VALUES ";

    for($i = 1; $i <= $arrLength; $i++)
    {
        $date = $_POST["date".$i];
        $filename = $_POST["filename".$i];

        if($date && $filename){
            $stmnt .= "('$date','$filename', 1)";

            if($i < $arrLength){ $stmnt .= ",";}
        }
        
    }
    //insert new media
    $conn->query($stmnt);
        
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style rel="stylesheet">
        .preview {
            width: 100px;
            height: auto;
            margin: 0px 1rem;
        }
    </style>
</head>
<body>
    <p style="border:1px solid black;"><?php if(isset($_POST["filename1"])){echo $stmnt; }?></p>
    <form action="dates.php" method="post">
    <?php 
        if($newMedia = array_diff(scandir("media/photos/"),array('..','.'))){
            foreach($newMedia as $file){
                $arrLength++;
        ?>
        <label for="filename<?php echo $arrLength;?>">Filename:</label><input type="text" name="filename<?php echo $arrLength;?>" value="<?php echo substr($file, -19); ?>" id="filename<?php echo $arrLength;?>">
        <img class="preview" src="<?php echo "media/photos/$file"; ?>" alt="none"/>
        <label for="date<?php echo $arrLength;?>">Date:</label><input type="date" name="date<?php echo $arrLength;?>" id="date<?php echo $arrLength;?>">
        <br>
    <?php }} ?>
    <input type="number" name="arraylength" value="<?php echo $arrLength; ?>" id="">
    <input type="submit" value="Insert Records">
    </form>
</body>
</html>