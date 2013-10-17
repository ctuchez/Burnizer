<html>
<head>
</head>
<body>
<?php
    require_once("classes/ImageFile.php");
    if ($_FILES["file"]["error"] > 0)
    {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br />";
        
        
        
      
        try
        {
            $imageFile = new ImageFile($_FILES["file"]);
            $image = $imageFile->toPHPImage();
            imagejpeg($image , 'simpletext.jpg');
            
            imagedestroy($image);
            echo "<img src='simpletext.jpg' />";
        }
        catch (Exception $e)
        {
            echo $e -> getMessage() + " conversion failed";
        }
    }
        

  

  ?>
  </body>
  </html>