<!-- 
Tom Szendrey 
Feb - March 2019.
This will be used as the front end for a show tickets page. This will display search options to the user. 
This will also display a table full of everyone's tickets, or the tickets that have been searched.

-->
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Queen's Chemistry Department's Repair Ticketing System">
        <meta name="author" content="">
        <!-- <title>QU - Tickets Display</title>  -->
        <title>QU Chemistry Repair</title>

        <!--TODO Bootstrap core CSS-->
        <link rel="stylesheet" type="text/css" href="./public/bootstrap-4.0.0-dist/css/bootstrap.min.css"> 
        
        <!--Bootstrap core JavaScript-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="public/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>

        <!--TODO FontAwesome stylesheet(s)
        <link rel="stylesheet" href="public/font/fontawesome-5.7.1/css/all.css">
        <link rel="stylesheet" type="text/css" href="public/font/fontawesome-5.7.1/css/fontawesome.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        -->
       
        <link href="public/css/style.css" rel="stylesheet">
       
        <link href="./public/css/showTickets.css" rel="stylesheet">
        
        <!--Custom javascript-->
        <script src="./public/js/showTickets.js"></script>

        <link rel="shortcut icon" href="public/images/favicon.ico">

    </head>
<body>
<?php
		$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
		$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];
		
		include_once $path . '/includes/authenticate.php';

		// If user is authenticated, display headers
		if($auth){
            $page = "Tickets";
			// Display correct header
			if($isAdmin){
				include_once 'headerAdmin.php';
			}
			else{
				include_once 'headerUser.php';
			}
		}
		else{
			// Redirect to login page
			header('Location: login.html');
        }
	?>
<h1>All Tickets</h1>

<div class='TicketSearchMenu'>
    <form id='showTicketForm'>
        <input display='block' class="searchInput" type="number" id="getTicketID" placeholder="Ticket ID">
        <select display='block' class="searchInput" type="text" id="getMachineName" placeholder="Machine Name"> </select>
        <select display='block' class="searchInput" id="getRoom" placeholder="Room Name"> </select>
        <select display='block' class="searchInput" id="getStatus" placeholder="Status"> </select>
        <input display='block' class="searchInput" type="text" id="getCreated" placeholder="Created Date YYYY-MM-DD">
        <input display='block' class="searchInput" type="text" id="getClosed" placeholder="Closed Date YYYY-MM-DD">
        <?php
            if($isAdmin){
                //TODO: But you can fuck w this one @brandon
                echo "<select display='block' class='searchInput' id='getRequestedBy' placeholder='Requested By'> </select>";
            }
            else{
                //TODO: Just a reminder, if this select has a bootstrap class that sets display = block or something else, 
                //TODO: it will be shown for none users if you fuck with this line below @brandon
                echo "<select style=display:none class='searchInput' id='getRequestedBy' placeholder='Requested By'> </select>";
            }
        ?>
        <select class="searchInput" id="getAssignedTech" placeholder="Assigned Tech"> </select>
        <button class="btn btn-primary">Search</button>
    </form>
</div>

<!-- This form is used to submit the changes made by an admin 
    TODO: WHEN THIS IS PHP PLEASE ADD IF TO ADD/REMOVE <BUTTON> SUBMIT CHANGES </BUTTON>-->
<form class=TicketTableColumn id='saveTicketForm'>
    <!-- class='TicketTableColumn'  This is used as to fill in the table information on the loading of the page, and after the user clicks Search. -->
    <div id='TicketTable'></div>
    <button class="btn btn-secondary" onclick="leftArrowButtonDown()">&laquo; Last</button> 
    <button class="btn btn-secondary" onclick="rightArrowButtonDown()">Next &raquo;</button> <p id='tablePageMessage'></p>
    <input class=tableDimension id=tableHeight name=tableHeight type=hidden>
    <input id=fromRow type="hidden" value=0>
    <input id=totalRows type="hidden" value=100>
    <?php
        if($isAdmin){
            echo"<button class='btn btn-primary'>Submit Changes</button>";
        }
    ?>
</form>
</body>
    <?php
		// include_once 'footer.php';
	?>
</html>
