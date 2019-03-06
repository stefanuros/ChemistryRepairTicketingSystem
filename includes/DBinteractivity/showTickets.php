<?php
/* 
Tom Szendrey
Feb - March 2019
This will be used for the database access for showTickets.html. 
On a search submit button this will create a SQL select statement based off of the search criteria and send that table to showTickets.js
*/

//TODO: Fix the requested_by and assigned_tech sections. They need to use a different table. (This is for drop down + for table info.)

/* Just for organizational purposes. */
function main(){
    include_once '../config.php';
    include_once '../connect.php';
    //include_once '../authenticate.php';

    //if (!$auth){
    //    echo $jsonMsg;
    //    exit();
    //}
    $roomOptions = getOptions($conn,'room', 'Rooms');
    $machineName = getOptions($conn, 'machine_name', 'Machines');
    $statusOptions = getOptions($conn, 'status', 'Status');
    $requestedByOptions = getOptions($conn, 'requested_by', 'Requested By');
    $assignedTechOptions = getOptions($conn, 'assigned_tech', 'Tech');
    $testOutput = "";
    $isAdmin = true; //TODO: for testing purposes. I believe this information will be taken fron authenticate?

    $tableInfo =  "
        <table class=ticketTable>
        <th class='ticketHeader'>Ticket ID</th>
        <th class='ticketHeader'>Machine Name</th>
        <th class='ticketHeader'>Room</th>
        <th class='ticketHeader'>Status</th>
        <th class='ticketHeader'>comments</th>
        <th class='ticketHeader'>Created</th>
        <th class='ticketHeader'>Closed</th>
        <th class='ticketHeader'>Requested By</th>
        <th class='ticketHeader'>Assigned Tech</th>
    ";
    //Create the SQL select.
    $sqlWhereSet = false; //Is set to true when the first "where" in the select to ensure theres only 1.
    $sql = "select * from `Tickets`"; 
    //Add all the required search fields to $sql
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'ticketID','ticket_id');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'machineName','machine_name');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'room','room');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'status','status');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'createdBy','created_time');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'closedBy','closed_time');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'requestedBy','requested_by');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'assignedTech','assigned_tech');
    $sql = $sql . " order by `Ticket_ID`;";

    //fill the table with ALL information.
    $testOutput = $testOutput .  $sql;

    $sqlPrepared = $conn->prepare($sql);
    if(!$sqlPrepared->execute()) {
        echo('Error The command could not be executed, and the information could not be read.');
        exit();
    }
    $height = 1;
    //initialize i. Normally i wouldnt have to do this here, but in the case that the user searches something with no results 
    //$i still needs to be initalized to tell <p id=colCount> how many columns there are
    $i = 0; 
    //While there are rows left in the SQL
    while($row = $sqlPrepared->fetch(PDO::FETCH_ASSOC)) {
        $tableInfo = $tableInfo . "<tr>";
        $i = 0;
            foreach($row as $value) {
                //Admin can change the values for Status, Assigned Tech
                if ($isAdmin == true && $i == 8){
                    $tableInfo = $tableInfo . 
                    "<td class='ticketCell'>
                        <input type='text' value='$value' name='value" . $i . "a" .  $height . "'>
                    </td>";
                }
                //Admin can change the value for closed using a drop box, if closed == null
                elseif ($isAdmin == true && $i == 3 && $value != 'Closed'){
                    if($value == 'Unassigned'){
                        $tableInfo = $tableInfo .
                        "<td class='ticketCell'><select name='value" . $i . "a" .  $height . "'>
                            <option value='Unassigned'>Unassigned</option>
                            <option value='In Progress'>In Progress</option>
                            <option value='Closed'>Closed</option>
                        </select></td>";
                    }
                    elseif($value == 'In Progress'){
                        $tableInfo = $tableInfo .
                        "<td class='ticketCell'><select name='value" . $i . "a" .  $height . "'>
                            <option value='In Progress'>In Progress</option>
                            <option value='Unassigned'>Unassigned</option>
                            <option value='Closed'>Closed</option>
                        </select></td>";
                    }
                    else{ //TODO: Ask everyone if this is how they want the backend error to be handled.
                        $tableInfo = $tableInfo . 
                        "<td class='ticketCell'><select name='value" . $i . "a" .  $height . "'>
                            <option value='$value'>$value Please choose one of the below options</option>
                            <option value='Unassigned'>Unassigned</option>
                            <option value='In Progress'>In Progress</option>
                            <option value='Closed'>Closed</option>
                        </select></td>";
                    }//end else
                }//end elseif admin, status, 'closed'

                //Else: The column cannot be edited. It should display a value and have a hidden input of the value aswell so 
                //      The information can be used in a $_POST for saving changes.
                else{
                    $tableInfo = $tableInfo . "<td class='ticketCell'>$value ";
                    $tableInfo = $tableInfo . "<input type=hidden name='value" . $i . "a" .  $height . "' value=$value></td>";
                }//end isAdmin, editable column
                $i = $i + 1;
            }//end foreach
            $height = $height + 1;
            $tableInfo = $tableInfo . "</tr>";
    }//End While (There is a row to fetch)
    
    $tableHeightOutput = $height;
    $colCountOutput = $i;

    $tableInfo = $tableInfo . "</table>";
    //create a table
    echo json_encode(
        array(
            "tableInfo" => $tableInfo,
            "roomOptions" => $roomOptions,
            "machineOptions" => $machineName,
            "statusOptions" => $statusOptions,
            "requestedByOptions" => $requestedByOptions,
            "assignedTechOptions" => $assignedTechOptions,
            "tableHeight" => $tableHeightOutput,
            "colCount" => $colCountOutput,
            "testOutput" => $testOutput
        )
    );
}//end Main


/*---Helper Functions Found Below--------------------------------------------------------------------------------------------------------------------------------- */
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------- */


/* 
Used to set up the drop down menus on the front page. 
$attributeName being the same as before, it is the name of the attribute in tickets. ('room', 'machine_name' ect. See database for these names.)
$nullMessage being the message of a null search. The first option the user will see which corresponds to a null value. (Search by Rooms, or Rooms, 
                                                                                                                or whatever you want the user to see)
Returns $givenOption. This being a string containing html for a single drop down menu.
*/
function getOptions($conn,$attributeName,$nullMessage){
    $givenOption = "<option value=''>$nullMessage</option>";
    //select all drop down menu options.
    //,`Status`,`Created_time`,`Closed_time`,`requested_by`,`assigned_tech`
    $sqlRoom = "SELECT DISTINCT `$attributeName` FROM `tickets`;";
    $sqlRoomPrep = $conn->prepare($sqlRoom);
    if(!$sqlRoomPrep->execute()) {
        echo('Error: The command could not be executed, and the information could not be read.');
        exit();
    }
    $height = 1;
    //While there are rows left in the SQL
    while($row = $sqlRoomPrep->fetch(PDO::FETCH_NUM)) {
        $givenOption = $givenOption . "<option value="  . $row[0] . ">" . $row[0] . " </option>";
    }//end while
    return $givenOption;
}//end setOption

/*
Helper function because I couldnt think of a faster/neater way
This is used to add search information to the sql string. 
postName: the name of a post value. EG $postname = ticketID means $_POST['ticketID']
attributeName: The name of an attribute in the SQL Table. EG 'ticket_id'
*/
function appendSearchInfo($sql,$sqlWhereSet,$postName,$attributeName){
    if (isset($_POST[$postName]) && $_POST[$postName] != null){
        if ($sqlWhereSet == false){
            $sqlWhereSet = true;
            //TODO: I think i need to use like, just so date created/closed dont have to give the hh:mm:ss
            $sql = $sql . " where `$attributeName` LIKE '" . $_POST[$postName] . "'"; 
        }
        else{
            //TODO: I think i need to use like, just so date created/closed dont have to give the hh:mm:ss
            $sql = $sql . " and `$attributeName` LIKE '" . $_POST[$postName] . "'";
        }
    }
    return array($sql,$sqlWhereSet);
}//end appendSearchInfo

main();

?>