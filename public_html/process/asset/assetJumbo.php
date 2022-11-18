<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/comment.php";
include_once "tracker/set.php";
include_once "tracker/assetToContract.php";
include_once "tracker/assetCondition.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/poNumber.php";

ProperAccessValidate();

$assets = "";
$assetIds = new Set(",");
if (isset($_POST['assetIds']))
{
	$assets = $_POST['assetIds'];
}
$action = "Change";
$assetIds->SetData($assets);
while ($assetIds->GetIndex() >=0)
{
	$assetId = $assetIds->GetValue();
	$asset = new Asset($assetId);
	if (isset($_POST['assetTypeId']))
	{
		if ($_POST['assetTypeId'] > 0)
		{
			$assetTypeId = $_POST['assetTypeId'];
			$old = new AssetType($asset->assetTypeId);
			$asset->assetTypeId = $assetTypeId;
			$assetType = new AssetType($assetTypeId);
		    $historyVal = CreateHistory($action,"Asset Type", $old->name,$assetType->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
	}
	if (isset($_POST['make']))
	{
		$make = trim($_POST['make']);
		if ($make != "--do_not_change--")
		{
			$old = $asset->make;
			$asset->make = $make;
		    $historyVal = CreateHistory($action,"Make", $old,$make);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['model']))
	{
		$model = trim($_POST['model']);
		if ($model != "--do_not_change--")
		{
			$old = $asset->model;
			$asset->model = $model;
		    $historyVal = CreateHistory($action,"Model", $old,$model);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['modelNumber']))
	{
		$modelNumber = trim($_POST['modelNumber']);
		if ($modelNumber != "--do_not_change--")
		{
			$old = $asset->modelNumber;
			$asset->modelNumber = $modelNumber;
		    $historyVal = CreateHistory($action,"Model Number", $old,$modelNumber);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['vendor']))
	{
		$vendor = trim($_POST['vendor']);
		if ($vendor != "--do_not_change--")
		{
			$old = $asset->vendor;
			$asset->vendor = $vendor;
		    $historyVal = CreateHistory($action,"Vendor", $old,$vendor);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['buildingLocation']))
	{
		$val = trim($_POST['buildingLocation']);
		if ($val != "--do_not_change--")
		{
			$asset->buildingLocation = $val;
		}
	}
	if (isset($_POST['assetpoNumberId']))
	{
		$poNumberId = trim($_POST['assetpoNumberId']);
		if ($poNumberId != "--do_not_change--")
		{
			$old = new poNumber($asset->poNumberId);
			$asset->poNumberId = $poNumberId;
			$poNumber = new poNumber($poNumberId);
		    $historyVal = CreateHistory($action,"PO Number", $old->poNumber,$poNumber->poNumber);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['conditionId']))
	{
		if ($_POST['conditionId'] > 0)
		{
			$conditionId = $_POST['conditionId'];
			$old = new AssetCondition($asset->assetConditionId);
			$asset->assetConditionId = $conditionId;
			$assetCondition = new AssetCondition($conditionId);
		    $historyVal = CreateHistory($action,"Condition", $old->name,$assetCondition->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
	}
	if (isset($_POST['buildingId']))
	{
		if ($_POST['buildingId'] > 0)
		{
			$buildingId = $_POST['buildingId'];
			$old = new Building($asset->buildingId);
			$asset->buildingId = $buildingId;
			$building = new Building($buildingId);
		    $historyVal = CreateHistory($action,"Building", $old->name,$building->name);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}

	if (isset($_POST['useAquireDate']))
	{
		$aquireDate = GetDateField("aquireDate");
		if (strlen($aquireDate))
		{
			$old = $asset->aquireDate;
			$asset->aquireDate = $aquireDate;
		    $historyVal = CreateHistory($action,"Aquire Date", $old,$aquireDate);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }
		}
	}
	if (isset($_POST['useWarrantyDate']))
	{
		$warrantyDate = GetDateField("warrantyDate");
		if (strlen($warrantyDate))
		{
			$old = $asset->warrantyDate;
			$asset->warrantyDate = $warrantyDate;
		    $historyVal = CreateHistory($action,"Warranty Date", $old,$warrantyDate);
		    DebugText("history:".$historyVal);
		    if (strlen($historyVal))
		    {
		    	array_push($historyArray,$historyVal);
		    }

		}
	}

	if ($asset->Update())
	{
		if (isset($_POST['description']))
		{
			$commentText = trim($_POST['description']);
			if (strlen($commentText))
			{
				$comment = new Comment();
				$comment->assetId = $asset->assetId;
				$comment->comment = $commentText;
				$comment->Persist();
			}
		}
		if (isset($_POST['contractId']))
		{
			if ($_POST['contractId'] != "--do_not_change--")
			{
				$assetToContract = new AssetToContract();
				$assetToContract->Get("assetId=".$asset->assetId);
				$assetToContract->contractId = $_POST['contractId'];
				$assetToContract->assetId = $asset->assetId;
				$assetToContract->Persist();
			}
		}
		$historyVal = array_pop($historyArray);
		DebugText("sizeof History:".sizeof($historyArray));
		while (strlen($historyVal))
		{
			DebugText("historyVal:".$historyVal);
			$history = new History();
			$history->assetId = $asset->assetId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = $historyVal;
			$history->Insert();
			$historyVal = array_pop($historyArray);
		}
	}
}
$moduleId = GetTextFromSession("moduleId",0);
if ($moduleId)
{
	DebugPause("/viewReports/".$moduleId."/");
	exit();
}
DebugPause("/listAssets/");
?>
