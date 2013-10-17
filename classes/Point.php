<?php
class Point{

	private $xCoord;
	private $yCoord;
	
	function __construct($x,$y){
    $this -> xCoord = round($x);
    $this -> yCoord = round($y);
	
	}
	
	public function setX($xCoord) {
   	$this->xCoord = $xCoord;
   }
	
	public function setY($yCoord) {
   	$this->yCoord = $yCoord;
   }
	
	public function getX(){
		$toReturn = 0;
		if (isset($this->xCoord)) {
			return $this->xCoord;
		}
		return $toReturn;
	}
	
	public function getY(){
		$toReturn = 0;
		if (isset($this->yCoord)) {
			return $this->yCoord;
		}
		return $toReturn;
	}
}
?>
