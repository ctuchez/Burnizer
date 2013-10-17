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
            $image = $imageFile->toGDImage();
            ob_start ();
            imagepng($image);
            $pngImageSrc = 'data:image/png;base64,'.base64_encode(ob_get_contents());
            ob_end_clean ();
            
            $imageX = $imageFile -> x;
            $imageY = $imageFile -> y;
            
            
            echo "<canvas id=\"myCanvas\" width=\"$imageX\" height=\"$imageY\"></canvas>";
            echo "<script>
                  var canvas = document.getElementById('myCanvas');
                  var context = canvas.getContext('2d');
                  var imageObj = new Image();

                  imageObj.onload = function() {
                    context.drawImage(imageObj);
                  };
                  imageObj.src = '"."';
                  </script>";
    
            
            
            imagedestroy($image);
            echo "<img src='".$pngImageSrc."' />";
        }
        catch (Exception $e)
        {
            echo $e -> getMessage() + " conversion failed";
        }
    }
        

  

  ?>
  </body>
  </html>