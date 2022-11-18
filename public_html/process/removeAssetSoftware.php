<?php
/*
 * Created on Feb 17, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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