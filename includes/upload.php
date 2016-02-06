<?php
    if(isset($_POST["submit"])) {
        $target_dir = "uploads/";
        $imageFileName = basename($_FILES["imageUpload"]["name"]);
        $target_file = $target_dir . $imageFileName;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        
        $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<div class='alert alert-danger' role='alert'>File is not an image.</div>";
            $uploadOk = 0;
        }
        
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        
        if ($_FILES["imageUpload"]["size"] > 500000) {
            echo "<div class='alert alert-danger' role='alert'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "<div class='alert alert-danger' role='alert'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }
        
        if ($uploadOk != 0) {            
            if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
            	
            } else {
                echo "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your file.</div>";
            }
        }
    }
?>