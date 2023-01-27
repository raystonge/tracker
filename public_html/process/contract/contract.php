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
include "globals.php";
include_once "tracker/contract.php";
include_once "tracker/poNumber.php";
include_once "tracker/asset.php";
include_once "tracker/comment.php";
ProperAccessValidate();
$errorMsg  = "";
$numErrors = 0;
$cnt = 0;

$contractId = GetTextField("contractId",0);
$contract = new Contract($contractId);
$name = GetTextField("name");
$address1 = GetTextField("address1");
$address2 = GetTextField("address2");
$city = GetTextField("city");
$state = GetTextField("state");
$zipCode = GetTextField("zipCode");
$phone = GetTextField("phone");
$fax = GetTextField("fax");
$email = GetTextField("email");
$contactName = GetTextField("contactName");
$contactPhone = GetTextField("contactPhone");
$contactEmail = GetTextField("contactEmail");
$supportName = GetTextField("supportName");
$supportPhone = GetTextField("supportPhone");
$supportEmail = GetTextField("supportEmail");
$expireDate = DatePickerUnFormatter(GetDateField("expireDate"));
DebugText("expireDate:".$expireDate);
$commentText = GetTextField("description");
$contractNumber = GetTextField("contractNumber");
$poNumberId = GetTextField("poNumberId",0);
$organizationId = GetTextField("organizationId",0);
$isLease = GetTextField("isLease",0);
if ($organizationId == 0)
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify ".$orgOrDept."</li>";
}

if (!strlen($name))
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify Name</li>";
}
if ($isLease && !$poNumberId)
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Cannot have a lease without a Purchase Order</li>";
}
/*
if ($poNumberId == 0)
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify PO Number</li>";
}
*/
if (!$numErrors)
{
	$action = "Create";

	if ($organizationId)
	{
		$action = "Change";
	}
	$contract->organizationId = $organizationId;
	if ($contract->name != $name)
	{
		$old = $contract->name;
		$contract->name = $name;
	    $historyVal = CreateHistory($action,"Name",$old,$name);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}

	if ($contractId)
	{
		$action = "Change";
	}
	$contract->contractId = $contractId;
	if ($contract->name != $name)
	{
		$old = $contract->name;
		$contract->name = $name;
	    $historyVal = CreateHistory($action,"Name",$old,$name);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->address1 != $address1)
	{
		$old = $contract->address1;
		$contract->address1 = $address1;
	    $historyVal = CreateHistory($action,"Address 1",$old,$address1);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->city != $city)
	{
		$old = $contract->city;
		$contract->city = $city;
	    $historyVal = CreateHistory($action,"City",$old,$city);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->state != $state)
	{
		$old = $contract->state;
		$contract->state = $state;
	    $historyVal = CreateHistory($action,"State",$old,$state);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->zipCode != $zipCode)
	{
		$old = $contract->zipCode;
		$contract->zipCode = $zipCode;
	    $historyVal = CreateHistory($action,"Zip Code",$old,$zipCode);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->phone != $phone)
	{
		$old = $contract->phone;
		$contract->phone = $phone;
	    $historyVal = CreateHistory($action,"Phone",$old,$phone);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->fax != $fax)
	{
		$old = $contract->fax;
		$contract->fax = $fax;
	    $historyVal = CreateHistory($action,"Fax",$old,$fax);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->contractNumber != $contractNumber)
	{
		$old = $contract->contractNumber;
		$contract->contractNumber = $contractNumber;
	    $historyVal = CreateHistory($action,"Contract Number",$old,$contractNumber);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->poNumberId != $poNumberId)
	{
		$old = new poNumber($contract->poNumberId);
		$contract->poNumberId = $poNumberId;
		$po = new poNumber($poNumberId);
	    $historyVal = CreateHistory($action,"PO Number",$old->poNumber,$po->poNumber);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}

	if ($contract->expireDate != $expireDate)
	{
		$old = $contract->expireDate;
		$contract->expireDate = $expireDate;
	    $historyVal = CreateHistory($action,"Expire Date",$old,$expireDate);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->contactName != $contactName)
	{
		$old = $contract->contactName;
		$contract->contactName = $contactName;
	    $historyVal = CreateHistory($action,"Contact Name",$old,$contactName);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->contactPhone != $contactPhone)
	{
		$old = $contract->contactPhone;
		$contract->contactPhone = $contactPhone;
	    $historyVal = CreateHistory($action,"Contact Phone",$old,$supportName);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->contactEmail != $contactEmail)
	{
		$old = $contract->contactEmail;
		$contract->contactEmail = $contactEmail;
	    $historyVal = CreateHistory($action,"Contact Email",$old,$contactEmail);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->supportName != $supportName)
	{
		$old = $contract->supportName;
		$contract->supportName = $supportName;
	    $historyVal = CreateHistory($action,"Support Name",$old,$contactName);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->supportPhone != $supportPhone)
	{
		$old = $contract->supportPhone;
		$contract->supportPhone = $supportPhone;
	    $historyVal = CreateHistory($action,"Support Phone",$old,$supportPhone);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}
	if ($contract->supportEmail != $supportEmail)
	{
		$old = $contract->supportEmail;
		$contract->supportEmail = $supportEmail;
	    $historyVal = CreateHistory($action,"Support Email",$old,$supportEmail);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}

	if ($contract->isLease != $isLease)
	{
		$old = "Not a lease";
		if ($contract->isLease)
		{
			$old = "Was a lease";
		}
		$contract->isLease = $isLease;
		$newLease = "Not a lease";
		if ($contract->isLease)
		{
			$newLease = "Is a lease";
		}

	    $historyVal = CreateHistory($action,"Lease",$old,$newLease);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
	}

	$contract->Persist();
	$asset = new Asset();
	$param = AddEscapedParam("","poNumberId",$contract->poNumberId);
	$ok = $asset->Get($param);
	while ($ok)
	{
		$asset->leased = $contract->isLease;
		$asset->contractId = $contract->contractId;
		$asset->Persist();
		$ok = $asset->Next();
	}
	if (strlen($commentText))
	{
		$comment = new Comment();
		$comment->contractId = $contract->contractId;
		$comment->comment = $commentText;
		$comment->organizationId = $organizationId;
		$comment->Persist();
		$historyVal = "Added Comment";
		array_push($historyArray,$historyVal);
	}
	$historyVal = array_pop($historyArray);
	DebugText("sizeof History:".sizeof($historyArray));
	while (strlen($historyVal))
	{
		DebugText("historyVal:".$historyVal);
		$history = new History();
		$history->contractId = $contract->contractId;
		$history->userId = $_SESSION['userId'];
		$history->actionDate = $now;
		$history->action = $historyVal;
		$history->Insert();
		$historyVal = array_pop($historyArray);
	}

	DebugPause("/contractEdit/".$contract->contractId."/");
	exit;
}
$html = "<ul>".$errorMsg."</ul>";
$_SESSION['contractName']=$name;
$_SESSION['contractAddress1'] = $address1;
$_SESSION['contractAddress2'] = $address2;
$_SESSION['contractCity'] = $city;
$_SESSION['contractState'] = $state;
$_SESSION['contractZipCode'] = $zipCode;
$_SESSION['contractPhone'] = $phone;
$_SESSION['contractFax'] = $fax;
$_SESSION['contractEmail'] = $email;
$_SESSION['contractContactName'] = $contactName;
$_SESSION['contractContactPhone'] = $contactPhone;
$_SESSION['contractContactEmail'] = $email;
$_SESSION['contractSupportName'] = $supportName;
$_SESSION['contractSupportPhone'] = $supportPhone;
$_SESSION['contractSupportEmail'] = $supportEmail;
$_SESSION['contractContractNumber'] = $contractNumber;
$_SESSION['contractExpireDate'] = $expireDate;
$_SESSION['contractComment'] = $commentText;
$_SESSION['contractpoNumberId'] = $poNumberId;
$_SESSION['contractOrganizationId'] = $organizationId;
$_SESSION['contractIsLease'] = $isLease;
$_SESSION['formErrors'] = $html;
if ($contract->contractId)
{
	DebugPause("/contractEdit/".$contract->contractId."/");
}
DebugPause("/newContract/");
?>
