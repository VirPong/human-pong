//The DOMContentLoaded event happens when the parsing of the current page
//is complete. This means that it only tries to connect when it's done
//parsing.
document.addEventListener('DOMContentLoaded', function() {
  var socket = io.connect('10.150.1.204:3000');
  //when we receive any news, alert the user.
  socket.on('news', function (data) {
    alert(data.hello);
  });
  socket.emit('news', { hello: 'world' });
});