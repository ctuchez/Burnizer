
	
function BurnImage(image){
    this._context = image;
}

BurnImage.prototype.takeAverage = function(pointX,pointY){
		redToAverage = 0;
		greenToAverage = 0;
		blueToAverage = 0;
        low = -3;
        high = 3;
		for (x=low; x<=high; x++){
			for (y=low; y<=high; y++){
				rgb = this._context.getImageData(pointX + x, pointY + y);
				redToAverage =  rgb[0];
				greenToAverage = rgb[1];
				blueToAverage = rgb[2];
			}
		}
		
		acceptableRed =  redToAverage / Math.pow((high - low),2);
		acceptableGreen = greenToAverage / Math.pow((high - low),2);
		acceptableBlue = blueToAverage / Math.pow((high - low),2);
        
        returnVariable = new Array();
        returnVariable["r"] = acceptableRed;
        returnVariable["g"] = acceptableGreen;
        returnVariable["b"] = acceptableBlue;
        
		return returnVariable;
	}
    
BurnImage.prototype.isBurn = function(pointX,pointY){
		var rgbValues = this.takeAverage(pointX,pointY);
		if(this. firstDegree(rgbValues["r"],rgbValues["g"],rgbValues["b"]) == true){
			return "It is a first degree burn.";
		}
		else if(this.secondDegree(rgbValues["r"],rgbValues["g"],rgbValues["b"]) == true){
			return "It is a second degree burn.";
		}
		else if(this.thirdDegree(rgbValues["r"],rgbValues["g"],rgbValues["b"]) == true){
			return "It is a third degree burn.";
		}
		else{
			return "The system was not able to identify the burn";
		}
	}
	
	
	function firstDegree(acceptableRed,acceptableGreen,acceptableBlue){
		var firstDegRed = 205;
		var firstDegGreen = 132;
		var firstDegBlue = 117;
		if(acceptableRed <= firstDegRed + 30 && acceptableRed >= firstDegRed - 30){
			if(acceptableGreen <= firstDegGreen + 30 && acceptableGreen >= firstDegGreen - 30){
				if(acceptableBlue <= firstDegBlue + 30 && acceptableBlue >= firstDegBlue - 30){
					return true;
				}
			}
		}
		return false;
	}
	
	function secondDegree(acceptableRed,acceptableGreen,acceptableBlue){
		var secondDegRed = 187;
		var secondDegGreen = 42;
		var secondDegBlue = 39;
		if(acceptableRed <= secondDegRed + 30 && acceptableRed >= secondDegRed - 30){
			if(acceptableGreen <= secondDegGreen + 30 && acceptableGreen >= secondDegGreen - 30){
				if(acceptableBlue <= secondDegBlue + 30 && acceptableBlue >= secondDegBlue - 30){
					return true;
				}
			}
		}
		return false;
	}
	
	function thirdDegree(acceptableRed,acceptableGreen,acceptableBlue){
		var thirdDegRed = 90;
		var thirdDegGreen = 58;
		var thirdDegBlue = 58;
		if(acceptableRed <= thirdDegRed + 30 && acceptableRed >= thirdDegRed - 30){
			if(acceptableGreen <= thirdDegGreen + 30 && acceptableGreen >= thirdDegGreen - 30){
				if(acceptableBlue <= thirdDegBlue + 30 && acceptableBlue >= thirdDegBlue - 30){
					return true;
				}
			}
		}
		return false;
	}
	
	

