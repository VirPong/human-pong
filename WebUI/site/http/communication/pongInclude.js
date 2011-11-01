/**
	Trial for getting calling between multiple scripts
*/

(function(exports){

var Pong = function(){
	this.state = "test";
	this.xCoord = 400;
	this.yCoord = 300;
	/**
	this.canvas = document.getElementById('canvas');
	this.ctx = this.canvas.getContext('2d');
	return setInterval(this.draw, 10);	
*/

};

var paddleWidth = 20;
var paddleHeight = 45;

Pong.prototype.changeX = function(newX){
	// Call from client.js
	this.xCoord = newX;
};

// First attempt at moving paddle1
Pong.prototype.changeY = function(newY){
	// Calls from client.js
	this.yCoord = newY;
};
// Removed to align with the Osmus code 
Pong.prototype.init = function(){
	canvas = document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	console.log("init'ing");
	return setInterval(this.draw, 10);
};

/**
Pong.prototype.draw = function(){
	clear();
	
	ctx.fillStyle = "#FAFAFA";
	rect(10,20,400,300);
};
*/

// Working. Below were none-prototypes. Changing to see about yCoord 'getting'

Pong.prototype.draw = function(){
	console.log("drawing: " + this.yCoord);
	// The outline/canvas box
	// this.clear();
	this.ctx.clearRect(0,0,400,300);
	ctx.fillStyle = "#FAFAFA";
	Pong.rect(10,20,400,300);

	// Drawing paddle #1
	ctx.fillStyle = "#7F3A3F";
	// Tried to use this.yCoord here - Didnt work
	// Why? 
	// cant use yCoord <-- cuz 'yCoord is not defined'
	// cant use this.yCoord <-- cuz 'yCoord is undefined'
	paddle1(10,275);
	
};

Pong.prototype.clear = function(){
	ctx.clearRect(0,0,400,300);
};

Pong.prototype.rect = function(x,y,w,h){
	ctx.beginPath();
	ctx.rect(x,y,w,h);
	ctx.closePath();
	ctx.fill();
};

Pong.prototype.paddle1 = function(x,y){
	ctx.beginPath();
	ctx.rect(x,y,paddleWidth, paddleHeight);
	ctx.closePath();
	ctx.fill();
};

// Export to all scripts
exports.Pong = Pong;
})(typeof global === "undefined" ? window : exports);
