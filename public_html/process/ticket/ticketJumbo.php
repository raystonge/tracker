<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/comment.php";
include_once "tracker/set.php";
include_once "tracker/queue.php";
include_once "tracker/priority.php";
include_once "tracker/status.php";
include_once "tracker/poNumber.php";
ProperAccessValidate();
$tickets = "";
$ticketIds = new Set(",");
if (isset($_POST['ticketIds']))
{
	$tickets = $_POST['ticketIds'];
}
$ticketIds->SetData($tickets);
while ($ticketIds->GetIndex() >=0)
{
	$historyArray = array();
	$action = "Change";
	$ticketId = $ticketIds->GetValue();
	$ticket = new Ticket($ticketId);
	DebugText("ticketId:".$ticketId.":".$ticket->ticketId);
	if (isset($_POST['queue']))
	{
		if ($_POST['queue'] > 0)
		{
			$queueId = $_POST['queue'];
			$oldQueue = new Queue($ticket->queueId);
			$ticket->queueId = $queueId;
			$queue = new Queue($ticket->queueId);
			DebugText("queue:".$queue->name);
		    $historyVal = CreateHistory($action,"Queue",$oldQueue->name,$queue->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['requestor']))
	{
		if ($_POST['requestor'] > 0)
		{
			$requestorId = $_POST['requestor'];
			$oldRequestor = new User($ticket->requestorId);
			$ticket->requestorId = $requestorId;
			$requestor = new User($ticket->requestorId);
			DebugText("requestor:".$requestor->fullName);
		    $historyVal = CreateHistory($action,"Requestor",$oldRequestor->fullName,$requestor->fullName);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['priority']))
	{
		if ($_POST['priority'] > 0)
		{
			$priorityId = $_POST['priority'];
			$oldPriority = new Priority($ticket->priorityId);
			$ticket->priorityId = $priorityId;
			$priority = new Priority($ticket->priorityId);

		    $historyVal = CreateHistory($action,"Priority",$oldPriority->name,$priority->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['status']))
	{
		if ($_POST['status'] > 0)
		{
			$statusId = $_POST['status'];
			$oldStatus = new Status($ticket->statusId);
			$ticket->statusId = $statusId;
			$status = new Status($ticket->statusId);

		    $historyVal = CreateHistory($action,"Status",$oldStatus->name,$status->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['assignee']))
	{
		if ($_POST['assignee'] > 0)
		{
			$ownerId = $_POST['assignee'];
			$oldRequestor = new User($ticket->ownerId);
			$ticket->ownerId = $ownerId;
			$owner = new User($ticket->ownerId);

		    $historyVal = CreateHistory($action,"Assignee",$oldRequestor->fullName,$owner->fullName);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['cc']))
	{
		$ccAddresses = new Set(",");
		@$ccs = $_POST['cc'];
		if ($ccs)
		{
			$historyVal = "Resetting CCs";
			array_push($historyArray,$historyVal);
			$ticketCC = new TicketCC();
			$ticketCC->Reset($ticket->ticketId);
			while (list ($key, $cc) = each ($ccs))
			{
			    $ticketCC->ticketId = $ticket->ticketId;
				$ticketCC->userId=$cc;
				$ccUser = new User($cc);
				$historyVal = "Adding ".$ccUser->fullName." to CCs";
				array_push($historyArray,$historyVal);
				$ccAddresses->Add($ccUser->email);
				$ticketCC->Insert();
			}
	    }
	}

	if (isset($_POST['subject']))
	{
		$val = trim($_POST['subject']);
		if ($val != "--do_not_change--")
		{
			$oldSubject = $ticket->subject;
			$subject = trim($_POST['subject']);
			$ticket->subject = $subject;
			if (GetTextField("append",0))
			{
				$ticket->subject = $subject." ".$oldSubject;
			}
			if (GetTextField("prepend",0))
			{
				$ticket->subject = $oldSubject." ".$subject;
			}
		    $historyVal = CreateHistory($action,"Subject",$oldSubject,$val);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['poNumber']))
	{
		$val = trim($_POST['poNumber']);
		if ($val != "--do_not_change--")
		{
			$oldPO = new poNumber($ticket->poNumber);
			$ticket->poNumberId = trim($_POST['poNumberId']);
			$po = new poNumber($ticket->poNumberId);
			if ($po->poNumberId == 0)
			{
				$po->poNumber = "Removed";
			}
		    $historyVal = CreateHistory($action,"PO NUmber",$oldPO->poNumber,$po->poNumber);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if ($ticket->Update())
	{
		if (isset($_POST['description']))
		{
			$commentText = trim($_POST['description']);
			if (strlen($commentText))
			{
				$comment = new Comment();
				$comment->ticketId = $ticket->ticketId;
				$comment->comment = $commentText;
				$comment->Persist();
			}
		}

	}
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

}
$moduleId = GetTextFromSession("moduleId",0);
if ($moduleId)
{
	DebugPause("/viewReports/".$moduleId."/");
	exit();
}
DebugPause("/listTickets/");
?>
