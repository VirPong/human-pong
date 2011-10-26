document.addEventListener('DOMContentLoaded', function() {

// Globals
socket = io.connect('10.203.0.131:7676');
pong = new Pong();
pong.init();

// Added for testing of using game.js and render.js


// Get the initial game state
socket.on('start', function(data) {
  console.log('recv state', data);

  // Get the initial time to calibrate synchronization.
  // Dont think we use this. Kept in case for time sync
  // var startDelta = new Date().valueOf() - data.state.timeStamp;

});


socket.on('state', function(data) {
});

// Get a time sync from the server
socket.on('time', function(data) {

  // Number of clients that aren't playing.

  // Want to keep these features - Need redesign later (@observer-count references game object.) and (@updateDelta was removed from this version)

  // My simplified attempt
  document.getElementById('observer-count').innerText = (data.observerCount);
  console.log('observer-count', data.observerCount);
  // Time stamp
  document.getElementById('time-stamp').innerText = (data.timeStamp);
  // pongIncludeTrial code. Attempting to make variables cross scripts
  // Works. Can pass back and forth using the next two lines of code
  pong.changeX(data.timeStamp); 
  //pong.changeY(data.observerCount*3);
  pong.changeY(data.YCoord);
  pong.changeX(data.XCoord);
  /**
  document.getElementById('observer-count').innerText =
      Math.max(data.observerCount - game.getPlayerCount(), 0);
  document.getElementById('average-lag').innerText = Math.abs(updateDelta);
  */ 

  // Beginning of getting Coordinates into the communication
  document.getElementById('YCoord').innerText = (data.YCoord);
  document.getElementById('average-lag').innerText = (pong.xCoord);
});

});
