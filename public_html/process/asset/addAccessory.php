<?php
include_once 'globals.php';
include_once 'tracker/asset.php';
include_once 'tracker/assetToAsset.php';
include_once 'tracker/assetType.php';
include_once 'tracker/history.php';
ProperAccessTest("addAccessory");
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$employeeName = $asset->employeeName;
//$param = AddEscapedParam("","organizationId",$asset->organizationId);
$param = "";
$ok = $asset->Get($param);
$showButton = $ok;
while ($ok)
{
	$assetType = new assetType($asset->assetTypeId);
	$field = "asset".$asset->assetId;
	DebugText("field:".$field);
	DebugText("isAccessory:".$assetType->isAccessory);
	DebugText("isset:".isset($_POST[$field]));

	if ($assetType->isAccessory && isset($_POST[$field]))
	{
		$assetPair = new AssetToAsset();
		$assetPair->assetId1 = $assetId;
		$assetPair->assetId2 = $asset->assetId;
		$assetPair->Insert();
		DebugText("asset-employeeName:".$asset->employeeName);
		DebugText("employeeName:".$employeeName);
		if ($asset->employeeName != $employeeName)
		{
			$old = $asset->employeeName;
			$asset->employeeName = $employeeName;
			$asset->Persist();
			$historyVal = CreateHistory("Change","Employee Name", $old,$employeeName);
			$history = new History();
			$history->assetId = $asset->assetId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = $historyVal;
			$history->Insert();
		}
	}
	$ok = $asset->Next();
}

DebugPause("/accessory/".$assetId."/");
