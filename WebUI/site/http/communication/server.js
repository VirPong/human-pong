var io = require('socket.io').listen(7676);

var observerCount = 0;
var yPosition = 0;
// Random coordinates for demo'ing product
var randXCoord = 0;
var randYCoord = 0;

io.sockets.on('connection', function(socket) {
  // Increments the observerCount
  observerCount++;

	// on connection
	socket.emit('start', {name: 'placeHolder'});
	socket.on('state', function(data){
		socket.emit('state', data);
		yPosition = 0;
	});

	// on disconnect
	socket.on('disconnect', function(data){
		socket.emit('client disconnect');
		observerCount--;
	});

  // Periodically emit time sync commands
  var timeSyncTimer = setInterval(function() {
    randXCoord = Math.floor(Math.random()*300);
    randYCoord = Math.floor(Math.random()*300);
    // Send the time event
    socket.emit('time', {
      timeStamp: (new Date()).valueOf(),
      observerCount: observerCount,
      YCoord: randYCoord,
      XCoord: randXCoord
    });
    yPosition += 5;
  }, 2000);
});
