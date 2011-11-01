/**
	Going to try rendering the Canvas tag via the code in Osmus
*/

(function(exports) {

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

/**
 * Canvas-based renderer
 */
// var CanvasRenderer = function(game) {
var Pong = function(){
  //this.game = game;
  this.canvas = document.getElementById('canvas');
  this.context = this.canvas.getContext('2d');
};
// ours is Pong.init
Pong.prototype.render = function() {
  this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
  //var objects = this.game.state.objects;
  // Render the game state
/**
  for (var i in objects) {
    var o = objects[i];
    if (o.dead) {
      // TODO: render animation.
      if (o.type == 'player') {
        console.log('player', o.id, 'died');
      }
    }
    if (o.r > 0) {
      this.renderObject_(o);
    }
  }
*/
  //this.renderObject_();
  var ctx = this;
  requestAnimFrame(function() {
    ctx.render.call(ctx);
  });
};
/**
CanvasRenderer.prototype.renderObject_ = function(obj) {
  var ctx = this.context;
  ctx.fillStyle = (obj.type == "player" ? 'green' : 'red');
  ctx.beginPath();
  ctx.arc(obj.x, obj.y, obj.r, 0, 2 * Math.PI, true);
  ctx.closePath();
  ctx.fill();
  if (obj.type == 'player') {
    ctx.font = "8pt monospace";
    ctx.fillStyle = 'black';
    ctx.textAlign = 'center';
    ctx.fillText(obj.id, obj.x, obj.y);
  }

};
*/

Pong.prototype.renderObject_ = function(){
  var ctx = this.context;
  ctx.fillStyle("#FA34B7");
  ctx.beginPath();
  ctx.arc(10,10,10,0, 2*Math.PI,true);
  ctx.closePath();
  ctx.fill();
};

exports.Pong = Pong;
})(typeof global === "undefined" ? window : exports);
