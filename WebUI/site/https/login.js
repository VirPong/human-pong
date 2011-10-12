
function validate(){


	// check that cookies are enabled
	if (!navigator.cookieEnabled) {
		alert("Please enable cookies.");
 		return false;
	}


	// give the form a shorter alias name
	var theForm = document.login;


	// ensure that all fields have been completed
	for (var i = 0; i < theForm.length - 2; i++) {
        	if (theForm.elements[i].value == "") {
        		alert("All fields must be complete.");
        		return false;
        	}
	}


	// check for valid username
	var accountNameRegEx = /[^a-zA-Z0-9\_]/;
	if (accountNameRegEx.test(theForm.username.value)) {
            alert("Username can only contain letters, numbers, and underscores.");
            return false;
	}
	if (theForm.username.value.length > 50) {
	    alert("Username must be fewer than 50 characters.");
	    return false;
	}


	// check for valid password
	var passwordRegEx = /[^a-zA-Z0-9\_]/;
	if (passwordRegEx.test(theForm.password.value)) {
            alert("Password can only contain letters, numbers, and underscores.");
            return false;
	}
	if (theForm.password.value.length > 50) {
	    alert("Password must be fewer than 50 characters.");
	    return false;
	}


	// if we get down here, everything should be okay
	return true;
}
