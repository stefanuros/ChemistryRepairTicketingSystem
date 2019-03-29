<?php
/* 
Tom Szendrey
Feb - March 2019
This will be used for the database access for showTickets.html. 
On a search submit button this will create a SQL select statement based off of the search criteria and send that table to showTickets.js
*/


/* 
The following array is used in showTickets.js (as it is the echo of this file).
array(
    "tableInfo" => $tableInfo, //Used to write all of the table information.
    "roomOptions" => $roomOptions, //Used for drop down options
    "machineOptions" => $machineName,  //Used for drop down options
    "statusOptions" => $statusOptions, //Used for drop down options
    "requestedByOptions" => $requestedByOptions, //Used for drop down options
    "assignedTechOptions" => $assignedTechOptions, //Used for drop down options
    "tableHeight" => $tableHeightOutput, //Thrown into a hidden int on the front page, which will be later used in the saveTickets.php file.
    "testOutput" => $testOutput //Used for console.log();
)

*/
function main(){
    include_once '../config.php';
    include_once '../connect.php';
    include_once '../authenticate.php';

    $roomOptions = getOptions($conn,'room', 'Rooms');
    $machineName = getOptions($conn, 'machine_name', 'Machines');
    $statusOptions = getOptions($conn, 'status', 'Status');
    $requestedByOptions = getOptions($conn, 'requested_by', 'Requested By');
    $assignedTechOptions = getOptions($conn, 'assigned_tech', 'Assigned Tech');
    $listOfAdmins = getAdmins($conn);
    $testOutput = "";
    if (isset($_POST['fromRow']) && $_POST['fromRow'] != null){
        $fromRow = $_POST['fromRow'];
    }
    else{
        $fromRow = 0;
    }
    $rowStep = 10;

    $totalRows = getTotalRows($conn,$isAdmin,$uid);
    $tablePageMessage = "Showing: " . $fromRow . " to " . ($fromRow + $rowStep) . " out of: " . $totalRows;

    $tableInfo = getTableheader($isAdmin);
    $sql = getSQLQuery($isAdmin,$fromRow, $rowStep,$uid);
    
    //fill the table with ALL information.
    $sqlPrepared = $conn->prepare($sql);
    $sqlPrepared->execute(); //should be in a try/catch, but in this scenario it isnt required.
    $height = 1;
    $i = 0; //initialize i. Normally i wouldnt have to do this here, but in the case that the user searches something with no results $i still needs to be initalized to tell <p id=colCount> how many columns there are
    //While there are rows left in the SQL
    while($row = $sqlPrepared->fetch(PDO::FETCH_NUM)) {
        $tableInfo = $tableInfo . "<tr>";
        $i = 0;
        for ($j = 0; $j < sizeof($row); $j++){
            $value = $row[$j];
            $ticketid = $row[0];
            //Set two classes for even/odd rows because IM AN IDIOT AND DIDNT GOOGLE CSS HAS THIS BUILT IN (to show different background colours on rows)
            if ($height % 2 == 0){
                if($i == 4){//TODO: Fill in link. Make sure GET Sends.
                    $tableInfo = $tableInfo . "<td class='ticketCommentCellEven'> <a id=forumLink class='nav-link' href='./messagePage.php?ticket_id=$ticketid'>Click To See Forum </a>";
                }
                else{
                    $tableInfo = $tableInfo . "<td class='ticketCellEven'>";
                }
            }
            else{
                if($i == 4){//TODO: Fill in link. Make sure GET Sends.
                    $tableInfo = $tableInfo . "<td class='ticketCommentCellOdd'> <a id=forumLink class='nav-link' href='./messagePage.php?ticket_id=$ticketid'>Click To See Forum </a>";
                }
                else{
                    $tableInfo = $tableInfo . "<td class='ticketCellOdd'>";
                }
            }
            //Admin can change the values for Status, Assigned Tech
            if ($isAdmin == true && $i == 11){ 
                $tableInfo = $tableInfo . 
                "
                    <select class='ticketInput' type='text' name='value" . $i . "a" .  $height . "'>
                    <option value='$value'>$value</option>
                    $listOfAdmins 
                    </select>
                </td>";
            }
            //Admin can change the value for closed using a drop box, if closed == null
            elseif ($isAdmin == true && $i == 3 && $value != 'Closed'){
                if($value == 'Unassigned'){
                    $tableInfo = $tableInfo .
                    "<select name='value" . $i . "a" .  $height . "'>
                        <option value='Unassigned'>Unassigned</option>
                        <option value='In Progress'>In Progress</option>
                        <option value='Closed'>Closed</option>
                    </select></td>";
                }
                elseif($value == 'In Progress'){
                    $tableInfo = $tableInfo .
                    "<select name='value" . $i . "a" .  $height . "'>
                        <option value='In Progress'>In Progress</option>
                        <option value='Unassigned'>Unassigned</option>
                        <option value='Closed'>Closed</option>
                    </select></td>";
                }
                else{ 
                    $tableInfo = $tableInfo . 
                    "<select name='value" . $i . "a" .  $height . "'>
                        <option value='$value'>Your Value:$value Please choose one of the below options</option>
                        <option value='Unassigned'>Unassigned</option>
                        <option value='In Progress'>In Progress</option>
                        <option value='Closed'>Closed</option>
                    </select></td>";
                }//end else
            }//end elseif admin, status, 'closed'
            elseif($isAdmin == true && $i == 12){ //invoice link
                $tableInfo = $tableInfo . "<input type=hidden name='value" . $i . "a" .  $height . "' value=$value>
                                        <a id=invoiceLink class=nav-link href='./invoicePage.php?ticket_id=$ticketid'>Invoice</a> </td>";
            }
            
            //Else: The column cannot be edited. It should display a value and have a hidden input of the value aswell so 
            //      The information can be used in a $_POST for saving changes.
            else{
                $tableInfo = $tableInfo . "$value ";
                $tableInfo = $tableInfo . "<input type=hidden name='value" . $i . "a" .  $height . "' value=$value></td>";
            }//end isAdmin, editable column
            $i = $i + 1;
        }//end fore loop
            $height = $height + 1;
            $tableInfo = $tableInfo . "</tr>";
    }//End While (There is a row to fetch)
    
    $tableInfo = $tableInfo . "</table>";
    $tableHeightOutput = $height;
    $colCountOutput = $i;

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
            "fromRow" => $fromRow,
            "tablePageMessage" => $tablePageMessage,
            "totalRows" => $totalRows,
            "testOutput" => $testOutput
        )
    );
}//end Main


/*---Helper Functions Found Below--------------------------------------------------------------------------------------------------------------------------------- */
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------- */
//returns the total amount of Rows in tickets table.
function getTotalRows($conn,$isAdmin,$uid){
    if($isadmin){
        $sql = "select count(ticket_id) from tickets;";
    }
    else{
        $sql = "select count(ticket_id) from tickets where requested_by = '$uid';";
    }
    $sqlGetTotalRows = $conn->prepare($sql);
    if(!$sqlGetTotalRows->execute()) {
        echo('Error: The command could not be executed, and the information could not be read.');
        exit();
    }
    $totalRows = $sqlGetTotalRows->fetch(PDO::FETCH_NUM);
    return $totalRows[0];
}

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
    
    if ($attributeName == 'requested_by'){ //`requested_by`
        $sqlRoom = "SELECT DISTINCT username FROM `profile`;";
    }
    elseif ($attributeName == 'assigned_tech'){ //`assigned_tech`
        $sqlRoom = "SELECT DISTINCT username FROM `profile`;";
    }
    else{ //`Status`,`Created_time`,`Closed_time`
        $sqlRoom = "SELECT DISTINCT `$attributeName` FROM `tickets`;";
    }
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
            if ($attributeName == 'created_time' || $attributeName == 'closed_time'){
                //As its generalized it will search for a LIKE VALUE% as this allows the user to write YYYY-mm-dd and not add the hh:mm:ss
                $sql = $sql . " where `$attributeName` LIKE '" . $_POST[$postName] . "%'";
            }
            elseif ($attributeName == 'requested_by'){
                $sql = $sql . " where userP.username = '" . $_POST[$postName] . "'";
            }
            elseif ($attributeName == 'assigned_tech'){
                $sql = $sql . " where techP.username = '" . $_POST[$postName] . "'";
            }
            else{
                $sql = $sql . " where `$attributeName` = '" . $_POST[$postName] . "'"; 
            }
        }//end if ($sqlWhereSet == true)
        else{
            if ($attributeName == 'created_time' || $attributeName == 'closed_time'){
                //As its generalized it will search for a LIKE VALUE% as this allows the user to write YYYY-mm-dd and not add the hh:mm:ss
                $sql = $sql . " and `$attributeName` = '" . $_POST[$postName] . "%'";
            }//end if date format
            elseif ($attributeName == 'requested_by'){
                $sql = $sql . " and userP.username = '" . $_POST[$postName] . "'";
            }
            elseif ($attributeName == 'assigned_tech'){
                $sql = $sql . " and techP.username = '" . $_POST[$postName] . "'";
            }
            else{
                $sql = $sql . " and `$attributeName` = '" . $_POST[$postName] . "'";
            }//end else date format
        }//end else (sqlWhereSet == True)
    }//end if the POST is set and not null.
    return array($sql,$sqlWhereSet);
}//end appendSearchInfo

/* */
function getAdmins($conn){
    $sqlRoom = "SELECT DISTINCT `username` FROM `profile` where admin=1;";
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
}//end getAdmins

function getTableHeader($isAdmin){
    if($isAdmin){
        $tableHeader =  "
            <table class='ticketTable table table-striped table-dark table-bordered' >
            <th class='ticketHeader'>Ticket ID</th>
            <th class='ticketHeader'>Machine Name</th>
            <th class='ticketHeader'>Room</th>
            <th class='ticketHeader'>Status</th>
            <th class='ticketHeader'>Comments</th>
            <th class='ticketHeader'>Created</th>
            <th class='ticketHeader'>Closed</th>
            <th class='ticketHeader'>Requested By</th>
            <th class='ticketHeader'>Requested By</th>
            <th class='ticketHeader'>Supervisor</th>
            <th class='ticketHeader'>Supervisor Code</th>
            <th class='ticketHeader'>Assigned Tech</th>
            <th class='ticketHeader'>Invoice</th>
        ";
    }
    else{
        $tableHeader =  "
            <table class='ticketTable table table-striped table-dark table-bordered'>
            <th class='ticketHeader'>Ticket ID</th>
            <th class='ticketHeader'>Machine Name</th>
            <th class='ticketHeader'>Room</th>
            <th class='ticketHeader'>Status</th>
            <th class='ticketHeader'>Comments</th>
            <th class='ticketHeader'>Created</th>
            <th class='ticketHeader'>Closed</th>
            <th class='ticketHeader'>Supervisor</th>
            <th class='ticketHeader'>Supervisor Code</th>
            <th class='ticketHeader'>Assigned Tech</th>
        ";
    }

    return $tableHeader;
}

function getSQLQuery($isAdmin,$fromRow, $rowStep,$userID){
    //Create the SQL select.
    $sqlWhereSet = false; //Is set to true when the first "where" in the select to ensure theres only 1.
    if($isAdmin){
        $sql = "select ticket_id,machine_name,room,status,concat(comment,' ',other_comments),created_time,closed_time,
        CASE 
            WHEN userP.email IS NULL THEN '  '
            ELSE userP.email 
        END,
        CASE 
            WHEN userP.username IS NULL THEN '  '
            ELSE userP.username 
        END,
        supervisor_name,
        supervisor_code,
        CASE 
            WHEN techP.username IS NULL THEN '  '
            ELSE techP.username 
        END,
        ' '
        from 
        ((tickets
        LEFT JOIN profile userP ON tickets.requested_by = userP.unique_id)
        LEFT JOIN profile techP ON tickets.assigned_tech = techP.unique_id)"; 
        list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'requestedBy','requested_by');
    }
    else{
        $sqlWhereSet = true;
        $sql = "select ticket_id,machine_name,room,status,concat(comment,' ',other_comments),created_time,closed_time,
        supervisor_name,
        supervisor_code,
        CASE 
            WHEN techP.username IS NULL THEN '  '
            ELSE techP.username 
        END
        from 
        ((tickets
        LEFT JOIN profile userP ON tickets.requested_by = userP.unique_id)
        LEFT JOIN profile techP ON tickets.assigned_tech = techP.unique_id)
        where requested_by = '$userID'"; 
    }
    //Add all the required search fields to $sql
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'ticketID','ticket_id');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'machineName','machine_name');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'room','room');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'status','status');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'createdBy','created_time');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'closedBy','closed_time');
    list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'assignedTech','assigned_tech');
    $sql = $sql . " order by `Ticket_ID` LIMIT $fromRow, $rowStep;";

    return $sql;
}
main();

?>
