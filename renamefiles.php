<?php
    if($newMedia = array_diff(scandir("media/"),array('..','.','icons')))
    {
        foreach($newMedia as $file){

            $newName = substr($file, -19);
            rename("media/".$file, "media/".$newName);       
        }
    }
?>