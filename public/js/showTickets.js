/*
Tom Szendrey
Feb - March 2019
This will be used as the JS for a show tickets page. This will show all tickets by default on the page's load.
This will grab the table given from showTickets.php and send it to the paragraph holder in showTickets.html
*/

//Function called at the loading of showTicket.html
//Returns a "show all" table to display
//TODO: Refresh after submit.

$(document).ready(function(){  
    $.post("./includes/DBinteractivity/showTickets.php",{}, 
    // data = echo in showtickets.php
    function(data){
        // throw all the given information into a <div></div> (creating a table with all the requested information)
        
        // console.log(data);
        var temp = jQuery.parseJSON(data);
        document.getElementById('TicketTable').innerHTML = temp["tableInfo"];
        document.getElementById('getRoom').innerHTML = temp["roomOptions"];
        document.getElementById('getMachineName').innerHTML = temp["machineOptions"];
        document.getElementById('getStatus').innerHTML = temp["statusOptions"];
        document.getElementById('getRequestedBy').innerHTML = temp["requestedByOptions"];
        document.getElementById('getAssignedTech').innerHTML = temp["assignedTechOptions"];
        document.getElementById('tableHeight').value = temp['tableHeight'];
        document.getElementById('colCount').value = temp['colCount'];
        console.log(temp["testOutput"]);
    });//end $.post

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
            var temp = jQuery.parseJSON(data);
            document.getElementById('TicketTable').innerHTML = temp["tableInfo"];
            document.getElementById('getRoom').innerHTML = temp["roomOptions"];
            document.getElementById('getMachineName').innerHTML = temp["machineOptions"];
            document.getElementById('getStatus').innerHTML = temp["statusOptions"];
            document.getElementById('getRequestedBy').innerHTML = temp["requestedByOptions"];
            document.getElementById('getAssignedTech').innerHTML = temp["assignedTechOptions"];
            document.getElementById('tableHeight').value = temp['tableHeight'];
            document.getElementById('colCount').value = temp['colCount'];
            console.log(temp["testOutput"]);
        });//end $.post
    });//end showTicketForm lambda function.

    /* ---On Submit Changes Button---------------------------------------------------------------------------------------------------------------------------------- */
    $("#saveTicketForm").submit( function() {
        //Note to self: You cannot use the following as it will not allow you to correctly load or refresh the page. document.getElementById("showTicketForm").submit( function(){
        event.preventDefault(); //prevents refresh page event.
        var formdata = $(this).serialize();
        
        $.post("./includes/DBinteractivity/saveTicketInfo.php",{
            data: formdata
        }, 
        //data = echo in saveTicketInfo.php
        function(data){
            console.log(data);
        });//end $.post
        window.refresh(); //TODO FIX
    });//end showTicketForm lambda function.
}); //end $(document).ready(function(){}); 
