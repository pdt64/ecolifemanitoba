function formHasErrors(){
	let errorFlag = false;

	let email = document.getElementById("email");
	let pass = document.getElementById("pass");

	if(email.value == null || email.value == "")
	{
		document.getElementById("email_error").style.display = "block";

		if(!errorFlag)
		{
			email.focus();
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
	document.getElementById("login").addEventListener("click", validate);
}

document.addEventListener("DOMContentLoaded", load);