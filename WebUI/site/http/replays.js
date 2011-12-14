/*@author Kyle Wenholz 
 * Contains user interface information, as well as communication to the 
 * server and the wiimote.
*/

var socket;

//Local accel.
var watchID;
var updateFrequencyCounter = 0;

//Username and password.
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
var paddleWidth = 3;
var paddleHeight = gameY/5;

//Step motion size.
var motionStep = 10;

//Ball position.
var xBall = gameX/2;
var yBall = gameY/2;

//Size of the ball
var ballR = gameX/20;

//Current score
var scoreLeft = 0;
var scoreRight = 0;

//Which paddle we are
var paddleID;

//Player names
var playerOneName = "P1";
var playerTwoName = "P2";

// Event identifiers. For sound effects.
var NOEVENT = 0;
var WALLBOUNCE = 1;
var PADDLEBOUNCE = 2;

// Sounds
//var paddleBounceSound = new Media("./sounds/paddlebounce.wav");
//var wallBounceSound = new Media("./sounds/wallbounce.wav");


// Various flags 
var fieldStyleFlag;
var wiiFlag = false;
var authLooping = false;

/**
 * Starts the pong game & grabs the canvas so that we can modify it in JS.
 */
function initCanvas(){
    displaySelection('gameCanvas');
    context = document.getElementById('gameCanvas').getContext('2d');
    context.canvas.width = window.innerWidth*(0.90);
    context.canvas.height = window.innerHeight*(0.75);
    screenModifierX = context.canvas.width/100;
    screenModifierY = context.canvas.height/100;
    
    var size = context.canvas.width;
    size = Math.floor(size*.04+.92);
    var font = String(size);
    
    context.fillStyle = "#ddd";
    var text = size+"px Silkscreen-Expanded";
    context.font = text;
    context.textBaseline = "top";
};

 
//========================================================================
//========================================================================
//=============================DRAWING CODE===============================
//========================================================================
//========================================================================


/**
 * Draws the game state.
 */
function draw(){
    context.clearRect(0,0, Math.floor(gameX*screenModifierX),
		      Math.floor(gameY*screenModifierY)); //clear the frame
    drawPaddles();
    //alert('clearRect2');
    drawBall();
    //alert('drawn');
    drawScore();
    drawHalfCourt();
};


/*
 * Draws a half court line.
 */
function drawHalfCourt() {
    var width = 3;
    var height = 3;
    var topY = 1.5*height;
    while(topY < gameY*screenModifierY - 1.5*height) {
        drawRect(gameX*screenModifierX/2 - .5*width, topY, width, height, 
		 'rgb(240,240,240)');
        topY = topY + 2*height;
    }
    
};

/**
 * Draws paddles based on the field positions.
 */
function drawPaddles() {   
    drawRect(0,
	     Math.floor(leftPad*screenModifierY),
	     Math.floor(paddleWidth*screenModifierX), 
             Math.floor(paddleHeight*screenModifierY), 
	     'rgb(240,240,240)');//xpos, ypos, width, height
    
    drawRect(Math.floor((gameX-paddleWidth)*screenModifierX),
	     Math.floor(rightPad*screenModifierY),
	     Math.floor(paddleWidth*screenModifierX),
             Math.floor(paddleHeight*screenModifierY), 
	     'rgb(240,240,240)');
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

    //Draw square "ball"
    var tlX = (xBall*screenModifierX)-10;
    var tlY = (yBall*screenModifierY)-10;
    var brX = ballR*3;
    var brY = ballR*3;
    
    drawRect(tlX, tlY, brX, brY, 'rgb(240,240,240)');
};

/**
 * Draws current score on the canvas. 
 */
function drawScore(){
    var score;
    
    score = String(scoreLeft);
    context.fillText(playerOneName+": " + score, gameX*screenModifierX/5, 10);
    
    score = String(scoreRight);
    context.fillText(playerTwoName+": "+ score, 2.5*gameX*screenModifierX/4,10);
};	


//========================================================================
//========================================================================
//==============================EVENT CODE================================
//========================================================================
//========================================================================

/**
 * Performs actions related to the wall bounce event.
 */
function eventController(eventCode){
    if(eventCode == NOEVENT) {}
    if(eventCode == PADDLEBOUNCE){
        paddleBounceEvent();
    }
    if(eventCode == WALLBOUNCE){
        wallBounceEvent();
    }
};
/**
 * Performs actions related to the wall bounce event.
 */
function wallBounceEvent(){
    //wallBounceSound.play();   
};
/**
 * Performs actions related to the paddle bounce event.
 */
function paddleBounceEvent(){
   // paddleBounceSound.play();
};



//========================================================================
//========================================================================
//=============================SERVER CODE================================
//========================================================================
//========================================================================
/**
 * The 'document.addEventListener' contains reactions to information sent 
 * by the server.
 */
document.addEventListener('DOMContentLoaded', function() {
    // The DOMContentLoaded event happens when the parsing of 
    // the current page is complete. This means that it only tries to 
    //connect when it's done parsing.
    displaySelection("inputMethodSelection");
});

function connectToServer(){	
    try{
   	socket = io.connect("10.150.1.204:3000"); 
    }catch(err){
   	alert("There was an error connecting to the server."+
   	     " Returning to the previous page.");
   	history.go(-1);
    }
    socket.emit("gameListRequest");
    /* A failed authentication event. */
    socket.on("authFailed", function(data){
	if(authLooping){
	    alert("Login is not working.  The server may be down.  We'll "+
		  "take you back home now.");
	    window.navigate("index.html");
	}
	isGuest = confirm("Your login failed.  Would you like to proceed as a guest?");
	if(isGuest){
	    authLooping = true;
	    socket.emit("auth", {username: "guest", password: "0000"});
	}else{
	    alert("You will now be returned to the previous page.");
	    history.go(-1);
	}
    });
    /* A successful authentication event. */
    socket.on("authGranted", function(data){
	authLooping = false;
    });
    /* Tells us which paddle we are. */
    socket.on('paddleID', function(data){
	if(data.paddleID == 0){
	    alert("You are the left paddle.");
	}else{
	    alert("You are the right paddle.");
	}
	paddleID = data.paddleID;
	initCanvas();
    });
    /* Retrievs the user names */
    socket.on("gameInfo", function(data){
	playerOneName = data.names[0];
	palyerTwoName = data.names[1];
    });
    /** Updates the state of the game (basically coordinates). */
    socket.on('gameState', function(data){
	//expecting arrays for paddle1, paddle2, ballPos
        leftPad = data.paddle[0];
        rightPad= data.paddle[1];
        xBall = data.ball[0];
        yBall = data.ball[1];
        eventController(data.gameEvent); // eventController executes events
        draw();
    });
    socket.on('scoreUpdate', function(data){
	scoreLeft = data.score[0];
        scoreRight = data.score[1];
    });
    /**When the server sends a room list, the player can pick a room or
       start a new one
       */
    socket.on('gameList', function(data){
	var gameList = "";
	for(i=0; i<data.numRooms; i=i+1){
		gameList=gameList+"<a class=\"button\" onclick=\"viewGame(\'"+data.rooms[i]+"\');\">"+data.rooms[i]+"</a>";
	}
	//Prompt for a valid room number
	displaySelection("selectGame", gameList);
//	while(data.rooms.indexOf(room)==-1){

//	  room = prompt("In which room would you like to play? \n"+
//			gameList);
//	}
    });
    /* A function for the end of a game. It notifies the player of whether
     he or she won/lost. */
    socket.on("gameEnd", function(data){
	resultString = "";
	if(scoreLeft<scoreRight){
	    if(paddleID == 0){
		displaySelection("gameEnd", "lost");
	    }else{
		displaySelection("gameEnd", "won");
	    }
	}else{
	    if(paddleID == 0){
		displaySelection("gameEnd", "won");
	    }else{
		displaySelection("gameEnd", "lost");
	    }
	}
    });
    /* A function for alerting the client when a disconnect occurs. */
    socket.on("disconnect", function(data){
	alert("You have been disconnected from the server! You will"+
	      " be returned to the previous page.");
	history.go(-1);
    });
    //alert the server of our player status
};

/**
 * Select the room to join.
 *@param room a string representing the room name
 *@param clientType player or spectator as a string
 */
function viewGame(gameName){
    socket.emit('viewGame', {game: gameName});
};

/**
 * Tells the server to make a room just for me.
 * @param {roomName} the name of the room to create
 */
function createRoom(roomName){
    socket.emit('createRoom', {name: roomName});
};

/**
 * Update our paddle position with the server.
 * @param {position} the new position of the paddle
 */
function updatePaddleToServer(position){
    socket.emit('paddleUpdate', {pos: position});
};

/**
 * Loads in login information from local storage to send to the server.
 */
function performAuthentication(){
    var username = localStorage.getItem("username");
    var pin = localStorage.getItem("pin");
    socket.emit("auth", {username: username, password: pin});
};

/**
 * Serves as a filter for various display options.  Game canvases,
 * buttons, input options, and even game end screens are initialized here.
 *@param {selection} a string representing the desired display: gameCanvas, 
 *	gameCanvasWithButtons, inputMethodSelection, selectRoom, newRoom, or gameEnd
 *@param {options} any of various options that go with {selection}
 */
function displaySelection(selection, options){    
    var view = document.getElementById("view");
    if(selection == "gameCanvas"){
	//A game canvas with no buttons
	view.innerHTML = "<canvas id=\"gameCanvas\" height=\"100\" "+
	    "width=\"100\"></canvas><br />";
    }else if(selection == "gameSelect"){
	view.innerHTML = " <div id=\"mainWrapper\"><h1 align=\"center\">Which game do you want to view?"+
	    options;
    }else if(selection == "gameEnd"){
	//A screen for the game finishing.  Also takes care of some cleanup.
	view.innerHTML == "The game is over."+
	    "<a align=\"center\" class=\"button\" onclick=\"\" href=\"index.html\">Return to the main screen.</a>";
    }
};

/**
  * Grabs the room name from an element roomName.roomName and submits it as 
  * a new room to the server.
  */
function handleNewRoom(){
    var room = document.getElementById('roomName').value;
    createRoom(room);
};