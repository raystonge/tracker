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
include_once "tracker/assetToAsset.php";
if (!validateFormKey("ticketAdd"))
{
	exit(0);
}
$assetToAsset = New AssetToAsset();
$assetId = 0;
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$numLicenses = 0;
$serialNumber = "";
if ($asset->assetId)
{
	$numLicenses = $asset->numOfLicenses;
	$serialNumber = $asset->serialNumber;
  $assetSerialNumber = GetTextField("assetSerialNumber");
  $searchAssetName = GetTextField("searchAssetName");
  $assetAssetTag = GetTextField("assetAssetTag");
  $searchBuildingId = GetTextField("searchBuildingId",0);
  $searchAssetTypeId = GetTextField("searchAssetTypeId",0);
  $assetId = GetTextField("assetId");
  $assets = new Set(",");
  $assetToAsset = new AssetToAsset();
  $param = AddEscapedParam("","assetId1",$assetId);

  $ok = $assetToAsset->Get($param);
  while ($ok)
  {
	$assets->Add($assetToAsset->assetId2);
	$ok = $assetToAsset->Next();
  }
  $param = "";
  if (strlen($assets->data))
  {
  	$param = "assetId not in (".$assets->data.")";
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
  		$assetToAsset = new AssetToAsset();
  		$assetToAsset->assetId1 = $assetId;
  		$assetToAsset->assetId2 = $asset->assetId;
  		DebugText("Adding:".$asset->assetId." to ".$assetId);
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
  		if (strlen($serialNumber))
  		{
  			$assetToAsset->serialNumber = $serialNumber;
  		}
  		$assetToAsset->Insert();
  	}
  	DebugText("inUse:".$assetToAsset->LicensesInUse($assetId));
  	DebugText("numLicenses:".$numLicenses);

  	if ($assetToAsset->LicensesInUse($assetId) < $numLicenses)
  	{
  		$ok = $asset->Next();
  	}
  	else
  	{
  		$ok = 0;
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
?>
