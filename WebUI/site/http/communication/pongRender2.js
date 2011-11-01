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
});

var Pong = function(){
	this.state = "test";
	this.xCoord = 400;
	this.yCoord = 300;
	/**
	this.canvas = document.getElementById('canvas');
	this.ctx = this.canvas.getContext('2d');
	return setInterval(this.draw, 10);	
*/
	this.canvas = document.getElementById('canvas');
	this.ctx = this.canvas.getContext('2d');
};

Pong.prototype.init = function(){
	this.ctx.clearRect(0,0,400,300);
};

Pong.prototype.changeX = function(newX){

};

Pong.prototype.changeY = function(newY){

};


// Export to all scripts
exports.Pong = Pong;
})(typeof global === "undefined" ? window : exports);
