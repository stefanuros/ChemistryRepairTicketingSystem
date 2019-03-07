<?php
/*
Created By: Tom Szendrey
March 2019
This will be called by showTickets.js and be used to save the information in a displayed table (on showTickets.html)
to the database.
*/


//TODO: Due to timezone? difference, date(Y-m-d h:m:sa) is giving a time thats off by 6 hours.

/* for orginizational purposes. */

function main(){
    include_once '../config.php';
    include_once '../connect.php';
    //include_once '../authenticate.php';

    //if (!$auth){
    //    echo $jsonMsg;
    //    exit();
    //}

    date_default_timezone_set('America/Toronto');
    echo date('Y-m-d h:m:s');

    //parse the POST data.
    parse_str($_POST['data'],$output);
    //print_r($output); //TODO: Remove. Used for testing purposes.

    for ($i = 1; $i < $output['tableHeight']; $i++){
        //get the row's ticketID, the oldStatus (before change/in database) and newStatus (what is on the current page.)
        $ticketID = $output['value0a' . $i];
        $newStatus = $output['value3a' . $i];
        $techRef = $output['value8a' . $i];
        $sqlSelect = "SELECT `status` from `tickets` where ticket_id = $ticketID;";
        $sqlPrep = $conn->query($sqlSelect);
        if(!$sqlPrep->execute()) {
            echo('Error: The command could not be executed, and the information could not be read.');
            exit();
        }
        $oldStatusFetch = $sqlPrep->fetch(PDO::FETCH_NUM);
        $oldStatus = $oldStatusFetch[0];
        //If the user has just closed a ticket, update the closed_time aswell as the status.
        //TODO: $sqlUpdate = "UPDATE `tickets` set `assigned_tech` = '" . $techRef . "', `status` = '" . $newStatus . "'";
        if($oldStatus != 'Closed' && $newStatus == 'Closed'){
            $sqlUpdate = "UPDATE `tickets` set `status` = '" . $newStatus . "', `closed_time` = '" . date("Y-m-d h:i:s") . "' where `ticket_id` = " . $ticketID . ";";
            //TODO: $sqlUpdate = $sqlUpdate . ", `closed_time` = '" . date("Y-m-d h:i:s") . "' where `ticket_id` = " . $ticketID . ";";
        }
        //Otherwise only update the status.
        else{
            $sqlUpdate = "UPDATE `tickets` set `status` = '" . $newStatus . "' where `ticket_id` = " . $ticketID . ";";
            //TODO: $sqlUpdate = $sqlUpdate .  " where `ticket_id` = " . $ticketID . ";";
        }
        echo $sqlUpdate;
        try{
            $sqlResult = $conn->query($sqlUpdate);
            echo "  Updated     ";
        }catch(PDOException $e){
            echo $e;
        }
    }//end i,tableHeight
}//end main
main();
?>