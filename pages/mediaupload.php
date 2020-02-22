<?php
    if ($uploadedFiles = $_FILES["mediaFiles"])
    {
        $target_dir = "../media/";
        $uploadOk = 1;
        $stmnt = "INSERT INTO `media` (`Created`, `Filename`, `Owner`, 'Player') VALUES (";

        foreach ($uploadedFiles as $file) {
            $target_file = $target_dir . basename($file["name"]);

            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($file["tmp_name"]);

            $uploadOk = $check !== false ? 1 : 0;
            
            if(file_exists($target_file))
            {
                echo basename($file["name"]) . "- file already exists.";
                $uploadOk = 0;
                //do overwrite question
            }

            if($uploadOk)
            {
                if(move_uploaded_file($file["tmp_name"], $target_file))
                {
                    echo "upload success";
                    if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif")
                    {
                        $stmnt .= "('" . date('Y m d H:i:s',filectime("../media/". $file["name"])) . "','" . $file["name"] . "', " . $_SESSION["userData"]["PK"] . "', 1)";
                    }
                    else
                    {
                        $stmnt .= "('" . date('Y m d H:i:s',filectime("../media/". $file["name"])) . "','" . $file["name"] . "', " . $_SESSION["userData"]["PK"] . "', 0)";
                    }       
                }
            }
        }

        $stmnt .= ")";
        //insert new media
        $_SESSION["connection"]->query($stmnt);
        header("Location: http://localhost/familyalbum/pages/albums.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Media</title>
    <script>
        let dropArea = document.getElementById("drop-area");
        let filesDone = 0;
        let filesToDo = 0;
        let progressBar = document.getElementById("progress-bar");

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropArea.classList.add('highlight');
        }

        function unhighlight(e) {
            dropArea.classList.remove('highlight');
        }

        dropArea.addEventListener('drop'), handleDrop, false);

        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;

            handleFiles(files);
        }

        function handleFiles(files) {
            files = [...files];
            initializeProgress(files.length);
            files.forEach(uploadFile);
            files.forEach(previewFile);
        }

        function uploadFile(file) {
            let url = 'mediaupload.php';
            let formData = new FormData();

            forData.append('file', file);

            fetch(url, {method: 'POST', body: formData})
            .then(progressDone)
            .catch(() => {alert("upload failed :(")});
        }

        function previewFile(file) {
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function() {
                let img = document.createElement('img');
                img.src = reader.result;
                document.getElementById('gallery').appendChild(img);
            }
        }

        function initializeProgress(numfiles) {
            progressBar.value = 0;
            filesDone = 0;
            filesToDo = numfiles;
        }

        function progressDone() {
            filesDone++;
            progressBar.value = filesDone / filesToDo * 100;
        }
    </script>
    <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            width: 480px;
            font-family: sans-serif;
            margin: 100px auto;
            padding: 20px;
        }

        #drop-area.highlight {
            border-color: purple;
        }

        p {
            margin-top: 0;
        }

        #media-upload {
            margin-bottom: 10px;
        }

        #gallery {
            margin-top: 10px;
        }

        #gallery img {
            width: 150px;
            margin-bottom: 10px;
            margin-right: 10px;
            vertical-align: middle;
        }

        #media-files {
            display: none;
        }
    </style>
</head>
<body>
<div class="interface">
        <div class="menu"></div>
        <div class="view">
            <div id="drop-area">
                <form action="mediaupload.php" method="post" id="media-upload" enctype="multipart/form-data">
                <p>Drag'n'Drop your photos and videos here:</p>
                    <input type="file" name="mediaFiles" id="media-files" multiple accept="image/*, video/*" onchange="handleFiles(this.files)">
                </form>
                <progress id="progress-bar" max=100 value=0></progress>
                <div id="gallery"></div>
            </div>
        </div>
    </div>
</body>
</html>