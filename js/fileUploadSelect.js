$(function() {
	String.prototype.contains = function(it) { return this.indexOf(it) != -1; };

	
});
var headerHeight = 0;
var imageScaleWidth = 500;
var imageScale;
var img = new Image();
var imageLoader = document.getElementById('imageLoader');
    imageLoader.addEventListener('change', handleImage, false);
var canvas = document.getElementById('imageCanvas');
var ctx = canvas.getContext('2d');
var setting = 0;
var skinX = new Array();
var skinY = new Array();
var calX = new Array();
var calY = new Array();
var isEnabled = new Array();

var isDrawing = false;
init();


$('#check1').click(function(){
    isEnabled[1] = !isEnabled[1];
    $('#check1').prop('checked', !isEnabled[1]);
    $('#skinX1').prop('disabled', !isEnabled[1]);
    $('#skinY1').prop('disabled', !isEnabled[1]);
});
$('#check2').click(function(){
    isEnabled[2] = !isEnabled[2];
    $('#check2').prop('checked', !isEnabled[2]);
    $('#skinX2').prop('disabled', !isEnabled[2]);
    $('#skinY2').prop('disabled', !isEnabled[2]);
});
$('#check3').click(function(){
    isEnabled[3] = !isEnabled[3];
    $('#check3').prop('checked', !isEnabled[3]);
    $('#skinX3').prop('disabled', !isEnabled[3]);
    $('#skinY3').prop('disabled', !isEnabled[3]);
});

function draw(event) {
    if(isDrawing) {
        //clearCanvas();
       // ctx.drawImage(img,0,0,imageScaleWidth,imageScaleWidth * img.height / img.width);
        
        //ctx.strokeRect(startx,starty,getX(event)-startx,getY(event)-starty);
        //ctx.stroke();
        
    }
    event.preventDefault();
}
 function clearCanvas() {
		ctx.clearRect(0,0,canvas.width,canvas.height);
	}
function start(event) {
    
   // startx = getX(event);
   // starty = getY(event);
   
   switch (setting)
    {
        case 0:
        ctx.strokeStyle = "black";
        break;
        case 1:
        ctx.strokeStyle = "purple";
        case 2:
        ctx.strokeStyle = "red";
        break;
        case 3:
        ctx.strokeStyle = "blue";
        break;
        case 4:
        ctx.strokeStyle = "green";
        break;
        case 5:
        ctx.strokeStyle = "orange";
        break;
        default:
        break;
    }
    if (setting==0)
    {  
        
        calX[setting] = getX(event);
        calY[setting] = getY(event);
        $("#calX" + setting).val(calX[setting] / imageScale );
        $("#calY" + setting).val(calY[setting] / imageScale );
       
        ctx.beginPath();
        ctx.arc(calX[setting],calY[setting],2,0,2*Math.PI);
        ctx.stroke();
        
        
        ctx.beginPath();
        ctx.moveTo(calX[setting],calY[setting]);
    }
    else if (setting==1)
    {
        calX[setting] = getX(event);
        calY[setting] = getY(event);
        $("#calX" + setting).val(calX[setting] / imageScale );
        $("#calY" + setting).val(calX[setting] / imageScale );
        ctx.lineTo(calX[setting],calY[setting]);
        ctx.stroke();
        
        ctx.strokeStyle = "gray";
        ctx.beginPath();
        ctx.arc(calX[setting],calY[setting],2,0,2*Math.PI);
        ctx.stroke();
    }
    else if(setting<6)
    {
        var i = setting - 2;
        while(isEnabled[i]==false)
        {
            setting++;
            i = setting - 2;
        }
        if(i<4)
        {
            skinX[i] = getX(event);
            skinY[i] = getY(event);
            $("#skinX" + i).val(skinX[i] / imageScale );
            $("#skinY" + i).val(skinY[i] / imageScale );

            ctx.beginPath();
            ctx.arc(skinX[i],skinY[i],10,0,2*Math.PI);
            ctx.stroke();
          
            isDrawing = true;
        }
    }
   
    setting++;
    event.preventDefault();
}
function stop(event) {
 
    if(isDrawing) {
       

        isDrawing = false;
    }
    event.preventDefault();
}
function init() {
    for(var i = 0; i<4;i++)
    {
        isEnabled[i]=true;
    }

    canvas.addEventListener("touchstart",start,false);
    canvas.addEventListener("touchmove",draw,false);
    canvas.addEventListener("touchend",stop,false);
    canvas.addEventListener("mousedown",start,false);
    canvas.addEventListener("mousemove",draw,false);
    canvas.addEventListener("mouseup",stop,false);
    canvas.addEventListener("mouseout",stop,false);
}

function getX(event) {
    
		if(event.type.contains("touch")) {
			return event.targetTouches[0].pageX-$("#imageCanvas").offset().left;
		}
		else {
			return event.layerX;
		}
	}
	
function getY(event) {
 
    if(event.type.contains("touch")) {
        return event.targetTouches[0].pageY-$("#imageCanvas").offset().top;
    }
    else {
       return event.layerY;
    }
}
function handleImage(e){

    var reader = new FileReader();
    reader.onload = function(event){
        
        img.onload = function(){
            imageScaleWidth = Math.min(imageScaleWidth,img.width);
            imageScale = imageScaleWidth/img.height;
            canvas.width = imageScaleWidth;
            canvas.height = imageScaleWidth * img.height / img.width;
            ctx.drawImage(img,0,0,imageScaleWidth,imageScaleWidth * img.height / img.width);
            
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);     
}