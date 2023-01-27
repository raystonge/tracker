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
include_once "tracker/poNumber.php";
include_once "tracker/organization.php";
include_once "tracker/comment.php";
ProperAccessValidate();
//$currentUser = new User(GetTextFromSession("userId",0,0));
$_SESSION['formErrors'] ="";
$po = new poNumber();
$errorMsg = "";

if (isset($_POST['submitTest']))
{
	$status='fail';
	$html="";
	$organizationId = GetTextField("organizationId",0);
	$poNumberId = GetTextField("poNumberId");
	$poNumber = GetTextField("poNumber");
	$vendor = GetTextField("vendor");
	$vendorOrderID = GetTextField("vendorOrderID");
	$poDate = DatePickerUnFormatter(GetDateField("poDate"));
	$poType = GetTextField("poType");
	$desc = GetTextField("description");
	$cost = GetTextField("cost");
	$reconciled = GetTextField("reconciled",0);
	$received = GetTextField("received",0);
	$commentText = GetTextField("comment");
	$numErrors = 0;
	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify ".$orgOrDept."</li>";
	}
	if (!strlen($poNumber))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a PO Number</li>";
	}
	if (!strlen($vendor))
	{
	    $numErrors++;
	    $errorMsg=$errorMsg."<li>Please Specify a Vendor</li>";
	}
	if (!strlen($poType))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a PO Type</li>";
	}
	if (!strlen($desc))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Description</li>";
	}
	DebugText("Testing poNumberId:".$poNumberId);
	if (!$poNumberId && !$cost)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Cost</li>";
	}
	if (!$received && $reconciled)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Cannot reconcile PO if it has not been received</li>";
	}
	DebugText("numErrors:".$numErrors);

	if ($numErrors == 0)
	{
		$action = "Create";
		if ($poNumberId)
		{
			$action = "Change";
		}
		if ($po->organizationId != $organizationId)
		{
			$organization = new Organization($po->organizationId);
			$oldOrganization = $organization->name;
			$po->organizationId = $organizationId;
			$organization = new Organization($organizationId);
		    $historyVal = CreateHistory($action,$orgOrDept,$oldOrganization,$organization->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
		$po->poNumberId = $poNumberId;
		if ($po->poNumber != $poNumber)
		{
			$oldSerialNumber = $po->poNumber;
			$po->poNumber = $poNumber;
		    $historyVal = CreateHistory($action,"PO Number",$oldSerialNumber,$poNumber);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
		$po->vendor = $vendor;
		if ($po->vendor != $vendor)
		{
		    $oldVendor = $po->vendor;
		    $po->vendor = $vendor;
		    $historyVal = CreateHistory($action,"Vendorr",$oldVendor,$vendor);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		        array_push($historyArray,$historyVal);
		    }

		}
		$po->vendorOrderID = $vendorOrderID;
		if ($po->vendor != $vendor)
		{
		    $oldVendorOrderID = $po->vendor;
		    $po->vendorOrderID = $vendorOrderID;
		    $historyVal = CreateHistory($action,"Vendorr",$oldVendorOrderID,$vendorOrderID);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		        array_push($historyArray,$historyVal);
		    }

		}
		if ($po->poDate != $poDate)
		{
			$old = $po->poDate;
			$po->poDate = $poDate;
		    $historyVal = CreateHistory($action,"PO Date",$old,$poDate);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
		else
		{
			if ($po->poNumberId == 0)
			{
				$old = $po->poDate;
				$po->poDate = $poDate;
				$historyVal = CreateHistory($action,"PO Date",$old,$poDate);
				DebugText("history:".$historyVal);
				if (strlen($historyVal))
				{
					array_push($historyArray,$historyVal);
				}

			}
		}
		if ($po->poType != $poType)
		{
			$old = $po->poType;
			$po->poType = $poType;
		    $historyVal = CreateHistory($action,"PO Type",$old,$poType);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
		if ($po->description != $desc)
		{
			$old = $po->description;
			$po->description = $desc;
		    $historyVal = CreateHistory($action,"Description",$old,$desc);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}

		if ($po->cost != $cost)
		{
			$old = $po->cost;
			$po->cost = $cost;
			$historyVal = CreateHistory($action,"Cost",$old,$desc);
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}

		}

		if ($po->received != $received)
		{
			$old = $po->received;
			$po->received = $received;
			$historyVal = CreateHistory($action,"Received",$old,"Received");
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}
			if ($received)
			{
				$po->receivedUserId = $currentUser->userId;
				$old = "";
				$historyVal = CreateHistory("Set","Recevied by",$old,$currentUser->fullName);
				array_push($historyArray, $historyVal);
				$po->receivedDate = $now;
				$historyVal = CreateHistory("Set","Received on",$old,$now);
				array_push($historyArray, $historyVal);
			}
			else
			{
				$po->receivedUserId = 0;
				$po->received = 0;
				$po->receivedDate = "";
				$historyVal = CreateHistory("Clear","Unreceived by","",$currentUser->fullName);
				array_push($historyArray,$historyVal);
			}

		}



		if ($po->reconciled != $reconciled)
		{
			$old = $po->reconciled;
			$po->reconciled = $reconciled;
			$historyVal = CreateHistory($action,"Reconciled",$old,"Reconciled");
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}
			if ($reconciled)
			{
				$po->reconciledUserId = $currentUser->userId;
				$old = "";
				$historyVal = CreateHistory("Set","Reconciled by",$old,$currentUser->fullName);
				array_push($historyArray, $historyVal);
				$po->reconciledDateTime = $now;
				$historyVal = CreateHistory("Set","Reconciled on",$old,$now);
				array_push($historyArray, $historyVal);
			}
			else
			{
				$po->reconciledUserId = 0;
				$po->reconciled = 0;
				$po->reconciledDateTime = "";
				$historyVal = CreateHistory("Clear","Unreconciled by","",$currentUser->fullName);
				array_push($historyArray,$historyVal);
			}

		}

		$po->Persist();
		if (strlen($commentText))
		{
			$comment = new Comment();
			$comment->poNumberId = $po->poNumberId;
			$comment->comment = $commentText;
			$comment->Persist();
			$historyVal = "Comment Added";
				//$historyVal = CreateHistory("Create","Comment added","","");
				if (strlen($historyVal))
				{
					array_push($historyArray,$historyVal);
				}

		}
  	$historyVal = array_pop($historyArray);
		DebugText("sizeof History:".sizeof($historyArray));
		while (strlen($historyVal))
		{
			DebugText("historyVal:".$historyVal);
			$history = new History();
			$history->poNumberId = $po->poNumberId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = $historyVal;
			$history->Insert();
			$historyVal = array_pop($historyArray);
		}

		$_SESSION['formSuccess'] = "Success";

		DebugPause("/poNumberEdit/".$po->poNumberId."/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['poNumberpoNumber'] = $poNumber;
		$_SESSION['poNumberpoDate'] = $poDate;
		$_SESSION['poNumberpoType'] = $poType;
		$_SESSION['poNumberDescription'] = $desc;
		$_SESSION['poNumberpoNumberId'] = $poNumberId;
		$_SESSION['poNumberOrganizationId'] = $organizationId;
		$_SESSION['poNumberReceived'] = $received;
		$_SESSION['poNumberReconciled']  = $reconciled;
		$_SESSION['poNumberCost'] = $cost;
		$_SESSION['poNumberVendor'] = $vendor;
		$_SESSION['poNumberVendorOrderID'] = $vendorOrderID;
		$_SESSION['poNumberComment'] = $commentText;
		$_SESSION['formErrors'] = $html;
		if ($poNumberId)
		{
			DebugPause("/poNumberEdit/".$poNumberId."/");
		}
		DebugPause("/poNumberNew/");
	}

}
DebugPause("/listpoNumber/");
?>
