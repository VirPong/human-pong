 function promptLogin(){
		var name = prompt("Hey you!"); //"Username please. (Use \"guest\" if you don't already have an account.");
		//var pass = prompt("Please enter your password. (If you are logging in as \"guest\" then please use \"pass\".)");
        
 }

function connectToGame() {
    
    var mySocket = new GapSocket(cs340-serv, 8000);
    mySocket.onopen = function(){alert("Connected!")};
    mySocket.onerror = function(msg){alert("FUCK")};
    
    
}