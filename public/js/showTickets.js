/*
Tom Szendrey
Feb - March 2019
This will be used as the JS for a show tickets page. This will show all tickets by default on the page's load.
This will grab the table given from showTickets.php and send it to the paragraph holder in showTickets.html
*/

//Function called at the loading of showTicket.html
//Returns a "show all" table to display

$(document).ready(function(){  
	$.post("./includes/DBinteractivity/showTickets.php",{}, 
	// data = echo in showtickets.php
	function(data){
		var temp = JSON.parse(data);
		document.getElementById('TicketTable').innerHTML = temp["tableInfo"];
		document.getElementById('getRoom').innerHTML = temp["roomOptions"];
		document.getElementById('getMachineName').innerHTML = temp["machineOptions"];
		document.getElementById('getStatus').innerHTML = temp["statusOptions"];
		document.getElementById('getRequestedBy').innerHTML = temp["requestedByOptions"];
		document.getElementById('getAssignedTech').innerHTML = temp["assignedTechOptions"];
		document.getElementById('tableHeight').value = temp['tableHeight']
		document.getElementById('tablePageMessageTop').innerHTML = temp['tablePageMessage'];
		document.getElementById('tablePageMessageBottom').innerHTML = temp['tablePageMessage'];
		document.getElementById('totalRows').value = temp['totalRows'];
		// console.log(temp["testOutput"]);
	});//end $.post    
	/* ---On Submit Table Right Arrow------------------------------------------------------------------------------------------------------------------------------ */
	
	/* ---On Submit Search Button---------------------------------------------------------------------------------------------------------------------------------- */
	$("#showTicketForm").submit( function() {
		//Note to self: You cannot use the following as it will not allow you to correctly load or refresh the page. document.getElementById("showTicketForm").submit( function(){
		event.preventDefault(); //prevents refresh page event.
		//var get all the SQL Search terms.
		var getTicketID = $('#getTicketID')[0].value;
		var getMachineName = $('#getMachineName')[0].value;
		var getRoom = $('#getRoom')[0].value;
		var getStatus = $('#getStatus')[0].value;
		var getCreated = $('#getCreated')[0].value;
		var getClosed = $("#getClosed")[0].value;
		var getRequestedBy = $("#getRequestedBy")[0].value;
		var getAssignedTech = $("#getAssignedTech")[0].value;
		
		$.post("./includes/DBinteractivity/showTickets.php",{
			ticketID: getTicketID,
			machineName: getMachineName,
			room: getRoom,
			status: getStatus,
			createdBy: getCreated,
			closedBy: getClosed,
			requestedBy: getRequestedBy,
			assignedTech: getAssignedTech
		}, 
		//data = echo in showtickets.php
		function(data){
			//throw all the given information into a <div></div> (creating a table with all the requested information)
			var temp = JSON.parse(data);
			document.getElementById('TicketTable').innerHTML = temp["tableInfo"];
			document.getElementById('tableHeight').value = temp['tableHeight'];
			document.getElementById('tablePageMessageTop').innerHTML = temp['tablePageMessage'];
			document.getElementById('tablePageMessageBottom').innerHTML = temp['tablePageMessage'];
			document.getElementById('totalRows').value = temp['totalRows'];
			// console.log(temp["testOutput"]);
		});//end $.post
	});//end showTicketForm lambda function.

	/* ---On Submit Changes Button---------------------------------------------------------------------------------------------------------------------------------- */
	$("#saveTicketForm").submit( function() {
		//Note to self: You cannot use the following as it will not allow you to correctly load or refresh the page. document.getElementById("showTicketForm").submit( function(){
		event.preventDefault(); //prevents refresh page event.
		var formdata = $(this).serialize();

		$.post("./includes/DBinteractivity/saveTicketInfo.php",{
			input: formdata
		}, 
		//data = echo in saveTicketInfo.php
		function(data){
			sendToEmailer(data);

			if(data.length > 0)
			{
				setAlert("Saving date. Please wait...", "warning");
			}
			else
			{
				setAlert("Data saved.", "success");
			}

		});//end $.post
		// location.reload(); 
	});//end showTicketForm lambda function.
}); //end $(document).ready(function(){}); 

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

/* ---On Submit Table right Arrow------------------------------------------------------------------------------------------------------------------------------- */
function rightArrowButtonDown(){
	event.preventDefault(); //prevent refresh page.
	var getFromRow = parseInt(document.getElementById('fromRow').value);
	var getRowStep = 10; //If this hardcoded value changes. Also change it in showTickets.php .... I know im a horrible person.
	var rowLimit = parseInt(document.getElementById('totalRows').value);
	var getTicketID = $('#getTicketID')[0].value;
	var getMachineName = $('#getMachineName')[0].value;
	var getRoom = $('#getRoom')[0].value;
	var getStatus = $('#getStatus')[0].value;
	var getCreated = $('#getCreated')[0].value;
	var getClosed = $("#getClosed")[0].value;
	var getRequestedBy = $("#getRequestedBy")[0].value;
	var getAssignedTech = $("#getAssignedTech")[0].value;
	if (getFromRow + getRowStep <= rowLimit){
		getFromRow = getFromRow + getRowStep;
	}
	$.post("./includes/DBinteractivity/showTickets.php",{
		fromRow: getFromRow,
		rowStep: getRowStep,
		ticketID: getTicketID,
		machineName: getMachineName,
		room: getRoom,
		status: getStatus,
		createdBy: getCreated,
		closedBy: getClosed,
		requestedBy: getRequestedBy,
		assignedTech: getAssignedTech
	},
	//data = echo in showtickets.php
	function(data){
		//throw all the given information into a <div></div> (creating a table with all the requested information)
		var temp = JSON.parse(data);
		document.getElementById('fromRow').value = temp['fromRow'];
		document.getElementById('TicketTable').innerHTML = temp["tableInfo"];
		document.getElementById('tableHeight').value = temp['tableHeight'];
		document.getElementById('tablePageMessageTop').innerHTML = temp['tablePageMessage'];
		document.getElementById('tablePageMessageBottom').innerHTML = temp['tablePageMessage'];
	});//end $.post
}//end rightArrowButtonDown


/* ---On Submit Table Left Arrow------------------------------------------------------------------------------------------------------------------------------- */
function leftArrowButtonDown(){
	event.preventDefault(); //prevent refresh page.
	var getFromRow = parseInt(document.getElementById('fromRow').value);
	var getRowStep = 10; //If this hardcoded value changes. Also change it in showTickets.php .... I know im a horrible person.
	if (getFromRow >= getRowStep){
		getFromRow = getFromRow - getRowStep;
	}
	$.post("./includes/DBinteractivity/showTickets.php",{
		fromRow: getFromRow,
		rowStep: getRowStep
	},
	//data = echo in showtickets.php
	function(data){
		//throw all the given information into a <div></div> (creating a table with all the requested information)
		var temp = JSON.parse(data);
		document.getElementById('fromRow').value = temp['fromRow'];
		document.getElementById('TicketTable').innerHTML = temp["tableInfo"];
		document.getElementById('tableHeight').value = temp['tableHeight'];
		document.getElementById('tablePageMessageTop').innerHTML = temp['tablePageMessage'];
		document.getElementById('tablePageMessageBottom').innerHTML = temp['tablePageMessage'];
	});//end $.post
}//end leftArrowButtonDown


function logout()
{
	document.cookie = "jwt=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	window.location.replace("index.php");
}


/*
grabs the data in an array, or potentially a lot lof arrays. 
emailData = {} OR {}{}{}{}...
make it {}\n{}\n{}.....
split based off of \n into multiple arrays
for each single array, JSON.parse that from a string = {r: user's email INFO, s: subject INFO, b: body INFO} to 
an with index's r,s,b.
use Stef's sendEmail.php with said information.
*/
function sendToEmailer(emailData){
	const subst = '}\n{';
	const str = emailData;
	const regex = /}{/gm;
	const result = str.replace(regex, subst);
	// console.log("-" + (result.length > 0) + "-");

	if(result.length == 0)
	{
		return;
	}

	var parsedData = result.split('\n');
	var count = 0;

	for (var i = 0; i < parsedData.length; i++){
		singleEmailData = parsedData[i];
		// console.log(singleEmailData);
		var singleParsedData = JSON.parse(singleEmailData); 
		// console.log(singleParsedData);

		$.get("./includes/DBinteractivity/sendEmail.php",{
			r: singleParsedData['r'], 
			s: singleParsedData['s'],
			b: singleParsedData['b']
		}, function(){
			count++;
			if(count >= parsedData.length){
				location.reload();
				return true;
			}
		});
	}//end for

	// location.reload();
}//end sendToEmailer
