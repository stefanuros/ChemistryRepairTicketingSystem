// Stefan Urosevic
// Functionality for the messages page

$(document).ready(function() {

	var textarea = document.querySelector('#enter-message');
	(textarea.oninput = function() {
		if(textarea.scrollHeight < 106)
		{
			textarea.style.height = "38px";
			textarea.style.height = Math.max(38, textarea.scrollHeight) + 'px';
		}
	})();

	$("#enter-message").keydown(function(e) {
		var code = e.keyCode ? e.keyCode : e.which;
		if (code == 13 && !e.shiftKey) 
		{
			e.preventDefault();
			// alert("Enter Pressed");
			sendMsg();
		}
	});

	var objDiv = document.getElementById("msg-container");
	objDiv.scrollTop = objDiv.scrollHeight;
});

function sendMsg()
{
	// Get the message text
	var ta = $("#enter-message");
	var text = escapeHtml(ta[0].value);

	if(text.length <= 0)
	{
		return;
	}

	// Post request
	$.post("./includes/DBinteractivity/messageFunc.php",
	{
		ticket_id: ticket_id,
		msg: text
	}, function(name){
		
		// Reset the textarea
		ta[0].value = "";
		ta[0].style.height = "38px";
		ta[0].style.height = Math.max(38, ta[0].scrollHeight) + 'px';
		
		// Getting info for the new message
		var date = $.format.date(new Date(), 'MMM d, yyyy, h:mm a');
		
		// Make a new message
		$("#message-marker").before(`
			<div class="row m-0 p-1">
				<div class="col-12 p-0 m-0">
					<?php if(!$skipName) { ?>
						<div class="row p-0 m-0">
							<small class="col-4 p-0"></small>
							<small class="col-4 text-muted text-center p-0">`+ date +`</small>
							<small class="col-4 text-muted text-right p-0">`+ name +`</small>
						</div>
					<?php } ?>
					<div class="row p-0 m-0 justify-content-end">
						<div class="d-flex bg-success rounded m-0 py-1 px-2" style="max-width: 65%;">
							`+ text +`
						</div>
					</div>
				</div>
			</div>
		`);

		var objDiv = document.getElementById("msg-container");
		objDiv.scrollTop = objDiv.scrollHeight;
	});
}

function escapeHtml(text)
{
	return text
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#039;");
}

// Function for displaying the invoice from the link
function invoiceLink(url)
{
	window.open(decodeURI(url), '_blank');
}
