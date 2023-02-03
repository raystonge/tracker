<?php
//
//  Tracker - Version 1.5.0
//
//  v1.5.0
//   - relaced each() with legacy_each()

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
include_once "tracker/ticketCC.php";
include_once "tracker/comment.php";
include_once "tracker/permission.php";
include_once "tracker/defaultUser.php";
include_once "tracker/ticketDependencies.php";
include_once "tracker/asset.php";
include_once "tracker/assetToTicket.php";
include_once "tracker/status.php";
include_once "tracker/queue.php";
include_once "tracker/priority.php";
include_once "tracker/mailSupport.php";
include_once "tracker/organization.php";
include_once "tracker/duplicateTicket.php";


ProperAccessValidate();
$_SESSION['formErrors'] ="";
$ticket = new Ticket();
if (isset($_POST['submitTest']))
{
	$ticket = new Ticket();
	$validated = false;
	$status='fail';
	$html="";
	$organizationId = GetTextField("organizationId",0);
	$subject = GetTextField("subject");
	$assigneeId = GetTextField("assignee",0);
	$queueId = GetTextField("queue",0);
	$requestorId = GetTextField("requestorId",0);
	$priorityId = GetTextField("priority",0);
	$statusId = GetTextField("status",0);
	$ownerId = GetTextField("ownerId",0);
	$timeWorked = GetTextField("timeWorked",0);
	$userDueDate = GetTextField("useDueDate",0);
	$dueDate = GetTextField("dueDate");
	$duplicateId = GetTextField("duplicateId",0);
	$ccs = "";
	if (isset($_POST['cc']))
	{
		@$ccs = $_POST['cc'];
	}
	$insurancePayments = "";
	$insuranceRepaireCompletes = "";
	$insuranceRepairId = 0;
	$repairCost = "";
	$poNumber = GetTextField("poNumber");
	$commentText = GetTextField("description");
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;

  $ticketId = GetTextField("ticketId",0);
  $ticket = new Ticket($ticketId);
	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify ".$orgOrDept."</li>";
	}
	DebugText("queueId:".$queueId);
	if ($queueId == 0 && $permission->hasPermission("Ticket: Create: User Ticket"))
	{
		DebugText("there is no queue specified");
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Queue</li>";
	}

	if ($requestorId == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Requestor</li>";
	}

	if ($priorityId == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Priority</li>";

	}
	if ($statusId == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Status</li>";
	}
	if (!$queueId && $ticketId && $permission->hasPermission("Ticket: Create: User Ticket"))
	{
	    $assigneeId = 1;
	}
	if ($assigneeId == 0 && !$permission->hasPermission("Ticket: Create: User Ticket"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify an Assignee</li>";
	}
	if (strlen($subject) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Subject</li>";
	}
	if ($statusId == 4 && !$timeWorked)
	{
	    $numErrors++;
	    $errorMsg = $errorMsg."<li>Time work must be specified if ticket is closed</li>";
	}
	DebugText("StatusId before checking depends:".$statusId.":".$ticket->statusId);
	if (isset($_POST['depends']) && $statusId==4)
	{
		DebugText("processing depends to see if they are open");
		$depends = new Set(",");
		$depends->SetData(trim($_POST['depends']));
		DebugText("depends:".$depends->data);
		$ticketDependencies = new TicketDependencies();
		//	$ticketDependencies->ResetDepends($ticket->ticketId);
		$openDependencies = 0;
		while (strlen($depends->data) && ($depends->GetIndex() >=0))
		{
			$dependentTicket = new Ticket($depends->GetValue());
			DebugText("dependent Status:".$dependentTicket->statusId);
			if ($dependentTicket->statusId != 4)
			{
				$openDependencies = 1;
			}
		}
		DebugText("openDendencies:".$openDependencies);
		DebugText("status:".$statusId);
		if ($openDependencies && $statusId==4)
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Ticket has open depenencies and cannot be closed</li>";
		}
	}
	$dateCompleted = "";
	if ($statusId == 4 && !strlen($ticket->dateCompleted))
	{
		$dateCompleted = $today;
	}
	DebugText("ticketId:".$ticket->ticketId);
	DebugText("statusId:".$statusId.":".$ticket->statusId);
	if (!$ticket->ticketId && strlen($commentText) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Comment</li>";
	}


	if ($numErrors ==0)
	{
		$historyArray = array();
		DebugText("Start building History");
		DebugText("ticket->queueId:".$ticket->queueId);
		DebugText("queueId:".$queueId);
		if ($ticket->organizationId != $organizationId)
		{
			$action="Create";
			if ($ticket->organizationId)
			{
				$action = "Change";
			}
			$oldOrganization = new Organization($ticket->organizationId);
			$ticket->organizationId = $organizationId;
			$organization = new Organization($ticket->organizationId);
			DebugText("organization:".$organization->name);
		    $historyVal = CreateHistory($action,$orgOrDept,$oldOrganization->name,$organization->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		    DebugText("size of History Array:".sizeof($historyArray));

		}


		if ($ticket->queueId != $queueId)
		{
			$action="Create";
			if ($ticket->queueId)
			{
				$action = "Change";
			}
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
		    DebugText("size of History Array:".sizeof($historyArray));

		}
		if (($ticket->requestorId != $requestorId) || !$ticket->ticketId)
		{
			$action="Create";
			if ($ticket->requestorId && $ticket->ticketId)
			{
				$action = "Change";
			}
			$oldRequestor = new User($ticket->requestorId);
			$ticket->requestorId = $requestorId;
			$requestor = new User($ticket->requestorId);
		    $historyVal = CreateHistory($action,"Requestor",$oldRequestor->fullName,$requestor->fullName);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}

		if (($ticket->priorityId != $priorityId) || !$ticket->ticketId)
		{
			$action="Create";
			if ($ticket->priorityId && $ticket->ticketId)
			{
				$action = "Change";
			}
			$oldPriority = new Priority($ticket->priorityId);
			$ticket->priorityId = $priorityId;
			$priority = new Priority($ticket->priorityId);
		    $historyVal = CreateHistory($action,"Priority",$oldPriority->name,$priority->name);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}

		if ($ticket->ticketId)
		{
			if ($statusId == 1)
			{
				$statusId = 2;
			}
		}
		DebugText("statusId after first check:".$statusId);

		if (($ticket->statusId == 1) and ($statusId == 1) && ($ticket->ticketId))
		{
			$statusId = 2;
		}
		DebugText("statusId after second check:".$statusId);

		$statuses = new Set(",");
		//$statuses->Add(1);
		$statuses->Add(2);
		$statuses->Add(3);
		$statuses->Add(5);
	//	$statuses->Add(4);
		DebugText("statusId before check:".$statusId);

		if ($statuses->InSet($statusId))
		{
			DebugText("Changing StatusId");
			$statusId = 3;
		}
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


		if (($ticket->ownerId != $assigneeId) || !$ticket->ticketId)
		{
			$action="Create";
			if ($ticket->ownerId && $ticket->ticketId)
			{
				$action = "Change";
			}
			$oldAssignee = new User($ticket->ownerId);
			$ticket->ownerId = $assigneeId;
			$assignee = new User($ticket->ownerId);
		  $historyVal = CreateHistory($action,"Owner",$oldAssignee->fullName,$assignee->fullName);
		  if (strlen($historyVal))
		  {
		   	array_push($historyArray,$historyVal);
		  }
		}
		DebugText("duplicateId test:".$duplicateId);
		if ($duplicateId)
		{
			$action = "Add";
			$historyVal = CreateHistory($action,"Duplicate","",$duplicateId);
		  if (strlen($historyVal))
		  {
		   	array_push($historyArray,$historyVal);
		  }
			$ticket->statusId = 4;
			$ticket->billable = 0;
			$ticket->dateCompleted = $today;
			$duplicateTicket = new DuplicateTicket();
			$duplicateTicket->duplicateOfId = $duplicateId;
			$duplicateTicket->ticketId = $ticket->ticketId;
			$duplicateTicket->Persist();
		}
		if ($ticket->subject !=  $subject)
		{
			$action="Create";
			if (strlen($ticket->subject))
			{
				$action = "Change";
			}
			$oldSubject = $ticket->subject;
			$ticket->subject = $subject;
		    $historyVal = CreateHistory($action,"Subject",$oldSubject,$subject);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
		DebugText("Test Waiting for User");
		DebugText("statusId:".$statusId);
		DebugText("useDueDate:".$userDueDate);
		DebugText("dueDate:".$ticket->dueDate);
		if ($statusId == 7 && !$userDueDate && !strlen($ticket->dueDate))
		{
			global $numDaysForWaitingOnUser;
			$daysAdd = " + ".$numDaysForWaitingOnUser." days";
			$dueDate = date('Y-m-d', strtotime(Today(). $daysAdd));
			DebugText("dueDate waiting for User:".$dueDate);
			$userDueDate = 1;
		}
		if ($statusId == 8 && !$userDueDate && !strlen($ticket->dueDate))
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
		if ($userDueDate && ($ticket->dueDate != $dueDate))
		{
		    $action = "Change";
		    $oldDateDue = $ticket->dueDate;
		    $ticket->dueDate = $dueDate;
		    $historyVal = CreateHistory($action,"dueDate",$oldDateDue,$dueDate);
		    if (strlen($historyVal))
		    {
		        array_push($historyArray,$historyVal);
		    }
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
		if ($ticket->timeWorked != $timeWorked)
		{
		    $action = "Change";
		    $oldTimeWorked = $ticket->timeWorked;
		    $ticket->timeWorked = $timeWorked;
		    $historyVal = CreateHistory($action,"timeWorked",$oldTimeWorked,$timeWorked);
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
		if ($ticket->ticketId)
		{
			$history = new History();
			$history->ticketId = $ticket->ticketId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = "Modified ticket";
			$history->Insert();
			$ticket->Update();
		}
		else
		{
			$ticket->creatorId = $_SESSION['userId'];
			$organization = new Organization($ticket->organizationId);
			$ticket->billable = $organization->billable;

			$ticket->Insert();
			$history = new History();
			$history->ticketId = $ticket->ticketId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = "Inserted ticket";
			$history->Insert();
		}

		$ticketId = $ticket->ticketId;

		if (strlen($commentText))
		{
			$comment = new Comment();
			$comment->ticketId = $ticket->ticketId;
			$comment->comment = $commentText;
			$comment->Persist();
			$historyVal = "Comment Added";
		    //$historyVal = CreateHistory("Create","Comment added","","");
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

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

		$ccAddresses = new Set(",");
		if (isset($_POST['cc']))
		{
			@$ccs = $_POST['cc'];
			if ($ccs)
			{
				$ticketCC = new TicketCC();
				$ticketCC->Reset($ticket->ticketId);
				while (list ($key, $cc) = legacy_each ($ccs))
				{
					$ticketCC->ticketId = $ticket->ticketId;
					$ticketCC->userId=$cc;
					$ccUser = new User($cc);
					if ($userToGroup->IsMember($cc,"eMail Recipents"))
					{
						$ccAddresses->Add($ccUser->email);
					}
					$ticketCC->Insert();
				}
		    }

		}
		$requestorEmail = "";
		if ($userToGroup->IsMember($requestor->userId, "eMail Recipents"))
		{
		    $requestorEmail= $requestor->email;
		}
		TicketNotice($to,$ccAddresses->data,$subject,$message,$link,$historyArray,$requestorEmail);
		if (isset($_POST['createTicketForAsset']))
		{
			if ($_POST['createTicketForAsset'])
			{
				$asset = new Asset($_POST['createTicketForAsset']);
				$assetToTicket = new AssetToTicket();
				$assetToTicket->ticketId = $ticket->ticketId;
				$assetToTicket->assetId = $asset->assetId;
				if ($asset->assetId)
				{
					$assetToTicket->Insert();
					$historyText = "";
					if (strlen($asset->serialNumber))
					{
						$historyText = "Serial Number: ".$asset->serialNumber;
					}
					else
					{
						if (strlen($asset->assetTag))
						{
							$historyText = "Asset Tag: ".$asset->assetTag;
						}
						else
						{
							$historyText = "Asset Id:".$asset->assetId;
						}
					}
					$historyVal = "Adding Asset ".$historyText;
					array_push($historyArray,$historyVal);
				}
			}
		}


		if (isset($_POST['blocks']))
		{
			DebugText("processing blocks");
			$ticket = new Ticket($ticketId);
			$blocks = new Set(",");
			$blocks->SetData(trim($_POST['blocks']));
			DebugText("block data:".$blocks->data);
			DebugText("block index:".$blocks->index);
			$ticketDependencies = new TicketDependencies();
			//$ticketDependencies->ResetBlocks($ticket->ticketId);
			$cnt =0;
			while ($blocks->GetIndex() >=0 && strlen($blocks->data))
			{
				$cnt++;
				$ticketDependencies = new TicketDependencies();
				$blockId = $blocks->GetValue();
				$param = "blockId=".$blockId." and dependsId=".$ticket->ticketId;
				if (!$ticketDependencies->Get($param))
				{
					$ticketDependencies->blockId = $blockId;
					$ticketDependencies->dependsId = $ticket->ticketId;
					$ticketDependencies->Insert();
					$historyVal = "Added Ticket block:".$ticketDependencies->blockId;
					DebugText($historyVal);
					array_push($historyArray,$historyVal);
				}
				else
				{
					OpenBlockedTickets($blockId);
				}
			}
			$ticketDependencies = new TicketDependencies();
			$param = "dependsId=".$ticket->ticketId;
			$ok = $ticketDependencies->Get($param);
			while ($ok)
			{
				if (!$blocks->InSet($ticketDependencies->blockId))
				{
					$ticketDependencies->Delete();
					$historyVal = "Removed Ticket block:".$ticketDependencies->blockId;
					array_push($historyArray,$historyVal);
					DebugText($historyVal);
				}
				$ok = $ticketDependencies->Next();
			}
		}

		if (isset($_POST['depends']))
		{
			DebugText("processing depends");
			$blockId = $ticket->ticketId;
			$depends = new Set(",");
			$depends->SetData(trim($_POST['depends']));
			$ticketDependencies = new TicketDependencies();
			//$ticketDependencies->ResetDepends($ticket->ticketId);
			$cnt++;
			//while ($depends->GetIndex() >=0  && $cnt < 5)
			while ($depends->GetIndex() >=0 && strlen($depends->data))
			{
				DebugText("index:".$depends->index);
				$cnt++;
				$ticketDependencies = new TicketDependencies();
				$dependId = $depends->GetValue();
				$param = "dependsId=".$dependId." and blockId=".$ticket->ticketId;
				if (!$ticketDependencies->Get($param))
				{
					$ticketDependencies->blockId = $blockId;
					$ticketDependencies->dependsId = $dependId;
					$ticketDependencies->Insert();
					$historyVal = "Added Ticket Dependent:".$ticketDependencies->dependsId;
					DebugText($historyVal);
					array_push($historyArray,$historyVal);
				}
			//	$depends->index = $depends->index--;
			}
			$ticketDependencies = new TicketDependencies();
			$param = "blockId=".$ticket->ticketId;
			$ok = $ticketDependencies->Get($param);
			$cnt = 0;
			while ($ok && $cnt < 5)
			{
				$cnt++;
				if (!$depends->InSet($ticketDependencies->dependsId))
				{
					$ticketDependencies->Delete();
					$historyVal = "Removed Ticket Dependent:".$ticketDependencies->dependsId;
					DebugText($historyVal);
					array_push($historyArray,$historyVal);
				}
				$ok = $ticketDependencies->Next();
				DebugText("ok:".$ok);
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
		$_SESSION['formSuccess'] = "Success";
		DebugPause("/ticketEdit/".$ticket->ticketId."/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['createTicketForAsset'] = $_POST['createTicketForAsset'];
		$_SESSION['ticketSubject']=$subject;
		$_SESSION['ticketAssigneeId'] = $assigneeId;
		$_SESSION['ticketQueueId'] = $queueId;
		$_SESSION['ticketRequestorId'] = $requestorId;
		$_SESSION['ticketOwnerId'] = $ownerId;
		$_SESSION['ticketPriorityId'] = $priorityId;
		$_SESSION['ticketPONumber'] = $poNumber;
		$_SESSION['ticketComment'] = $commentText;
		$_SESSION['ticketBlockData'] = trim($_POST['blocks']);
		$_SESSION['ticketDependsData'] = trim($_POST['depends']);
		$_SESSION['ticketOrganizationId'] = $organizationId;
		$_SESSION['ticketCCs'] = $ccs;
		$_SESSION['formErrors'] = $html;
	//	$ticket = new Ticket($ticketId);
		if ($ticket->ticketId)
		{
			if ($ticket->statusId == 4)
			{
				DebugPause("/listTickets/");
			}
			DebugPause("/ticketEdit/".$ticket->ticketId."/");
		}
		DebugPause("/ticketNew/");
	}
}

DebugPause("/listTickets/");
?>
