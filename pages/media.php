<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_POST['albumName'] . ' - Media View'; ?></title>
</head>
<body>
    <?php 
        /*1. load settings and apply
        2. get post variables
        3. load media and rest of album in slider, wrapping around
        4. 'pop-up' for note and another for tags, validate each and IUD */
    ?>
    <div class="interface">
        <div class="menu"></div>
        <div class="view">
            <div class="single-slider">
                <div class="prev-arrow"><img src="" alt=""></div>
                <div class="grid-container">
                    <div class="grid-item"><img src="" alt=""></div>
                </div>
                <div class="next-arrow"><img src="" alt=""></div>
            </div>

            <div class="media-options"></div>
            
            <div class="double-slider">
                <div class="prev-arrow"><img src="" alt=""></div>
                    <div class="grid-container">
                        <div class="grid-item"><button onclick=""><img src="" alt=""></button></div>
                    </div>
                <div class="next-arrow"><img src="" alt=""></div>
            </div>            
        </div>
    </div>
</body>
</html>