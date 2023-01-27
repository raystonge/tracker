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
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/assetToTicket.php";
if (!validateFormKey("ticketAdd"))
{
	exit(0);
}
$assetId = 0;
$ticketId = GetTextField("ticketId",0);
$ticket = new Ticket($ticketId);
DebugText("ticketId:".$ticket->ticketId);
$historyArray = array();

if ($ticket->ticketId)
{
  $assetSerialNumber = GetTextField("assetSerialNumber");
  $searchAssetName = GetTextField("searchAssetName");
  $assetAssetTag = GetTextField("assetAssetTag");
  $searchBuildingId = GetTextField("searchBuildingId",0);
  $searchAssetTypeId = GetTextField("searchAssetTypeId",0);
  $ticketId = GetTextField("ticketId");
  $tickets = new Set(",");
  $assetToTicket = new AssetToTicket();

  $ok = $assetToTicket->GetByTicket($ticketId);
  while ($ok)
  {
	$tickets->Add($assetToTicket->assetId);
	$ok = $assetToTicket->Next();
  }
  $param = "";
  if (strlen($tickets->data))
  {
  	$param = "assetId not in (".$tickets->data.")";
  }
  $param = AddEscapedParamIfNotBlank($param,"serialNumber",$assetSerialNumber);
  $param = AddEscapedParamIfNotBlank($param,"assetTag",$assetAssetTag);
  $param = AddEscapedLikeParamIfNotBlank($param,"name",$searchAssetName);
  if ($searchAssetTypeId)
  {
  	$param = AddParam($param,"assetTypeId=".$searchAssetTypeId);
  }
  if ($searchBuildingId)
  {
  	$param = AddParam($param,"buildingId=".$searchBuildingId);
  }
  $asset = new Asset();
  $ok = $asset->Get($param);
  while ($ok)
  {
  	$field = "asset".$asset->assetId;
  	if (isset($_POST[$field]))
  	{
  		$assetToTicket = new AssetToTicket();
  		$assetToTicket->ticketId = $ticket->ticketId;
  		$assetToTicket->assetId = $asset->assetId;
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
  	$ok = $asset->Next();
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

//DebugOutput();
?>
