
function validLogin(){

	var theForm = document.login;

	var accountNameRegEx = /[^a-zA-Z0-9\_]/;
	if (accountNameRegEx.test(theForm.username.value)) {
            alert("Username can only contain letters, numbers, and underscores.");
            return false;
	}
	if (theForm.username.value.length > 50) {
	    alert("Username must be fewer than 50 characters.");
	    return false;
	}

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
