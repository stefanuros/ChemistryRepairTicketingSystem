/*
Tom Szendrey
Feb - March 2019
This will be used as the JS for a show tickets page. This will show all tickets by default on the page's load.
This will grab the table given from showTickets.php and send it to the paragraph holder in showTickets.html
*/

//Function called at the loading of showTicket.html
//Returns a "show all" table to display
//TODO: Also have it set the drop down menu options.
$(document).ready(function(){  
    $.post("./includes/DBinteractivity/showTickets.php",{}, 
    //data = echo in showtickets.php
    function(data){
        //throw all the given information into a <p></p> (creating a table with all the requested information)
        document.getElementById('TicketTable').innerHTML = data;
    });//end $.post
}) 


//Function called by the showTicket.html button on the search form
//Returns table information.
$(document).ready(function() {
    //On submit Search Button.
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
			machineName: getMachineName
        }, 
        //data = echo in showtickets.php
        function(data){
			//throw all the given information into a <p></p> (creating a table with all the requested information)
			document.getElementById('TicketTable').innerHTML = data;
        });//end $.post
    });//end lambda function.
});//End $(document)


