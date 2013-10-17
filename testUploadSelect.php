<html>
<head>
</head>
<body>
<?php
    require_once("classes/ImageFile.php");
	require_once("classes/Point.php");
	require_once("classes/MonteCarlo.php");
    
    $skinX[0]=$_POST["skinX0"];
    $skinY[0]=$_POST["skinY0"];
    for($i=1;$i<=3;$i++)
    {
        if(isset($_POST["skinX".$i]))
        {
            $skinX[$i]=$_POST["skinX".$i];
            $skinY[$i]=$_POST["skinY".$i];
            $isEnabled[$i - 1 ] = true;
        }
        else
        {
            $isEnabled[$i] = false;
        }
        
    }
    for($i=0;$i<=1;$i++)
    {
        $calX[$i]=$_POST["calX".$i];
        $calY[$i]=$_POST["calY".$i];
    }
    $calibrationLength=$_POST["length"];
    
    
    if ($_FILES["imageLoader"]["error"] > 0)
    {
        echo "Error: " . $_FILES["imageLoader"]["error"] . "<br>";
    }
    else
    {
        echo "Upload: " . $_FILES["imageLoader"]["name"] . "<br>";
        echo "Type: " . $_FILES["imageLoader"]["type"] . "<br>";
        echo "Size: " . ($_FILES["imageLoader"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["imageLoader"]["tmp_name"] . "<br />";
        
        
        
      
        try
        {
            $imageFile = new ImageFile($_FILES["imageLoader"]);
            $image = $imageFile->toGDImage();

			echo $image;
            
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
			$normalSkin = new Point($skinX[0], $skinY[0]);
			$firstDegBurn = new Point($skinX[1], $skinY[1]);
			$secondDegBurn = new Point($skinX[2], $skinY[2]);
			$thirdDegBurn = new Point($skinX[3], $skinY[3]);
			$calibration1 = new Point($calX[0], $calY[0]);
			$calibration2 = new Point($calX[1], $calY[1]);


			$monteCarlo = new MonteCarlo();
    
			$monteCarlo->setImageToUse($image);
            $monteCarlo->setWhichOnes($isEnabled);
			$monteCarlo->setCalibration($calibration1, $calibration2, $calibrationLength);
			$monteCarlo->setNormalSkinPoint($normalSkin);
			$monteCarlo->setFirstDegPoint($firstDegBurn);
			$monteCarlo->setSecondDegPoint($secondDegBurn);
			$monteCarlo->setThirdDegPoint($thirdDegBurn);
			$firstDegreeAnswer = $monteCarlo->getFirstDegreeArea();
			$secondDegreeAnswer = $monteCarlo->getSecondDegreeArea();
			$thirdDegreeAnswer = $monteCarlo->getThirdDegreeArea();
			$totalDegreeAnswer = $monteCarlo->getTotalBurnArea();
			
			
			echo $firstDegreeAnswer."<br />";
			echo $secondDegreeAnswer."<br />";
			echo $thirdDegreeAnswer."<br />";

    
            
            

        }
        catch (Exception $e)
        {
            echo $e -> getMessage() + " conversion failed";
        }
    }
        

  

  ?>
  </body>
  </html>