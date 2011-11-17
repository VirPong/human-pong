
/**
 * Validate the form input.
 */
function validate()
{


	// check that cookies are enabled
	if (!navigator.cookieEnabled)
	{
		alert("Please enable cookies.");
		return false;
	}


	// give the form a shorter alias name
	var theForm = document.newuser;


	// ensure that all fields have been completed
	for (var i = 0; i < theForm.length - 2; i++)
	{
		if (theForm.elements[i].value == "")
		{
			alert("All fields must be complete.");
			return false;
		}
	}


	// check for valid first and last name
	var nameRegEx = /[^a-zA-Z\-]/;
	if (nameRegEx.test(theForm.firstname.value) ||
		nameRegEx.test(theForm.lastname.value))
	{
		alert("Please enter a valid first and last name.");
		return false;
	}
	if (theForm.firstname.value.length > 50)
	{
		alert("First name must be fewer than 50 characters.");
		return false;
	}
	if (theForm.lastname.value.length > 50)
	{
		alert("Last name must be fewer than 50 characters.");
		return false;
	}


	// check for valid username
	var usernameRegEx = /[^a-zA-Z0-9\_]/;
	if (usernameRegEx.test(theForm.username.value))
	{
		alert("Your username can only contain letters, numbers, and underscores.");
		return false;
	}
	if (theForm.username.value.length > 50)
	{
		alert("Your username must be fewer than 50 characters.");
		return false;
	}


	// check for valid password
	var passwordRegEx = /[^a-zA-Z0-9\_]/;
	if (passwordRegEx.test(theForm.password.value))
	{
		alert("Your password can only contain letters, numbers, and underscores.");
		return false;
	}
	if (theForm.password.value.length > 50)
	{
		alert("Password must be fewer than 50 characters.");
		return false;
	}


	// check for valid email address
	var emailRegEx = /^[a-zA-Z0-9\.\_\-\+]+@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/;
	if (!emailRegEx.test(theForm.email.value))
	{
		alert("Please enter a valid e-mail address.");
		return false;
	}
	if (theForm.email.value.length > 256)
	{
		alert("Email address must be fewer than 256 characters.");
		return false;
	}


	// if we get down here, everything should be okay
	return true;
}
