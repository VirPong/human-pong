/**
 *	Second attempt with rendering the Canvas tag
 */

(function(exports){

// shim layer with setTimeout fallback
window.requestAnimFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          window.oRequestAnimationFrame      ||
          window.msRequestAnimationFrame     ||
          function(/* function */ callback, /* DOMElement */ element){
            window.setTimeout(callback, 1000 / 60);
          };
})();

var Pong = function(){
	this.state = "test";
	this.xCoord = 0;
	this.yCoord = 0;
	/**
	this.canvas = document.getElementById('canvas');
	this.ctx = this.canvas.getContext('2d');
	return setInterval(this.draw, 10);	
*/
	this.canvas = document.getElementById('canvas');
	//console.log(canvas);
	this.context = this.canvas.getContext('2d');
	//console.log(context);

	// Paddle constants
	this.paddleHeight = 45;
	this.paddleWidth = 20;
};

// Carry-over == render
Pong.prototype.init = function(){
	// Dimensions to clear of Canvas (reason why some objects 		were'nt being all the way cleared
	this.context.clearRect(0,0,400,300);
	// Drawing background
	var initCtx = this.context;
	initCtx.fillStyle = "#FAFAFA";
	initCtx.beginPath();
  	initCtx.rect(0,0,400,300);
  	initCtx.closePath();
  	initCtx.fill();

	this.renderObject();
	console.log("calling Render");

	// Include refreshes
	var ctx = this;
	console.log(ctx);
	requestAnimFrame(function(){
		ctx.init.call(ctx);
	});
	
};

Pong.prototype.changeX = function(newX){
	this.xCoord = newX;

};

Pong.prototype.changeY = function(newY){
	this.yCoord = newY;
};

// Carry-over == renderObject_
Pong.prototype.renderObject = function(){
	var ctx = this.context;
	console.log(this.context);
	console.log(ctx);
	ctx.fillStyle=("#FA34B7");
  	ctx.beginPath();
	// Ball
  	ctx.arc(this.yCoord,this.xCoord,10,0, 2*Math.PI,true);
	// Paddle #1
	//this.paddle1(this.yCoord);
	// Paddle #2
	//this.paddle2(this.xCoord);
	console.log(this.yCoord);
  	ctx.closePath();
  	ctx.fill();
};

// Drawing seperate objects

Pong.prototype.paddle1 = function(y){
	var ctx = this.context;
	//ctx.fillStyle = "#FA23B1";
	ctx.rect(10, y, this.paddleWidth, this.paddleHeight);
	//console.log("height:"+this.paddleHeight);
	ctx.closePath();
	ctx.fill();
};

Pong.prototype.paddle2 = function(x){
	var ctx = this.context;
	//ctx.fillStyle = "#67FA12";
	ctx.rect(380, x, this.paddleWidth, this.paddleHeight);
	//console.log("height:"+this.paddleHeight);
	ctx.closePath();
	ctx.fill();
};


// Export to all scripts
exports.Pong = Pong;
//})(typeof global === "undefined" ? window : exports);
})(window);
