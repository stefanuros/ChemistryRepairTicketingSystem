<?php
// Script to get stats from db
//Written by stefan

// Getting the path to the folder
$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];

include_once $path . '/includes/authenticate.php';

//Call the config file to get access to the needed info
//This is already called in authenticate but it shouldnt be an issue cause of the include_once
include_once $path . '/includes/config.php';

//Check if the user is authenticated
//$auth is a variable from authenticate.php
if(!$auth || !$isAdmin)
{
	// User is not authenticated
	//Send an error message that was created in authenticate.php
	echo $jsonMsg;
	exit();
}

include_once $path . '/includes/connect.php';

// The array that will hold the stats
$stats = array();

// Prepare the select statement for the first chart
$stmt = $conn->prepare('SELECT count(*) as y, name as label FROM `tickets` t LEFT JOIN (SELECT unique_id, concat(first_name," ",last_name) name from profile) u ON u.unique_id=t.assigned_tech where assigned_tech != "" and assigned_tech != "NULL" and status != "Closed" GROUP BY assigned_tech ORDER BY y DESC;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['numTicketsAssignedTech'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the second chart
$stmt = $conn->prepare('SELECT (COUNT(*) / (SELECT COUNT(*) FROM `tickets` WHERE status != "Closed")) * 100 as y, COUNT(*) as num, status as label FROM `tickets` where status != "Closed" GROUP BY status;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['numTicketsAssigned'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the third, opened, chart
$stmt = $conn->prepare('SELECT w.month as x, IF(ISNULL(s.y), 0, s.y) as y FROM (SELECT STR_TO_DATE(CONCAT(YEAR(curdate()), " ", MONTH(curdate())," 01"), "%Y %c %d") - interval @monthCount month as month, MONTH(curdate() - interval @monthCount month) as monthCount, @monthCount := @monthCount + 1 as w FROM tickets JOIN (SELECT @curRow := MONTH(curdate()), @monthCount := 0) r WHERE @monthCount < 12) w LEFT JOIN (SELECT STR_TO_DATE(CONCAT(YEAR(created_time), " ", MONTH(created_time)," 01"), "%Y %c %d") x, MONTH(created_time) month, COUNT(*) as y FROM tickets where created_time >= (STR_TO_DATE(CONCAT(YEAR(curdate()), " ", MONTH(curdate())," 01"), "%Y %c %d") - interval 12 month) group by month) s on w.monthCount = s.month;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['ticketHistoryMonthOpened'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the third, closed, chart
$stmt = $conn->prepare('SELECT w.month as x, IF(ISNULL(s.y), 0, s.y) as y FROM (SELECT STR_TO_DATE(CONCAT(YEAR(curdate()), " ", MONTH(curdate())," 01"), "%Y %c %d") - interval @monthCount month as month, MONTH(curdate() - interval @monthCount month) as monthCount, @monthCount := @monthCount + 1 as w FROM tickets JOIN (SELECT @curRow := MONTH(curdate()), @monthCount := 0) r WHERE @monthCount < 12) w LEFT JOIN (SELECT STR_TO_DATE(CONCAT(YEAR(closed_time), " ", MONTH(closed_time)," 01"), "%Y %c %d") x, MONTH(closed_time) month, COUNT(*) as y FROM tickets where closed_time >= (STR_TO_DATE(CONCAT(YEAR(curdate()), " ", MONTH(curdate())," 01"), "%Y %c %d") - interval 12 month) group by month) s on w.monthCount = s.month;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['ticketHistoryMonthClosed'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the fourth, opened, chart
$stmt = $conn->prepare('SELECT w.week as x, IF(ISNULL(s.y), 0, s.y) as y FROM (SELECT STR_TO_DATE(CONCAT(YEARWEEK(curdate(), 1)," Monday"), "%x%v %W") - interval @weekCount week as week, WEEK(curdate() - interval @weekCount week, 1) as weekCount, @weekCount := @weekCount + 1 as w FROM tickets JOIN (SELECT @curRow := WEEK(curdate(), 1), @weekCount := 0) r WHERE @weekCount < 12) w LEFT JOIN (SELECT STR_TO_DATE(CONCAT(YEARWEEK(created_time, 1)," Monday"), "%x%v %W") x, WEEK(created_time, 1) week, COUNT(*) as y FROM tickets where created_time >= (STR_TO_DATE(CONCAT(YEARWEEK(curdate(), 1)," Monday"), "%x%v %W") - interval 12 week) group by week) s on w.weekCount = s.week;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['ticketHistoryWeekOpened'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the fourth, closed, chart
$stmt = $conn->prepare('SELECT w.week as x, IF(ISNULL(s.y), 0, s.y) as y FROM (SELECT STR_TO_DATE(CONCAT(YEARWEEK(curdate(), 1)," Monday"), "%x%v %W") - interval @weekCount week as week, WEEK(curdate() - interval @weekCount week, 1) as weekCount, @weekCount := @weekCount + 1 as w FROM tickets JOIN (SELECT @curRow := WEEK(curdate(), 1), @weekCount := 0) r WHERE @weekCount < 12) w LEFT JOIN (SELECT STR_TO_DATE(CONCAT(YEARWEEK(closed_time, 1)," Monday"), "%x%v %W") x, WEEK(closed_time, 1) week, COUNT(*) as y FROM tickets where closed_time >= (STR_TO_DATE(CONCAT(YEARWEEK(curdate(), 1)," Monday"), "%x%v %W") - interval 12 week) group by week) s on w.weekCount = s.week;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['ticketHistoryWeekClosed'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the fifth chart
$stmt = $conn->prepare('SELECT count(*) as y, machine_name as label FROM `tickets` where machine_name != "" GROUP BY machine_name ORDER BY y DESC limit 5;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['mostTicketsMachines'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the select statement for the sixth chart
$stmt = $conn->prepare('SELECT count(*) as y, room as label FROM `tickets` where room != "" GROUP BY room ORDER BY y DESC limit 5;'); 
// Execute it
$stmt->execute();
//Get the result from the query
$stats['mostTicketsRooms'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send the stats back
echo json_encode($stats);
?>
