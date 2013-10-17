$(function() {
	String.prototype.contains = function(it) { return this.indexOf(it) != -1; };

	
});
var burnImage;
var headerHeight = 0;
var imageScaleWidth = 500;
var imageScale;
var img = new Image();
var imageLoader = document.getElementById('imageLoader');
    imageLoader.addEventListener('change', handleImage, false);
var canvas = document.getElementById('imageCanvas');
var canvasColors = document.getElementById('colorPalette');
canvasColors.width=100;
canvasColors.height=100;
var ctx = canvas.getContext('2d');
var paletteContext = canvasColors.getContext('2d');
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
    var x =getX(event);
    var y = getY(event);
    var color = burnImage.takeAverage(x,y);
    paletteContext.fillStyle="rgba("+Math.round(color["r"])+"," +Math.round(color["g"])+","+Math.round(color["b"])+"," +Math.round(color["a"])+")";
    paletteContext.fillRect(0,0,100,100);
    $("#isBurn").html(burnImage.isBurn(x,y) + "<br />"  + "rgba("+Math.round(color["r"])+"," +Math.round(color["g"])+","+Math.round(color["b"])+"," +Math.round(color["a"])+")");
    event.preventDefault();
}
function stop(event) {
 
    if(isDrawing) {
       

        isDrawing = false;
    }
    event.preventDefault();
}
function init() {

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
			return event.targetTouches[0].pageX-canvas.position().left;
		}
		else {
			return event.layerX;
		}
	}
	
function getY(event) {
 
    if(event.type.contains("touch")) {
        return event.targetTouches[0].pageY-canvas.position().top;
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
            burnImage = new BurnImage(ctx);
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);     
}