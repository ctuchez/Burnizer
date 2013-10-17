<?php
   $success = false;
   $error = false;
   // Check if uploaded file and not a system file or other file
   if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name']) && $_FILES['image']['error'] == 0) {
      if(!is_dir('uploads')) {
         mkdir('uploads');
      }
      // Sets the filename to a unique ID
      $filename = 'uploads/'.uniqid().'.jpg';
      // Check the image type and create image from GD using that type
      switch(exif_imagetype($_FILES['image']['tmp_name'])) {
         case 1:
            $img = imagecreatefromgif($_FILES['image']['tmp_name']);
            break;
         case 2:
            $img = imagecreatefromjpeg($_FILES['image']['tmp_name']);
            break;
         case 3:
            $img = imagecreatefrompng($_FILES['image']['tmp_name']);
            break;
         default:
            $error = true;
            break;
      }
      if($error == false) {
         // Convert image to jpeg and save to new location
         $success = imagejpeg($img, $filename, 100);
         imagedestroy($img);
         if($success) {
            // Successful Image name is $filename
         }
      }
   }
   if($success == false) {
      // Not Successful - should return error
      header("HTTP/1.1 500 Internal Server Error");
   }
?>