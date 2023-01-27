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
include_once "tracker/assetToAsset.php";
include_once "tracker/asset.php";

$assetId = GetTextField("assetId",0);
if (!$assetId)
{
	exit();
}
$assetToAsset = new AssetToAsset();
$ok = $assetToAsset->Get("assetId1=".$assetId);
while ($ok)
{
	$field = "attachedAsset".$assetToAsset->assetId2;
	$asset = new Asset($assetToAsset->assetId2);
	$historyText = "";
	if (GetTextField($field,0))
	{
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
		$assetToAsset->Delete();
	}
	if (strlen($historyText))
	{
		$historyVal = "Removed Asset ".$historyText;
		array_push($historyArray,$historyVal);
	}
	$assetToAsset->Delete();
	$ok = $assetToAsset->Next();
}
$historyVal = array_pop($historyArray);
DebugText("sizeof History:".sizeof($historyArray));
while (strlen($historyVal))
{
	DebugText("historyVal:".$historyVal);
	$history = new History();
	$history->assetId = $assetId;
	$history->userId = $_SESSION['userId'];
	$history->actionDate = $now;
	$history->action = $historyVal;
	$history->Insert();
	$historyVal = array_pop($historyArray);
}
//DebugOutput();
?>
