<?php
/*
 * Created on Jan 16, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/set.php";
$userId = GetTextFromSession("userId",0,0);
$status = "success";
$numRecords = 0;
if (!$userId)
{
	echo '{"status":"'.$status.'","numOfOverDue":"'.$numRecords.'"}';
	exit;
}
$lastRun = GetTextFromSession("lastRunOverDue","2013-01-01 00:00:00",0);
DebugText("LastRun:".$lastRun);
DebugText("now:".$now);
$nowRun = strtotime($now);
$last = strtotime($lastRun);
$diff = round(abs($nowRun - $last) / 60,2);
DebugText("Diff Time = ".$diff);
$tickets = new Set();
if ($diff >=60)
{
	$_SESSION['lastRunOverDue'] = $now;
	$ticket = new Ticket();
	$pastDueDate = date('Y-m-d', strtotime($today. ' - 7 day'));
	$param = "dueDate <> '0000-00-00' and dueDate <'$pastDueDate' and statusId<>4 and ownerId=$currentUser->userId";
	$numRecords = $ticket->Count($param);

	$tickets->separator = ",";
  $ok = $ticket->Get($param);
	while ($ok)
	{
		$tickets->Add($ticket->ticketId);
		$ok = $ticket->Next();
	}
}
  echo '{"status":"'.$status.'","numOfOverDue":"'.$numRecords.'","tickets":"'.$tickets->data.'"}';
//DebugOutput();
?>
