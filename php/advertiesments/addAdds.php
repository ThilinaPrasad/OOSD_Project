<?php

function uploadAdd($file,$hoverDescription,$description) {
    if($file['error']==UPLOAD_ERR_OK) {
        if(is_uploaded_file($file['tmp_name'])) {
            // prepare the image for insertion
            $imgData =addslashes (file_get_contents($file['tmp_name']));

            $sql = "INSERT INTO advertiesments (image, hoverDescription, description) VALUES ('{$imgData}','{$_POST[$hoverDescription]}','$_POST[$description]')";
            runQuery($sql);
        }
        else{
        }

    }

}
?>