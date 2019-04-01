//Function called by the login button on the login form
//Either redirects the user to the appropriate page or gives error message
//For some reason this didnt work below the function($) part
//Written by Stefan
$(document).ready(function() {

	//On login button click
	$(".validate-form").submit( function() {
		event.preventDefault();

		//Make a post request to login.php
		var getUser = $('#getUsername')[0].value;
		var getPass = $('#getPassword')[0].value;

		//You can check if theyre empty here but my script should work in those cases

		$.post("./includes/DBinteractivity/login.php",
		{
			username: getUser,
			password: getPass
		}, function(data){
			try
			{
				data = JSON.parse(data);
			}
			catch(e)
			{
				// console.log(e);
			}
			//If the login was successful
			if(data['msg'] === "200 OK")
			{	
				//Check if the user is an admin or not
				// if(data['isAdmin'])
				// {
				// 	//If the user is an admin
				// 	window.location.replace("createTicketPage.php");
				// }
				// else
				// {
					
				// 	//If the user is not an admin
				// 	window.location.replace("createTicketPage.php");
				// }
				window.location.replace("index.php");
			}
			else
			{
				$("#login-feedback").addClass('is-invalid');
				//Give error feedback to user here since login was not successful
			}
		});
	}); 

	// On focus of username or password text boxes, remove invalid feedback
	$("#getPassword").focusin(function(){ $("#login-feedback").removeClass('is-invalid'); });
	$("#getUsername").focusin(function(){ $("#login-feedback").removeClass('is-invalid'); });

	// These will be in charge of feedback
	$("#inputMachineName").focusout(function(){
		toggleFeedback("#inputMachineName");
	});

	$("#inputRoom").focusout(function(){
		toggleFeedback("#inputRoom");
	});
	
	$("#problemDescription").focusout(function(){
		toggleFeedback("#problemDescription");
	});

	$("#inputSuperCode").focusout(function(){
		toggleFeedback("#inputSuperCode");
	});

	$("#inputSuperName").focusout(function(){
		toggleFeedback("#inputSuperName");
	});

	function toggleFeedback(id)
	{
		if($(id)[0].value.length > 0)
		{
			$(id).addClass("is-valid");
			$(id).removeClass("is-invalid");
		}
		else
		{
			$(id).removeClass("is-valid");
			$(id).addClass("is-invalid");
		}
	}

	//On ticket submit button click
	$(".create-ticket-form").submit( function() {
		event.preventDefault();

		//Make a post request to createTicket.php
		var getMachineName = $('#inputMachineName')[0].value;
		var getRoom = $('#inputRoom')[0].value;
		var description = $('#problemDescription')[0].value;
		var superCode = $('#inputSuperCode')[0].value;
		var superName = $('#inputSuperName')[0].value;
		var comment = $('#inputComments')[0].value;

		// Doing error checking for the values
		var submitReady = 	$("#inputMachineName")[0].value.length &&
							$("#inputRoom")[0].value.length &&
							$("#problemDescription")[0].value.length &&
							$("#inputSuperCode")[0].value.length &&
							$("#inputSuperName")[0].value.length;

		//Create the proper feedback
		toggleFeedback("#inputMachineName");
		toggleFeedback("#inputRoom");
		toggleFeedback("#problemDescription");
		toggleFeedback("#inputSuperCode");
		toggleFeedback("#inputSuperName");

		// If the form is not ready to submit, dont submit
		if(!submitReady)
		{
			setAlert("Please fill in all of the required information", "danger");
			return;
		}

		// Submitting the ticket
		$.get("./includes/DBinteractivity/createTicket.php", 
		{
			machine_name: escapeHtml(getMachineName),
			room: escapeHtml(getRoom),
			description: escapeHtml(description),
			super_code: escapeHtml(superCode),
			super_name: escapeHtml(superName),
			comments: escapeHtml(comment)

		}, function(data){

			data = JSON.parse(data);

			//Remove Feedback
			$('#inputMachineName').removeClass("is-valid");
			$('#inputRoom').removeClass("is-valid");
			$('#problemDescription').removeClass("is-valid");
			$('#inputSuperCode').removeClass("is-valid");
			$('#inputSuperName').removeClass("is-valid");

			$('#inputMachineName').removeClass("is-invalid");
			$('#inputRoom').removeClass("is-invalid");
			$('#problemDescription').removeClass("is-invalid");
			$('#inputSuperCode').removeClass("is-invalid");
			$('#inputSuperName').removeClass("is-invalid");

			//If the ticket creation was successful
			if(data['msg'] === "200 OK")
			{
				setAlert("Ticket successfully submitted", "success");
				
				// reset form
				$(".create-ticket-form")[0].reset();

				// Getting the email info ready
				var subject = "Confirmation of ticket #" +data['ticket_id']+ " submission";
				var body = `
					<p>Hello `+ name +`,</p>
					<br>
					<p>This is an automated email to confirm that you have submitted a ticket to the Queens Chemistry Repair Department.</p>
					<p>You can find information on this ticket by going to our website, selecting the "Tickets" tab at the top right, and viewing ticket #`+data['ticket_id']+`.</p>
					<p>To communicate with the technician in charge of your ticket, view your ticket and select "View forum" under the comments tab. Replies to this email will not be seen.</p>
					<p>Below you will find a summary of your ticket</p>
					<hr>
					<p>Machine Name: `+getMachineName+`</p>
					<p>Room: `+getRoom+`</p>
					<p>Problem Description: `+description+`</p>
					<p>Supervisor Code: `+superCode+`</p>
					<p>Supervisor Name: `+superName+`</p>
					<p>Other Comments: `+comment+`</p>
					<hr>
					<br>
					<p>Our technicians will get to work on your repair as soon as possible.</p>
					<p>If you have any questions, please contact ed.maracle@queensu.ca</p>
				`;
				
				// Send an email of confirmation
				$.get("./includes/DBinteractivity/sendEmail.php",
				{
					r: em,
					s: subject,
					b: body
				}, function(e){
					console.log(e);
				})
			}
			else
			{
				setAlert("Error with ticket creation. Please try again or contact us", "danger");
			}
		});
	})
});

function escapeHtml(text)
{
	return text
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#039;");
}

function setAlert(msg, type)
{
	var a = `
	<div class="alert alert-` + type + ` alert-dismissible fade show" role="alert">
		` + msg + `
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	`;

	$("#alertMarker")[0].innerHTML = a;
}

// Function that will log you out
function logout()
{
	document.cookie = "jwt=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	window.location.replace("index.php");
}

(function ($) {
	"use strict";


	/*==================================================================
	[ Focus input ]*/
	$('.input100').each(function () {
		$(this).on('blur', function () {
			if ($(this).val().trim() !== "") {
				$(this).addClass('has-val');
		} else {
				$(this).removeClass('has-val');
		}
		});    
	});
  
	$('#icon').on('keyup', function() {
	var input = $(this);
	if(input.val().length === 0) {
		input.addClass('empty');
	} else {
		input.removeClass('empty');
	}
});
	
  
	/*==================================================================
	[ Validate ]
	var input = $('.validate-input .input100');

	$('.validate-form').on('submit',function(){
		var check = true;

		for(var i=0; i<input.length; i++) {
			if(validate(input[i]) == false){
				showValidate(input[i]);
				check=false;
			}
		}

		return check;
	});


	$('.validate-form .input100').each(function(){
		$(this).focus(function(){
		   hideValidate(this);
		});
	});

	function validate (input) {
		if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
			if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
				return false;
			}
		}
		else {
			if($(input).val().trim() == ''){
				return false;
			}
		}
	}

	function showValidate(input) {
		var thisAlert = $(input).parent();

		$(thisAlert).addClass('alert-validate');
	}

	function hideValidate(input) {
		var thisAlert = $(input).parent();

		$(thisAlert).removeClass('alert-validate');
	}
	
	/*==================================================================
	[ Show pass ]
	var showPass = 0;
	$('.btn-show-pass').on('click', function(){
		if(showPass == 0) {
			$(this).next('input').attr('type','text');
			$(this).addClass('active');
			showPass = 1;
		}
		else {
			$(this).next('input').attr('type','password');
			$(this).removeClass('active');
			showPass = 0;
		}
		
	});
*/

});
