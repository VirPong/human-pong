var app = require('express').createServer(),
    sio = require('socket.io');

app.get('/', function(req, res){
  res.send('<script type="text/javascript" src="/socket.io/socket.io.js"></script>\
<script>\
  var socket = new WebSocket("http://10.150.1.204");\
  socket.on("news", function (data) {\
    alert(data.hello);\
  });\
  var myData = prompt("Get data!");\
  socket.emit("news", { hello: myData });\
</script>');
});

app.listen(3000);

var io = sio.listen(app);

io.sockets.on('connection', function (socket) {
  socket.emit('news', { hello: 'world' });
  socket.on('news', function(data) { console.log(data.hello);});
});
