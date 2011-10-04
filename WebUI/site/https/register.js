
//we may want to edit some of these tests, especially the length ones

/**
 * Validate the form input.
 */
function validate() {
	// check that cookies are enabled
	if (!navigator.cookieEnabled) {
		alert("Please enable cookies.");
 		return false;
	}
    
	// give the form a shorter alias name
	var theForm = document.customerinfo;
	
	// ensure that all fields have been completed
	for (var i = 0; i < theForm.length - 2; i++) {
        	if (theForm.elements[i].value == "") {
        		alert("All fields must be complete.");
        		return false;
        	}
	}
	

	// check for valid first and last name
	var nameRegEx = /[^a-zA-Z\-]/;
	if (nameRegEx.test(theForm.firstname.value) ||
	    nameRegEx.test(theForm.lastname.value)) {
	    alert("Please enter a valid first and last name.");
	    return false;
	}
	if (theForm.firstname.value.length > 20) {
	    alert("First name must be fewer than 20 characters.");
	    return false;
	}
	if (theForm.lastname.value.length > 30) {
	    alert("Last name must be fewer than 30 characters.");
	    return false;
	}
	
	var usernameRegEx = /[^a-zA-Z0-9\_]/;
	if (usernameRegEx.test(theForm.username.value)) {
            alert("Your username can only contain letters, numbers, and underscores.");
            return false;
	}
	if (theForm.username.value.length > 20) {
	    alert("Your username must be fewer than 20 characters.");
	    return false;
	}
	
	var passwordRegEx = /[^a-zA-Z0-9\_]/;
	if (passwordRegEx.test(theForm.password.value)) {
            alert("Your password can only contain letters, numbers, and underscores.");
            return false;
	}
	if (theForm.password.value.length > 20) {
	    alert("Password must be fewer than 20 characters.");
	    return false;
	}
	
	var emailRegEx = /^[a-zA-Z0-9\.\_\-\+]+@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/;
	if (!emailRegEx.test(theForm.email.value)) {
            alert("Please enter a valid e-mail address.");
            return false;
	}
	if (theForm.email.value.length > 40) {
	    alert("Email address must be fewer than 40 characters.");
	    return false;
	}

	// if we get down here, everything should be okay
	return true;
}
