
	
function BurnImage(image){
    this._context = image;
}

BurnImage.prototype.takeAverage = function(pointX,pointY){
		redToAverage = 0;
		greenToAverage = 0;
		blueToAverage = 0;
        alphaToAverage= 0;
        low = -3;
        high = 3;
        z= 0;
		for (x=low; x<=high; x++){
			for (y=low; y<=high; y++){
				rgb = this._context.getImageData(pointX + x, pointY + y,1,1);
                redToAverage +=  rgb.data[0];
				greenToAverage += rgb.data[1];
				blueToAverage += rgb.data[2];
                alphaToAverage += rgb.data[3];

			}
		}
		
		acceptableRed =  redToAverage / Math.pow((high - low + 1),2) ;
		acceptableGreen = greenToAverage / Math.pow((high - low + 1),2);
		acceptableBlue = blueToAverage / Math.pow((high - low + 1),2);
        acceptableAlpha = alphaToAverage / Math.pow((high - low + 1),2);
        
        returnVariable = new Array();
        returnVariable["r"] = acceptableRed;
        returnVariable["g"] = acceptableGreen;
        returnVariable["b"] = acceptableBlue;
        returnVariable["a"] = acceptableAlpha;
        //alert(returnVariable["r"] + " " + returnVariable["g"] +" " + returnVariable["g"] + " "+ returnVariable["a"]);
        
		return returnVariable;
	}
    
BurnImage.prototype.isBurn = function(pointX,pointY){
		var rgbValues = this.takeAverage(pointX,pointY);
		if(firstDegree(rgbValues["r"],rgbValues["g"],rgbValues["b"]) == true){
			return "It is a first degree burn.";
		}
		else if(secondDegree(rgbValues["r"],rgbValues["g"],rgbValues["b"]) == true){
			return "It is a second degree burn.";
		}
		else if(thirdDegree(rgbValues["r"],rgbValues["g"],rgbValues["b"]) == true){
			return "It is a third degree burn.";
		}
		else{
			return "The system was not able to identify the burn";
		}
	}
	
	
	function firstDegree(acceptableRed,acceptableGreen,acceptableBlue){
		var firstDegRed = 190;
		var firstDegGreen = 80;
		var firstDegBlue = 70;
		if(acceptableRed <= firstDegRed + 30 && acceptableRed >= firstDegRed - 30){
			if(acceptableGreen <= firstDegGreen + 40 && acceptableGreen >= firstDegGreen - 40){
				if(acceptableBlue <= firstDegBlue + 40 && acceptableBlue >= firstDegBlue - 40){
					return true;
				}
			}
		}
		return false;
	}
	
	function secondDegree(acceptableRed,acceptableGreen,acceptableBlue){
		var secondDegRed = 140;
		var secondDegGreen = 50;
		var secondDegBlue = 45;
		if(acceptableRed <= secondDegRed + 40 && acceptableRed >= secondDegRed - 40){
			if(acceptableGreen <= secondDegGreen + 30 && acceptableGreen >= secondDegGreen - 30){
				if(acceptableBlue <= secondDegBlue + 30 && acceptableBlue >= secondDegBlue - 30){
					return true;
				}
			}
		}
		return false;
	}
	
	function thirdDegree(acceptableRed,acceptableGreen,acceptableBlue){
		var thirdDegRed = 110;
		var thirdDegGreen = 70;
		var thirdDegBlue = 68;
		if(acceptableRed <= thirdDegRed + 30 && acceptableRed >= thirdDegRed - 30){
			if(acceptableGreen <= thirdDegGreen + 30 && acceptableGreen >= thirdDegGreen - 30){
				if(acceptableBlue <= thirdDegBlue + 30 && acceptableBlue >= thirdDegBlue - 30){
					return true;
				}
			}
		}
		return false;
	}
	
	

