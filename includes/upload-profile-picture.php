<?php

if (isset($_FILES["profile-pic"]) && $_FILES["profile-pic"]["error"] == 0) {
    $file = $_FILES["profile-pic"];
    $target_dir = "../profile-pictures/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  
    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if (!$check) {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "File already exists.";
      $uploadOk = 0;
    }
  
    // Check file size
    if ($file["size"] > 500000) {
      echo "File is too large.";
      $uploadOk = 0;
    }
  
    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "Only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
  
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "File was not uploaded.";
    // If everything is ok, try to upload file
    } else {
      if (move_uploaded_file($file["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars(basename($file["name"])) . " has been uploaded.";
        // Update the profile picture in the database
        // ...
        // Update the displayed profile picture
        echo "<script>document.getElementById('profile-pic').src = '$target_file';</script>";
      } else {
        echo "There was an error uploading the file.";
      }
    }
  }
  ?>