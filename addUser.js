function formHasErrors(){
	let errorFlag = false;

	let emailRegex = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);

	let email = document.getElementById("email");
	let username = document.getElementById("username");
	let pass = document.getElementById("pass");
	let type = document.getElementById("usertype");

	if(email.value == null || email.value == "")
	{
		document.getElementById("email_error").style.display = "block";

		if(!errorFlag)
		{
			email.focus();
		}

		errorFlag = true;
	}

	if(username.value == null || username.value == "")
	{
		document.getElementById("name_error").style.display = "block"

		if(!errorFlag)
		{
			username.focus();
		}

		errorFlag = true;
	}

	if(pass.value == null || pass.value == "")
	{
		document.getElementById("pass_error").style.display = "block"

		if(!errorFlag)
		{
			pass.focus();
		}

		errorFlag = true;
	}

	if(type.value == null || type.value == "")
	{
		document.getElementById("usertype_error").style.display = "block"

		if(!errorFlag)
		{
			type.focus();
		}

		errorFlag = true;
	}

	if(type.value !== null && type.value !== ""){

		if(type.value > 2 || type.value < 1)
		{
			document.getElementById("invalidtype_error").style.display = "block"

			if(!errorFlag)
			{
				type.focus();
			}

			errorFlag = true;
		}
	}
	


	if(!emailRegex.test(email.value) && !email.value == "")
	{
		document.getElementById("invalid_error").style.display = "block"

		if(!errorFlag)
		{
			email.focus();
		}

		errorFlag = true;
	}

	return errorFlag;
}



function hideErrors(){
	let error = document.getElementsByClassName("error");

	for ( let i = 0; i < error.length; i++ )
	{
		error[i].style.display = "none";
	}
}

function validate(e){
	hideErrors();

	if(formHasErrors())
	{
		e.preventDefault();
		return false;
	}
	return true;
}

function resetForm(e){
		hideErrors();
		
		document.getElementById("name").focus();

		e.preventDefault();
}



function load(){
	hideErrors();
	document.getElementById("add").addEventListener("click", validate);
}

document.addEventListener("DOMContentLoaded", load);