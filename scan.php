 <!DOCTYPE html>
 <html>
 <head>
 	<title>Results</title>
 	<meta name ="viewport" content="width=device-width, initial-scale =1.0">
 	<link href="css/styles.css" rel = "stylesheet">
 	<link rel="stylesheet" type="text/css" href="css/bootstrap-fileupload.css">
 	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
 	<link href="css/bootstrap.min.css" rel = "stylesheet">
 	<link href="css/justified-nav.css" rel="stylesheet">
 </head>

 <body>
 	<div class="container">
 		<div class="masthead">
      			<img src="img/facebooklogo.jpg" height="40" align="right">
      			<img src="img/twitterlogo.jpg" height="40" align="right">
      			<img src="img/rsslogo.png" height="40" align="right">
      			<h1> Burnize </h1> 
      			<ul class="nav nav-justified">
       				<li class="active"><a href="index.html">Home</a></li>
       				<li><a href="scan.html">Scan</a></li>
       				<li><a href="about.html">About</a></li>
       				<li><a href="#">Contact</a></li>
     			</ul>
   		</div>
 	</div>

 	

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

        
        
        
      
        try
        {
            $imageFile = new ImageFile($_FILES["imageLoader"]);
            $image = $imageFile->toGDImage();

            
            $imageX = $imageFile -> x;
            $imageY = $imageFile -> y;
            
            
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
			
			ob_start();
            imagepng($image);
            // Capture the output
            $imagedata = ob_get_contents();
            // Clear the output buffer
            ob_end_clean();
			

    
            
            

        }
        catch (Exception $e)
        {
            echo $e -> getMessage() + " conversion failed";
        }
    }
        

  

  ?>
<div class="container">
 		<div class= "jumbotron">
 			<center><h1>Results</h1></center>
 			<table class="table" border = "0">
 				<tr>

 					<td> <img src="<?php echo 'data:image/png;base64,'.base64_encode($imagedata) ;?>" alt="burn image" align="center" style="max-width: 500px;"> </td>
 					<td> <p>Here are the areas of your burn according to the photo uploaded.</p>

 						<span class="label label-success">Area of 1st Degree Burn:</span> 
                        <br />
                        <?php echo round($firstDegreeAnswer,2);?> cm<sup>2</sup>
			
			
 						</br></br></br>
 						<span class="label label-warning">Area of 2nd Degree Burn:</span> 
                        <br />
                        <?php echo round($secondDegreeAnswer,2); ?> cm<sup>2</sup>
 						</br></br></br>
 						<span class="label label-danger">Area of 3rd Degree Burn:</span> 
                        <br />
                        <?php echo round($thirdDegreeAnswer,2);?> cm<sup>2</sup>
                        <br />
 					</td> 
 				</tr>
 			</table>
 		</div>
	</div>

 
 
 	<div class="modal fade" id="contact" role = "dialog">
 		<div class= "modal-dialog">
 		</div>
 	</div>

 	<div class="navbar navbar-default navbar-fixed-bottom">
 		<div class="container">
 			<p class="navbar-text pull-left">Site build by MHacks---Team-Dorito</p>
 			<a href ="#" class="navbar-button btn-info btn pull-right">Join us!</a>
 		</div>
 	</div>

 	<script src="js/jquery.js"></script>
  	<script src="js/bootstrap.js"></script>
 	<script src="js/bootstrap-fileupload.js"></script>
 </body>
 </html>