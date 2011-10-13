var io = require('socket.io').listen(7676);

var observerCount = 0;
var yPosition = 0;

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
    socket.emit('time', {
      timeStamp: (new Date()).valueOf(),
      observerCount: observerCount,
      YCoord: yPosition
    });
    yPosition += 5;
  }, 2000);
});
