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
			console.log(data); //TODO Remove this eventually
			//If the login was successful
			if(data['msg'] === "200 OK")
			{	
				//Check if the user is an admin or not
				if(data['isAdmin'])
				{
					//If the user is an admin
				}
				else
				{
					//If the user is not an admin
				}
			}
			else
			{
				//Give error feedback to user here since login was not successful
			}
		});
	}); 
});



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
