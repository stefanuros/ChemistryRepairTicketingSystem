<!-- Created on January 28th, 2019. --> 
<!-- Written by: Tiffany C. -->
<!-- header for User file to include in other php files -->

    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-dark" id="mainNav">
            
        <a class="navbar-brand" href="myTickets.html">
            <img src="public/images/ChemistryRepairTicketLogo.png" alt="Queen's Department of Chemistry Logo" alt="logo" height="115" width="280">
        </a>
        
        <div class="row">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            </div>
       

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <!--change the href's to corresponding pages-->
                    <a class="nav-link" href="myTickets.html">Tickets</a>
                </li>
            <li class="nav-item">
                <a class="nav-link" href="createTicket.html">Create Ticket</a>
                </li>
            <li class="nav-item">
                <a class="nav-link" href="howTo.php">How To</a>
                </li>
                <li class="nav-item">
                    <input class="nav-link" id="button" type="button" onclick='logout();' value='Logout'/>
                </li>
            </ul>
        </div>
    </nav>