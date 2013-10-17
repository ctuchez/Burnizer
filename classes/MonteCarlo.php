<?php
class MonteCarlo{


	 private $totalBurn;		 //int
	 private $firstDegBurnArea;	 //int
	 private $secondDegBurnArea; //int
	 private $thirdDegBurnArea;	 //int
	 private $imagefile;		 //image	
	 private $pointOfNormalSkin;	//point
	 private $pointOfFirstDegBurn;  //point
	 private $pointOfSecondDegBurn;  //point
	 private $pointOfThirdDegBurn;  //point
	 private $leftMostXCoord = 10000000000000;       //leftmost burn pixel
	 private $rightMostXCoord = 0;		   //rightmost burn pixel
	 private $topMostYCoord = 100000000000000;    //topmost burn pixel
	 private $bottomMostYCoord = 0;       //bottommost burn pixel
	 private $firstDegList = 0;   //list of points(x,y) that fit within first deg burn category
	 private $secondDegList = 0;  //list of points that fit within second deg burn category
	 private $thirdDegList = 0;   //list of points that fit within third deg burn category
	 private $imageXCoord; //int, x size of image passed in
	 private $imageYCoord; //int, y size of image passed in
	 private $calibrationStick;
	 private $magnitude; //cal stick magnitude
	 private $squareArea;
	 private $numOfPixelsInSquare;
	 private $whichOnes;
	

	 
	public function setImageToUse($anImage) {
		$this->imagefile = $anImage;
		$this->imageXCoord = imagesx($anImage);
		$this->imageYCoord = imagesy($anImage);
   }
   
	public function setWhichOnes($booleanArray){
		$this->whichOnes = $booleanArray;
	}
	
	public function setCalibration($point1, $point2, $magnitude){
		$x = $point1->getX() - $point2->getX();
		$y = $point1->getY() - $point2->getY();
		$this->calibrationStick = sqrt($x*$x + $y*$y);
		$this->magnitude = $magnitude;
	}
	
	 
	public function setNormalSkinPoint($pointOfNormalSkin){
	 	$this->pointOfNormalSkin = $pointOfNormalSkin;
		
	}
	
	public function setFirstDegPoint($pointOfFirstDegBurn){
	 	$this->pointOfFirstDegBurn = $pointOfFirstDegBurn;	
	}
	
	public function setSecondDegPoint($pointOfSecondDegBurn){
		$this->pointOfSecondDegBurn = $pointOfSecondDegBurn;			
	}
	
	public function setThirdDegPoint($pointOfThirdDegBurn){
	 	$this->pointOfThirdDegBurn = $pointOfThirdDegBurn;
	}



   public function getTotalBurnArea() {
	 	$fromFirst = $this->getFirstDegreeArea(); 
		$fromSecond = $this->getSecondDegreeArea();
		$fromThird = $this->getThirdDegreeArea();
		if (is_numeric($fromFirst)) {
			$this->totalBurn = $this->totalBurn + $fromFirst;
		}
		if (is_numeric($fromSecond)) {
			$this->totalBurn = $this->totalBurn + $fromSecond;
		}
		if (is_numeric($fromThird)) {
			$this->totalBurn = $this->totalBurn + $fromThird;
		}
    	return $this->totalBurn;
   }
	 
	 
	public function getFirstDegreeArea() {
		$this->getSquare();
		$this->firstDegBurnArea = ($this->firstDegList*$this->squareArea)/$this->numOfPixelsInSquare;
		if($this->whichOnes[0] == false){
			return 'No first degree burns were selected';
		}
		return $this->firstDegBurnArea;
   }
	 
	public function getSecondDegreeArea() {
		$this->secondDegBurnArea = ($this->secondDegList*$this->squareArea)/$this->numOfPixelsInSquare;
		if($this->whichOnes[1] == false){
			return 'No second degree burns were selected';
		}
   	return $this->secondDegBurnArea;
   }

	public function getThirdDegreeArea() {
		$this->thirdDegBurnArea =($this->thirdDegList*$this->squareArea)/$this->numOfPixelsInSquare;
		if($this->whichOnes[2] == false){
			return 'No third degree burns were selected';
		}
		return $this->thirdDegBurnArea;
   }
	
	 
	
	private function getSquare(){
		$this->seeWhereDiffBurnsAre();
		$width = $this->rightMostXCoord - $this->leftMostXCoord;
		$length = $this->bottomMostYCoord - $this->topMostYCoord;
		$magOfWidth = $this->magnitude*$width/$this->calibrationStick;
		$magOfLength = $this->magnitude*$length/$this->calibrationStick;
		$this->squareArea = $magOfLength * $magOfWidth;
		$this->numOfPixelsInSquare = $width*$length;
	}


		
	
	private function seeWhereDiffBurnsAre(){
		$firstX = $this->pointOfFirstDegBurn->getX();
		$firstY = $this->pointOfFirstDegBurn->getY();		
		$pixelOfFirstDeg = imagecolorat($this->imagefile , $firstX, $firstY);
		$firstDegRed = ($pixelOfFirstDeg >> 16) & 0xFF;
		$firstDegGreen= ($pixelOfFirstDeg >> 8) & 0xFF;
		$firstDegBlue = $pixelOfFirstDeg & 0xFF;
		
		
		$secondX = $this->pointOfSecondDegBurn->getX();
		$secondY = $this->pointOfSecondDegBurn->getY();		
		$pixelOfSecondDeg = imagecolorat($this->imagefile , $secondX, $secondY);
		$secondDegRed = ($pixelOfSecondDeg >> 16) & 0xFF;
		$secondDegGreen= ($pixelOfSecondDeg >> 8) & 0xFF;
		$secondDegBlue = $pixelOfSecondDeg & 0xFF;
		

		$thirdX = $this->pointOfThirdDegBurn->getX();
		$thirdY = $this->pointOfThirdDegBurn->getY();		
		$pixelOfThirdDeg = imagecolorat($this->imagefile , $thirdX, $thirdY);
		$thirdDegRed = ($pixelOfThirdDeg >> 16) & 0xFF;
		$thirdDegGreen= ($pixelOfThirdDeg >> 8) & 0xFF;
		$thirdDegBlue = $pixelOfThirdDeg & 0xFF;
		
		for ($x=0; $x<=$this->imageXCoord -1; $x++){
			for ($y=0; $y<=$this->imageYCoord - 1; $y++){
				$aPixel = imagecolorat($this->imagefile , $x, $y);
				$red = ($aPixel >> 16) & 0xFF;
				$green = ($aPixel >> 8) & 0xFF;
				$blue =  $aPixel & 0xFF;
 				if($red <= $firstDegRed + 20 && $red >= $firstDegRed - 20){
					if($green <= $firstDegGreen + 20 && $green >= $firstDegGreen - 20){
						if($blue <= $firstDegBlue + 20 && $blue >= $firstDegBlue - 20){
							$this->firstDegList = $this->firstDegList + 1;
							if($x < $this->leftMostXCoord){
								$this->leftMostXCoord = $x;
							}
							if($x > $this->rightMostXCoord){
								$this->rightMostXCoord = $x;
							}
							if($y < $this->topMostYCoord){
								$this->topMostYCoord = $y;
							}
							if($y > $this->bottomMostYCoord){
								$this->bottomMostYCoord = $y;
							}
						}		
					}
				}
				if($red <= $secondDegRed + 20 && $red >= $secondDegRed - 20){
					if($green <= $secondDegGreen + 20 && $green >= $secondDegGreen - 20){
						if($blue <= $secondDegBlue + 20 && $blue >= $secondDegBlue - 20){
							$this->secondDegList = $this->secondDegList + 1;
							if($x < $this->leftMostXCoord){
								$this->leftMostXCoord = $x;
							}
							if($x > $this->rightMostXCoord){
								$this->rightMostXCoord = $x;
							}
							if($y < $this->topMostYCoord){
								$this->topMostYCoord = $y;
							}
							if($y > $this->bottomMostYCoord){
								$this->bottomMostYCoord = $y;
							}
						}
					}
				}
				if($red <= $thirdDegRed + 20 && $red >= $thirdDegRed - 20){
					if($green <= $thirdDegGreen + 20 && $green >= $thirdDegGreen - 20){
						if($blue <= $thirdDegBlue + 20 && $blue >= $thirdDegBlue - 20){
							$this->thirdDegList = $this->thirdDegList + 1;
							if($x < $this->leftMostXCoord){
								$this->leftMostXCoord = $x;
							}
							if($x > $this->rightMostXCoord){
								$this->rightMostXCoord = $x;
							}
							if($y < $this->topMostYCoord){
								$this->topMostYCoord = $y;
							}
							if($y > $this->bottomMostYCoord){
								$this->bottomMostYCoord = $y;
							}
						}
					}
				}				
			} 
  		} 
	}
	
	
	
	
	
	 
}
?>