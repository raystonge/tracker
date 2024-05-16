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
include_once "tracker/ticketDependencies.php";
include_once "tracker/timeWorked.php";
include_once 'tracker/status.php';
include_once "tracker/comment.php";
include_once "tracker/user.php";
include_once "tracker/userGroup.php";
include_once "tracker/mailSupport.php";
include_once "tracker/priority.php";
include_once "tracker/queue.php";
include_once "tracker/ticketCC.php";
include_once "tracker/set.php";


ProperAccessValidate();
if (!GetTextField("submitTest",0))
{
	DebugPause("/");
}
$html = "";
$numErrors = 0;
$errMsg = "";

$ticketId = GetTextField("ticketId",0);
if (!$ticketId)
{
	DebugPause("/");
}
$amtWorked = GetTextField("timeWorked",0);
$timeEstimate = GetTextField("timeEstimate",0);
$dueDate = "";
$useDueDate = GetTextField("useDueDate",0);
$billable = GetTextField("billable",0);
$commentText = GetTextAreaField("description");
$statusId = GetTextField("status",0);
$orgAmtWorked = $amtWorked;
$amtWorked = $amtWorked * 100;

$statuses = new Set(",");
$statuses->Add(1);
$statuses->Add(2);
$statuses->Add(3);
$statuses->Add(5);


if ($statuses->InSet($statusId))
{
	$statusId = 3;
}
DebugText("amtWorked % 25:".($amtWorked % 25));
if (($amtWorked % 25) && !isMemberofGroup($currentUser->userId,"Admin"))
{
	$numErrors++;
	$errMsg = $errMsg."<li>Time must be in quarter hour increments</li>";
}
if ($amtWorked && !strlen($commentText) && !isMemberofGroup($currentUser->userId,"Admin"))
{
	$numErrors++;
	$errMsg = $errMsg."<li>A comment is required if you specify time worked</li>";
}
if (!$amtWorked && strlen($commentText)  && !isMemberofGroup($currentUser->userId,"Admin"))
{
	$numErrors++;
	$errMsg = $errMsg."<li>Time worked is required if there is a comment</li>";
}
$ticket = new Ticket($ticketId);
$openDependencies = 0;
if ($statusId == 4)
{
  DebugText("processing depends to see if they are open");

  $ticketDependencies = new TicketDependencies();
  $param = AddEscapedParam("","dependsId",$ticket->ticketId);
  $ok = $ticketDependencies->Get($param);
  //	$ticketDependencies->ResetDepends($ticket->ticketId);

  while ($ok)
  {
		echo $ticketDependencies->blockId."<br>";
		$dependentTicket = new Ticket($ticketDependencies->blockId);
	  DebugText("dependent Status:".$dependentTicket->statusId);
	  if ($dependentTicket->statusId != 4)
		{
			$openDependencies = 1;
	  }
	  $ok = $ticketDependencies->Next();
  }
}
DebugText("openDendencies:".$openDependencies);
DebugText("status:".$statusId);
if ($openDependencies && $statusId==4)
{
	$numErrors++;
	$errMsg=$errMsg."<li>Ticket has open depenencies and cannot be closed</li>";
}
$amtWorked = $orgAmtWorked;
if ($useDueDate)
{
	$dueDate = DatePickerUnFormatter(GetDateField("dueDate"));
}

if ($numErrors)
{
	$html = "<ul>".$errMsg."</ul>";
	$_SESSION['scheduleTimeEstimate'] = $timeEstimate;
	$_SESSION['scheduleTimeWorked'] = $amtWorked;
	$_SESSION['scheduleDueDate'] = $dueDate;
	$_SESSION['scheduleBillable'] = $billable;
	$_SESSION['scheduleStatusId'] = $statusId;
	$_SESSION['scheduleComment'] = $commentText;
	$_SESSION['formErrors'] = $html;
	DebugPause("/ticketSchedule/".$ticketId."/");
}
$status = new Status();
$param = "name='In Progress'";
$statusInProgressID = $status->Get($param);
$param = "name='Closed'";
$statusClosedID = $status->Get($param);
$userDueDate = 0;


if (($ticket->statusId != $statusInProgressID) && ($ticket->statusId != $statusClosedID))
{
	$ticket->statusId = $statusInProgressID;
}
if ($statusId == 7 && !$useDueDate && !strlen($ticket->dueDate))
{
	global $numDaysForWaitingOnUser;
	$daysAdd = " + ".$numDaysForWaitingOnUser." days";
	$dueDate = date('Y-m-d', strtotime(Today(). $daysAdd));
	DebugText("dueDate waiting for User:".$dueDate);
	$useDueDate = 1;
}
if ($statusId == 8 && !$useDueDate && !strlen($ticket->dueDate))
{
	global $numDaysForWaitingOnThirdParty;
	$daysAdd = " + ".$numDaysForWaitingOnThirdParty." days";
	$dueDate = date('Y-m-d', strtotime(Today(). $daysAdd));
	DebugText("dueDate waiting for User:".$dueDate);
	$userDueDate = 1;
}
if ($statusId == 9 && !$userDueDate && !strlen($ticket->dueDate))
{
	global $numDaysForFollowUp;
	$daysAdd = " + ".$numDaysForFollowUp." days";
	$dueDate = date('Y-m-d', strtotime(Today(). $daysAdd));
	DebugText("dueDate FollowUp:".$dueDate);
	$userDueDate = 1;
}
if ($useDueDate && ($ticket->dueDate != $dueDate))
{
	$action="Create";
	if (strlen($ticket->dueDate))
	{
		$action = "Change";
	}
	$oldDueDate = $ticket->dueDate;
	$ticket->dueDate = $dueDate;
	$historyVal = CreateHistory($action,"Due Date",$oldDueDate,$dueDate);
	DebugText("history:".$historyVal);
	if (strlen($historyVal))
	{
	  	array_push($historyArray,$historyVal);
	}
	DebugText("size of History Array:".sizeof($historyArray));

}
else
{
	if (!$userDueDate && ($ticket->dueDate != $dueDate))
	{
		$action = "Change";
		$oldDateDue = $ticket->dueDate;
		$ticket->dueDate = "";
		$historyVal = CreateHistory($action,"dueDate",$oldDateDue,$dueDate);
		if (strlen($historyVal))
		{
				array_push($historyArray,$historyVal);
		}
	}
}
if ($ticket->timeEstimate != $timeEstimate)
{
	$action = "Change";
	$oldTimeEstimate = $ticket->timeEstimate;
	$ticket->timeEstimate = $timeEstimate;
	$historyVal = CreateHistory($action,"Time Estimate",$oldTimeEstimate,$timeEstimate);
	DebugText("history:".$historyVal);
	if (strlen($historyVal))
	{
	  	array_push($historyArray,$historyVal);
	}
	DebugText("size of History Array:".sizeof($historyArray));

}


if ($amtWorked)
{
	$comment = new Comment();
	$comment->ticketId = $ticketId;
	$comment->comment = $commentText;
	$comment->Persist();
	$action = "Change";
	$oldTimeWorked = $ticket->timeWorked;
//	$ticket->timeWorked = $timeWorked;
	$historyVal = CreateHistory($action,"Time Worked",$oldTimeWorked,$amtWorked);
	DebugText("origTimeWorked:".$ticket->timeWorked);
	DebugText("amtWorked:".$amtWorked);
	$ticket->timeWorked = $ticket->timeWorked + $amtWorked;
	DebugText("newTimeWorked:".$ticket->timeWorked);
	$timeWorked = new TimeWorked();
	$timeWorked->ticketId = $ticket->ticketId;
	$timeWorked->amtWorked = $amtWorked;
	$timeWorked->dateWorked = Today();
	$timeWorked->userId = $currentUser->userId;
	$timeWorked->commentId = $comment->commentId;
	$timeWorked->Persist();
	DebugText("history:".$historyVal);
	if (strlen($historyVal))
	{
	  	array_push($historyArray,$historyVal);
	}
	DebugText("size of History Array:".sizeof($historyArray));

}
if ($ticket->billable != $billable)
{
	$action = "Change";
	//$oldTimeWorked = $ticket->timeWorked;
	$ticket->billable = $billable;
	/*
	$historyVal = CreateHistory($action,"Time Worked",$oldTimeWorked,$timeWorked);
	DebugText("history:".$historyVal);
	if (strlen($historyVal))
	{
	  	array_push($historyArray,$historyVal);
	}
	DebugText("size of History Array:".sizeof($historyArray));
  */
}
$dateCompleted = "";
if ($statusId == 4 && !strlen($ticket->dateCompleted))
{
	$dateCompleted = $today;
}
DebugText("dateCompleted:".$dateCompleted);
if (($ticket->statusId != $statusId) || !$ticket->ticketId)
{
    $action="Create";
    if ($ticket->statusId && $ticket->ticketId)
    {
        $action = "Change";
    }
    $oldStatus = new Status($ticket->statusId);
    $ticket->statusId = $statusId;
    $status = new Status($ticket->statusId);
    $historyVal = CreateHistory($action,"Status",$oldStatus->name,$status->name);
    if (strlen($historyVal))
    {
        array_push($historyArray,$historyVal);
    }
}
if ($ticket->dateCompleted != $dateCompleted)
{
  $action = "Change";
	$oldDateDue = $ticket->dateCompleted;
	$ticket->dateCompleted = $dateCompleted;
	$historyVal = CreateHistory($action,"dateCompleted",$oldDateDue,$dueDate);
	if (strlen($historyVal))
	{
    array_push($historyArray,$historyVal);
	}
}

$ticket->Persist();
/*
$ticketDependencies = new TicketDependencies();
$ok = $ticketDependencies->GetByBlockId($ticket->ticketId);
while ($ok)
{
	$dependentTicket = new Ticket($ticketDependencies->dependsId);
	if (!strlen($dependentTicket->dueDate))
	{
		$dependentTicket->dueDate = $ticket->dueDate;
		$dependentTicket->Update();
	}
}
*/
$historyVal = array_pop($historyArray);
DebugText("sizeof History:".sizeof($historyArray));
while (strlen($historyVal))
{
  DebugText("historyVal:".$historyVal);
	$history = new History();
	$history->ticketId = $ticket->ticketId;
	$history->userId = $_SESSION['userId'];
	$history->actionDate = $now;
	$history->action = $historyVal;
	$history->Insert();
	$historyVal = array_pop($historyArray);
}
$assignee = new User($ticket->ownerId);
$requestor = new User($ticket->requestorId);
$status = new Status($ticket->statusId);
$priority = new Priority($ticket->priorityId);
$queue = new Queue($ticket->queueId);
$recipients = new Set(",");
$userToGroup = new UserToGroup();
if ($userToGroup->IsMember($ticket->requestorId,"eMail Recipents"))
{
  $recipients->Add($assignee->email);
}
if ($ticket->statusId == 4)
{
  $recipients->Add($requestor->email);
}
$to = $assignee->email;
$link = $hostPath."/ticketEdit/".$ticket->ticketId."/";
$subject = "[tracker] - ".$ticket->subject;
$message = "Ticket has been acted upon\n";
$message = $message."Subject: ".$ticket->subject."\n";
$message = $message."Ticket: ".$ticket->ticketId."\n";
$message = $message."Status: ".$status->name."\n";
$message = $message."Assignee: ".$assignee->fullName."\n";
$message = $message."Requestor: ".$requestor->fullName."\n";
$message = $message."Priority: ".$priority->name."\n";
$message = $message."Queue: ".$queue->name."\n";
if (strlen($commentText))
{
	$message = $message."Comment:".$commentText."\n";
}
$requestorEmail = "";
if ($userToGroup->IsMember($requestor->userId, "eMail Recipents"))
{
    $requestorEmail= $requestor->email;
}
$ccAddresses = new Set(",");
$ticketCC = new TicketCC();
$param = AddEscapedParam("","ticketId",$ticket->ticketId);
$ok = $ticketCC->Get($param);
while ($ok)
{
  $ccUser = new User($ticketCC->userId);
	if ($userToGroup->IsMember($ccUser->userId,"eMail Recipents"))
	{
    $ccAddresses->Add($ccUser->email);
	}
	$ok = $ticketCC->Next();
}
TicketNotice($to,$ccAddresses->data,$subject,$message,$link,$historyArray,$requestorEmail);

$_SESSION['formErrors'] = "Success";
DebugPause("/ticketSchedule/".$ticket->ticketId."/");
?>
