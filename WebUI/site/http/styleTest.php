<?php
	session_start();
	include_once('header.php');
?>

<center><h1>&#9612; Watch VirPong Live &#9616;</h1></center>
<div align = "right">
	<h2> Score Player 2: </h2>
</div>
<div align ="left">
	<h2> Score Player 1: </h2>
</div>
<section> 
	<center>
    <div> 
        <canvas id="canvas" width="400" height="300"> 
         This text is displayed if your browser 
         does not support HTML5 Canvas - which is pretty
	 lame, because we were planning on using Canvas as
	 our, well, canvas for drawing on.
        </canvas> 
    </div> 
	</center>
</section>

<script type="text/javascript"> 
var canvas;  
var ctx;
// x,y Coords Player 1
// var x = 400;
// var y = 300;
// Coords halved to start in middle of field
var x = 380;
var y = 150;
// x,y Coords Player 2
//var qwertyX = 0;
//var qwertyY = 0;
var qwertyX = 10;
var qwertyY = 150;
// Movement variables
var dx = 2;
var dy = 4;
// Paddle shape
var paddleHeight = 45;
var paddleWidth = 20;
// Canvas dimensions
var WIDTH = 400;
var HEIGHT = 300; 
 
// KeyCode variables for keyboard input
// Paddle one
var left = 37;
var right = 39;
var up = 38;
var down = 40;
// Paddle two
var qwertyA = 65;
var qwertyS = 83;
var qwertyD = 68;
var qwertyW = 87;


//draws the Ball
//takes x and y coord for parameters
function circle(cx,cy) {
	ctx.beginPath();
	ctx.moveTo(cx, cy);
	ctx.arc(cx, cy, 11, 0, Math.PI*2, false);
	ctx.closePath();
	ctx.fill();
}

 
// Added in - Paddle 1
function paddle1(x,y){
  ctx.beginPath();
  ctx.rect(x,y,paddleWidth, paddleHeight);
  ctx.closePath();
  ctx.fill();
}
 
// Added in - Paddle 2
function paddle2(qwertyX,qwertyY){
  ctx.beginPath();
  ctx.rect(qwertyX,qwertyY,paddleWidth, paddleHeight);
  ctx.closePath();
  ctx.fill();
}
 
 
function rect(x,y,w,h) {
  ctx.beginPath();
  ctx.rect(x,y,w,h);
  ctx.closePath();
  ctx.fill();
}
 
 
function clear() {
  ctx.clearRect(0, 0, WIDTH, HEIGHT);
}
 
function init() {
  canvas = document.getElementById("canvas");
  ctx = canvas.getContext("2d");
  return setInterval(draw, 10);
}
 
 
function draw() {
  clear();
 
  ctx.fillStyle = "#FAF7F8";
  rect(10,20,WIDTH,HEIGHT);
 
  ctx.fillStyle = "#444444";
  // circle(x, y, 10);
 
  ctx.fillStyle = "#7F3AF8";
  paddle1(x,y);
 
  ctx.fillStyle = "#1A7F93";
  paddle2(qwertyX, qwertyY);
  
  //draws ball. Takes the x and y coord as parameters
  ctx.fillStyle = "#7AB000";
  circle(300,40);
 
  //if (x + dx > WIDTH || x + dx < 0)
    //dx = -dx;
  //if (y + dy > HEIGHT || y + dy < 0)
    //dy = -dy;
 
  //x += dx;
  //y += dy;
 
  window.onkeydown = function(e){
 
	// Keyboard input
	var keyCode = e.keyCode;
	
	// Removed functionality for left/right movement for
	// Player 1 and Player 2
 
	// Player 1
	// if(keyCode == left){
	//	x -= dx;
	//}
	if(keyCode == up&&y>23){
		y -= dy;
	}
	//if(keyCode == right){
	//	x += dx;
	//}
	if(keyCode == down&&y<254){
		y += dy;
	}
	// Saved
	//x -= dx;
	//y -= dy;
 
	// Player 2
	//if(keyCode == qwertyA){
	//	qwertyX -= dx;
	//}
	if(keyCode == qwertyW && qwertyY>23){
		qwertyY -= dy;
	}
	//if(keyCode == qwertyD){
	//	qwertyX += dx;
	//}
	if(keyCode == qwertyS && qwertyY<254){
		qwertyY += dy;
	}
 
  }
}
 
init();
</script> 


<?php
	include_once($footer);
?>