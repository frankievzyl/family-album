<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php 
        if($newMedia = array_diff(scandir("D:/photos/"),array('..','.'))){
            foreach($newMedia as $file){
                echo "$file<br>";
            }
        }
    ?>    
</body>
</html>

