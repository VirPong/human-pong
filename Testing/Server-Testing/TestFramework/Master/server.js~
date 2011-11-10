/* Server.js v.0.2 for Vir-Pong, Inc */
/* Daniel Guilak -- daniel.guilak@gmail.com */

var PORT = 3000;
//Require the express framework (which creates a server)
var app = require('express').createServer(),
sys = require(process.binding('natives').util ? 'util' : 'sys')
//and socket.io which provides websocket support.
    sio = require('socket.io');

//set the server to listen on port
app.listen(PORT);

//set the sockets to listen on same port.
var io = sio.listen(app);
io.set('log level', 1); // reduce logging

/* Variable declarations */
var gSpectators = [];
var gPlayers = [];

var gPaddlePos; // [player1, player2] height position.
var gBallPos;   // [ballX, ballY] ball positions.
var gBallV;	// [ballVX, ballVY] ball velocities. 
var gBallR;	// The ball radius (currently not in implementation)
var gScore;	// [scorePlayer1, scorePlayer2] player scores.
var gFieldSize; // [fieldX, fieldY] size of the game field.
var gPaddleSize;// [paddleHeight, paddleWidth]

/*
Helper function to send the game state to all connected clients.

This will soon be phased out to support multiple game instances.

Emits updateGame node event with paddle and ball position arrays.
*/
function sendGameState(){
  io.sockets.emit('onUpdateGame', {paddle: gPaddlePos, ball: gBallPos});
}

/* This is the main game loop that is set to run every 50 ms. */
function startGame(){
setInterval(function() {
    ballLogic(); //Run ball logic simulation.
    sendGameState(); //Send game state to all sockets.

    //THIS CODE will be phased in soon.
    //For every player, send the game state.
    // for(p in gPlayers){
    //  sendGameState(p); 
    //}
    //for(s in gSpectators){
    //  sendGameState(s);
    //}
  }, 50);
}

/* Sends an onSendScore event to all connected clients (will be phased out soon for a more
modular approach */
function sendScore(){
 //Still sending to everyone.
 io.sockets.emit('onSendScore', { data: gScore });
}

/*
 This ball logic code originated from David Eva, slightly modified for use on the server. Needs tweaking.
*/ 

function ballLogic(){

  //Ball bouncing logic
  
  if( gBallPos[1]<0 || gBallPos[1]>gFieldSize[1]){
    gBallV[1] = -gBallV[1]; //change gBallPos[1] direction if you go off screen in y direction ....
  }
  
  // Paddle Boundary Logic
  
  // changed all these numbers to more reasonable also, these kinda stuff should also be fields but we can
  // think about that later
  
  if((gBallPos[0] == 10) && (gBallPos[1] > gPaddlePos[0] - 3) && (gBallPos[1] < (gPaddlePos[0] + gPaddleSize[0] + 3))){ //if it hits the left paddle
    gBallV[0] = -gBallV[0]; //get faster after you hit it
  }
  if((gBallPos[0] == gFieldSize[0] - 10) && (gBallPos[1] > gPaddlePos[1] - 3) && (gBallPos[1] < (gPaddlePos[1] + gPaddleSize[0] + 3))){ //if it hits the right paddle
    gBallV[0] = -gBallV[0];
  }
  
  // if ball goes out of frame reset in the middle and put to default speed and increment gScore...
  
  if(gBallPos[0] < -10){ //changed these numbers you had old ones so ball was going super far out of frame
    gBallPos[0] = gFieldSize[0]/2;
    gBallPos[1] = gFieldSize[1]/2;
    gBallV[0] = 1;
    gBallV[1] = 2;
    gScore[1] = gScore[1] + 1;
    sendScore();
  }
  if(gBallPos[0] >gFieldSize[0] +10 ){ //changed these numbers you had old ones so ball was going super far out of frame
    gBallPos[0] = gFieldSize[0]/2;
    gBallPos[1] = gFieldSize[1]/2;
    gBallV[0] = 1;
    gBallV[1] = 2;
    gScore[0] = gScore[0] + 1; 
    sendScore();
  }
  
  gBallPos[0]+=gBallV[0];
  gBallPos[1]+=gBallV[1];
}

/* 
Initializes the game state.

In future revisions, magic numbers will be replaced with
constants and parameters.
*/
function initGame(){
  console.log("Game initializing!");
  gPaddlePos = [50,50];
  gBallPos = [50,50];
  gScore = [0,0];
  gFieldSize = [100,100];
  gBallV = [1,2];
  gBallR = (1/20)*gFieldSize[1];
  //height, width
  gPaddleSize = [(1/5)*gFieldSize[0], (1/15)*gFieldSize[1]];
}

/*
  This gets called when someone connects to the server.
  The argument of the function is essentially a pointer to that particular client's socket.
*/
io.sockets.on('connection', function (aClient) { //Note: connection is a library-specific event and its name cannot be easily changed.
  console.log("Client connecting.");
  var clientType; 
  var playerNum;

  //When a particular client sends a "clientType" event -- argument is data from client.
  aClient.on('onClientType', function(data) {
     clientType = data.type;

     //Determine which list to add the client to.
     if(clientType == 'spectator'){
	gSpectators.push(aClient);
	console.log('Spectator!');
     }
     //Once there are two gPlayers, no more connections can be gPlayers.
     if(clientType == 'player' && gPlayers.length < 2){
	if(gPlayers.length == 0){ //Temporary algorithm for player ID
	  playerNum = 0;
	} else {
	  playerNum = 1;
	}
	gPlayers.push(aClient);
	aClient.emit('paddleNum', {paddleNum: playerNum});
	console.log('Player ' + playerNum  + '!');
     }
     	
     
     //Once there are two gPlayers, start the game.
     if(gPlayers.length == 2){
	initGame();
	startGame();
     }	
  });

  //When a client sends an updatePaddle event, record their new paddle position.
  aClient.on('onUpdatePaddle', function(aData) {
    //update the value of particular paddle position.
    gPaddlePos[playerNum] = aData.pos; 
    console.log("Player " + (playerNum + 1) + " pos:" + aData.pos);
  });

});

