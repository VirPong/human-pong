//Username and password, apparently.
var name;
var pass;
//The canvas object handle.
var context;

//Standard 100x100 game space.
var gameX = 100;
var gameY = 100;

//Defining the screen modifiers.
var screenModifierX;
var screenModifierY;

//Positions of rightPad and leftPad
var rightPad = gameY/2;
var leftPad = gameY/2;

//Size of paddles.
var paddleWidth = gameX/15;
var paddleHeight = gameY/5;

//Step motion size.
var motionStep = gameY/10;

//Ball position.
var xBall = gameX/2;
var yBall = gameY/2;

//Size of the ball
var ballR = gameX/20;

//Current score
var scoreLeft = 0;
var scoreRight = 0;

//Which paddle we are
var WHAT_PADDLE_AM_I;


/**
 * Start the pong game & grab the canvas so that we can modify it in JS.
 */
function initClient(){
	context = gameCanvas.getContext("2d");
	//alert("I initialized");
	context.canvas.width = window.innerWidth*(0.65);
	context.canvas.height = window.innerHeight*(0.7);
	screenModifierX = context.canvas.width/100;
	screenModifierY = context.canvas.height/100;
};



//===============================================================================================
//===============================================================================================
//===================================PADDLE HANDLING CODE========================================
//===============================================================================================
//===============================================================================================

/**
 * Receive the input and send it to changePaddlePosition(), which actually changes the paddle position.
 * @param {e} the event passed by the keypress.
 */
function movePaddle(e) {
	var evntObj = (document.all)?event.keyCode:e.keyCode;
	var actualKey = String.fromCharCode(evntObj);
	changePaddlePosition(actualKey);
};


/**
 * Change the value of leftPaddle or rightPaddle so that it will draw in the correct place.
 *  @param {actualKey} The string value of the key pressed.
 */
function changePaddlePosition(actualKey) {
	if(WHAT_PADDLE_AM_I == 0){
		if(actualKey == "W"){ //check which key was pressed
			if(leftPad > 0){ // do nothing if it would move paddle out of frame
				leftPad = leftPad - motionStep;
			}
		}else if(actualKey == "S"){
			if(leftPad < (gameY - paddleHeight)){
				leftPad = leftPad + motionStep;
			}
		}updatePaddleToServer(leftPad);
	}else{
		if(actualKey == "W"){ //check which key was pressed
			if(rightPad > 0){ // do nothing if it would move paddle out of frame
				rightPad = rightPad - motionStep;
			}
		}if(actualKey == "S"){
			if(rightPad < (gameY - paddleHeight)){
				rightPad = rightPad + motionStep;
			}
		}updatePaddleToServer(rightPad);
	}
};

//===============================================================================================
//===============================================================================================
//========================================DRAWING CODE===========================================
//===============================================================================================
//===============================================================================================

/**
 * Draws the game state.
 */
function draw(){
	//alert("drawing");
	//alert(Math.floor(leftPad*screenModifierY)+"upper-left   bottom-right"+Math.floor(paddleWidth*screenModifierX));
	context.clearRect(0,0, Math.floor(gameX*screenModifierX),Math.floor(gameY*screenModifierY)); //clear the frame

	//alert("clearRect");
	drawRect(0,Math.floor(leftPad*screenModifierY),Math.floor(paddleWidth*screenModifierX), Math.floor(paddleHeight*screenModifierY), "rgb(0,200,0)");//xpos, ypos, width, height
	//alert("drawRect1");
	drawRect(Math.floor((gameX-paddleWidth)*screenModifierX),Math.floor(rightPad*screenModifierY),Math.floor(paddleWidth*screenModifierX),
			Math.floor(paddleHeight*screenModifierY), "rgb(255,0,0)");
	//alert("clearRect2");
	drawBall(xBall, yBall);
	//alert("drawn");
};

/**
 * Draws rectangles on the canvas.
 * @param a top-left x-position
 * @param b top-left y-position
 * @param c bottom-right x-position
 * @param d bottom-right y-position
 * @param col color of the paddle
 */
function drawRect(a, b, c, d, col){
	context.save();

	context.beginPath();
	context.fillStyle = col; //color to fill shape in with
	context.rect(a,b,c,d); //draws rect with top left corner a,b
	context.closePath();
	context.fill();

	context.restore();
};

/**
 * Draws the ball at current position.
 */
function drawBall(){
	context.save();

//	ballPaddleLogic();

	context.beginPath();
	context.fillStyle = "rgb(200,0,0)"; //color to fill shape in with

	context.arc(xBall*screenModifierX,yBall*screenModifierY,ballR*screenModifierX,0,Math.PI*2,true);
	context.closePath();
	context.fill();

	context.restore();
};

/**
 * Draws current score on the canvas. 
 */
function drawScore(){
	context.fillStyle = "#00f";
	context.font = "bold 50px sans-serif";
	context.textBaseline = "top";

	var score;
	score = String(scoreLeft);
	context.fillText("Player 1: " + score, gameX*screenModifierX/4, 10);

	var score;
	score = String(scoreRight);
	context.fillText("Player 2: " + score, 3*gameX*screenModifierX/4,10);
};
//Listen for keypresses as input methods
document.onkeydown = movePaddle;



//===============================================================================================
//===============================================================================================
//========================================SERVER CODE============================================
//===============================================================================================
//===============================================================================================
/**
 * The "document.addEventListener" contains reactions to information sent by the server.
 */
document.addEventListener("DOMContentLoaded", function() {
	// The DOMContentLoaded event happens when the parsing of the current page
	// is complete. This means that it only tries to connect when it"s done
	// parsing.
	socket = io.connect("10.150.1.204:3000");
	socket.on("sendScore", function(data){
        scoreLeft = data[0];
        scoreRight = data[1];
    });
	socket.on("paddleNum", function(data){
		WHAT_PADDLE_AM_I = data.paddleNum;
	});
	socket.on("updateGame", function(data){//expecting arrays for paddle1, paddle2, ballPos
		//alert("update game");
		leftPad = data.paddle[0];
		rightPad= data.paddle[1];
		xBall = data.ball[0];
		yBall = data.ball[1];
		draw();
		// draw(data.ballPos[0], data.ballPos[1]);
	});
	//alert the server of our player status
	clientType();
});


/**
 * Alert the server of our player type.
 */
function clientType(){
	// alert("Sending client type");
	socket.emit("clientType", {type: "player"});
};

/**
 * Update our paddle position with the server.
 * @param {position} the new position of the paddle
 */
function updatePaddleToServer(position){
	//alert("update paddle "+position);
	socket.emit("updatePaddle", {pos: position});
};
/**
 * Asks the user for some login information and stores it for submission to the server.
 */
function promptLogin(){
	name = prompt("Username please. (Use \"guest\" if you don't already have an account.");
	pass = prompt("Please enter your password. (If you are logging in as \"guest\" then please use \"pass\".)");
};