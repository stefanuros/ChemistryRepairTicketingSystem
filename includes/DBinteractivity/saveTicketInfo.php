<?php
/*
Created By: Tom Szendrey
March 2019
This will be called by showTickets.js and be used to save the information in a displayed table (on showTickets.html)
to the database.
*/

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

    //parse the POST data.
    parse_str($_POST['data'],$output);

    //Updates Ticket table with new information.
    for ($i = 1; $i < $output['tableHeight']; $i++){
        //get the row's ticketID, the oldStatus (before change/in database) and newStatus (what is on the current page.)
        $ticketID = $output['value0a' . $i];
        $newStatus = $output['value3a' . $i];
        if ($output['value9a' . $i] != ''){
            $techRef = getRefNumber($conn,$output['value9a' . $i]);
        }
        else{
            $techRef = '';
        }
        $sqlSelect = "SELECT `status` from `tickets` where ticket_id = $ticketID;";
        $sqlPrep = $conn->query($sqlSelect);
        if(!$sqlPrep->execute()) {
            echo('Error: The command could not be executed, and the information could not be read.');
            exit();
        }
        $oldStatusFetch = $sqlPrep->fetch(PDO::FETCH_NUM);
        $oldStatus = $oldStatusFetch[0];
        //If the user has just closed a ticket, update the closed_time aswell as the status.
        echo "----------- Row: $i Ticket: $ticketID assigned_tech: $techRef ---------";
        if($oldStatus != 'Closed' && $newStatus == 'Closed'){
            $sqlUpdate = "UPDATE `tickets` set `status` = '" . $newStatus . "', `closed_time` = '" . date("Y-m-d h:i:s") . "', assigned_tech = '$techRef' where `ticket_id` = " . $ticketID . ";";
        }
        //Otherwise only update the status.
        else{
            $sqlUpdate = "UPDATE `tickets` set `status` = '" . $newStatus . "', assigned_tech = '$techRef' where `ticket_id` = " . $ticketID . ";";
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

/* Helper function, used to turn a username into a reference number. This will help organize when updating assigned_tech
inputs: $username: the username given, this will be the username in the table profile.
outputs: $refNumber: reference number. This will be the unique_id in profile, or the requested_by/assigned_tech for tickets.
*/
function getRefNumber($conn,$username){
    $sql = "SELECT DISTINCT unique_id FROM `profile` WHERE `username` = '" . $username . "';";
    $sqlPrepared = $conn->prepare($sql);
    if(!$sqlPrepared->execute()){
        echo "The given username: $username 's unique id could not be found.";
        $refNumber = '';
    }
    $row = $sqlPrepared->fetch(PDO::FETCH_NUM);
    $refNumber = $row[0];
    return $refNumber;
}

main();
?>