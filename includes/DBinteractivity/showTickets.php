<!-- 
Tom Szendrey
Feb - March 2019
This will be used for the database access for showTickets.html. 
On a search submit button this will create a SQL select statement based off of the search criteria and send that table to showTickets.js
-->

<?php

//TODO: Allow Admins to change some sections
//TODO: Drop box for closed, using sysdate for the assigned value.
//TODO: If already closed, no drop box option?


//include_once '../authenticate.php';
include_once '../config.php';
include_once '../connect.php';

//if (!$auth){
//    echo $jsonMsg;
//    exit();
//}

//create a table
echo "
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
list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'ticketID','ticket_id');
list($sql,$sqlWhereSet) = appendSearchInfo($sql,$sqlWhereSet,'machineName','machine_name');

$sql = $sql . " order by `Ticket_ID`;";

//fill the table with ALL information.
//TODO: create SQL based off of inputs.
echo $sql;
$sqlPrepared = $conn->prepare($sql);
if(!$sqlPrepared->execute()) {
    echo('Error The command could not be executed, and the information could not be read.');
    exit();
}
$height = 1;
//While there are rows left in the SQL
while($row = $sqlPrepared->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    $i = 0;
        foreach($row as $value) {
            echo "<td class='ticketCell'>$value</td>";
        }//end foreach
        $height = $height + 1;
        echo "</tr>";
}//End While (There is a row to fetch)
echo "</table";

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
?>