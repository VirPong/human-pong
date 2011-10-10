 function promptLogin(){
		var name = prompt("Hey you!"); //"Username please. (Use \"guest\" if you don't already have an account.");
		//var pass = prompt("Please enter your password. (If you are logging in as \"guest\" then please use \"pass\".)");
 }

function connectToGame() {
  
    navigator.notification.alert(
                                 'You are the winner!',  // message
                                 alertDismissed,         // callback
                                 'Game Over',            // title
                                 'Done'                  // buttonName
                                 );
    
}

function alertDismissed() {
    
    // Whatever.
    
}