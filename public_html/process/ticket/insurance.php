<?php
/*
 * Created on Feb 8, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/status.php";
include_once "tracker/poNumber.php";
ProperAccessValidate();
$ticketId = GetTextField('ticketId',0);
$ticket = new Ticket($ticketId);
if (!$ticket->ticketId)
{
	DebugOutput();
	exit;
}
$html = "";
$numErrors = 0;
$errMsg = "";
$poNumberId = GetTextField("poNumberId",0);
$insuranceRepair = GetTextField("insuranceRepair","No");
$repairCost = GetTextField("repairCost",0);
$paymentMade = GetTextField("paymentMade",0);
$insurancePayment = "";
if ($paymentMade)
{
	$insurancePayment = GetTextField("insurancePayment");
}
$repairMade = GetTextField("repairMade",0);
$repairComplete = "";
if ($repairMade)
{
	$repairComplete = GetTextField("insuranceRepairComplete","");
}
if ($insuranceRepair == "Yes")
{
	if (!$poNumberId)
	{
		DebugText("no po specified");
		$numErrors++;
		$errMsg = $errMsg."<li>Select a PO Number</li>";
	}
}
DebugText("numErrors:".$numErrors);
if ($numErrors == 0)
{
	$action = "Create";
	if ($ticket->poNumberId)
	{
		$action = "Change";
	}
	$old = new poNumber($ticket->poNumberId);
	$ticket->poNumberId = $poNumberId;
	$po = new poNumber($ticket->poNumberId);
	DebugText("po:".$po->poNumber);
	$historyVal = CreateHistory($action,"PO Number",$old->poNumber,$po->poNumber);
    DebugText("history:".$historyVal);
    if (strlen($historyVal))
    {
    	array_push($historyArray,$historyVal);
    }
	$action = "Create";
	if (strlen($ticket->insuranceRepair))
	{
		$action = "Change";
	}
	$old = $ticket->insuranceRepair;
	$ticket->insuranceRepair = $insuranceRepair;
	$historyVal = CreateHistory($action,"Insurance Repair",$old,$ticket->insuranceRepair);
	DebugText("history:".$historyVal);
	if (strlen($historyVal))
	{
		array_push($historyArray,$historyVal);
	}

	if ($insuranceRepair == "Yes")
	{
		if ($ticket->repairCost != $repairCost)
		{
			$action = "Create";
			if (strlen($ticket->repairCost))
			{
				$action = "Change";
			}
			$old = $ticket->repairCost;
			$ticket->repairCost = $repairCost;
			$historyVal = CreateHistory($action,"Repair Cost",$old,$ticket->repairCost);
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}
		}
		if ($ticket->insuranceRepairComplete != $repairComplete)
		{
			$action = "Create";
			if (strlen($ticket->insuranceRepairComplete))
			{
				$action = "Change";
			}
			$old = $ticket->insuranceRepairComplete;
			$ticket->insuranceRepairComplete = $repairComplete;
			$historyVal = CreateHistory($action,"Repair Complete",$old,$ticket->insuranceRepairComplete);
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}
		}
		if ($ticket->insurancePayment != $insurancePayment)
		{
			$action = "Create";
			if (strlen($ticket->insurancePayment))
			{
				$action = "Change";
			}
			$old = $ticket->insurancePayment;
			$ticket->insurancePayment = $insurancePayment;
			$historyVal = CreateHistory($action,"Insurance Payment",$old,$ticket->insurancePayment);
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}
		}
		
	}
	else
	{
		$ticket->repairCost = "";
		$ticket->insuranceRepairComplete = "";
		$ticket->insurancePayment = "";
	}
	$ticket->Update();
	if (strlen($ticket->insuranceRepairComplete) && strlen($ticket->insurancePayment))
	{
		$action = "Change";
		$old = new Status($ticket->statusId);
		$ticket->statusId = $closedId;
		$status = new Status($ticket->statusId);
		$historyVal = CreateHistory($action,"Status",$old->name,$status->name);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
			array_push($historyArray,$historyVal);
		}
	}

	$ticket->Persist();
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
else
{
	$html = "<ul>".$errMsg."</ul>";
	$_SESSION['insurancepoNumberId'] = $poNumberId;
	$_SESSION['insuranceRepairComplete'] = $repairComplete;
	$_SESSION['insuranceRepairCost'] = $repairCost;
	$_SESSION['insurancePayment'] = $insurancePayment;
	$_SESSION['paymentMade'] = $paymentMade;
	$_SESSION['repairMade'] = $repairMade;
	$_SESSION['formErrors'] = $html;
	
}
DebugPause("/ticketInsurance/".$ticketId."/");
?>