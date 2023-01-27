<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
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
