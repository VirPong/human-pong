
function validate(){


	// check that cookies are enabled
	if (!navigator.cookieEnabled) {
		alert("Please enable cookies.");
 		return false;
	}


	// give the form a shorter alias name
	var theForm = document.accountsettings;


	// ensure that all fields have been completed
	for (var i = 0; i < theForm.length - 2; i++) {
        	if (theForm.elements[i].value == "") {
        		alert("All fields must be complete.");
        		return false;
        	}
	}


	// check for valid new password
	if (theForm.newpassword.value.length > 50) {
	    alert("New password must be fewer than 50 characters.");
	    return false;
	}
	if (theForm.newpassword.value != theForm.newpassword1.value) {
            alert("Please re-confirm your new password.");
            return false;
	}


	// check for valid first and last name
	var nameRegEx = /[^a-zA-Z\-]/;
	if (nameRegEx.test(theForm.firstname.value) ||
	    nameRegEx.test(theForm.lastname.value)) {
	    alert("Please enter a valid first and last name.");
	    return false;
	}
	if (theForm.firstname.value.length > 50) {
	    alert("First name must be fewer than 50 characters.");
	    return false;
	}
	if (theForm.lastname.value.length > 50) {
	    alert("Last name must be fewer than 50 characters.");
	    return false;
	}


	// check for valid email address
	var emailRegEx = /^[a-zA-Z0-9\.\_\-\+]+@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/;
	if (!emailRegEx.test(theForm.email.value)) {
            alert("Please enter a valid e-mail address.");
            return false;
	}
	if (theForm.email.value.length > 256) {
	    alert("Email address must be fewer than 256 characters.");
	    return false;
	}


	// if we get down here, everything should be okay
	return true;
}
