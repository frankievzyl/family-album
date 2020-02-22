<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_POST['albumName'] . ' - Media View'; ?></title>
</head>
<body>
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