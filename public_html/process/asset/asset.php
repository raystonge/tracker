<?php
/*
 * Created on Aug 7, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/comment.php";
include_once "tracker/assetCondition.php";
include_once "tracker/poNumber.php";
include_once "tracker/organization.php";
include_once "tracker/assetToAsset.php";
include_once "tracker/contract.php";
include_once "tracker/assetToContract.php";


$_SESSION['formErrors'] ="";
$_SESSION['assetSerialNumber'] = "";
$_SESSION['assetAssetTag'] = "";
$_SESSION['assetBuildingId'] = "";
$_SESSION['assetConditionId'] = "";
$_SESSION['assetBuildingLocation'] = "";
$_SESSION['assetAssetType'] = "";
$_SESSION['assetMake'] = "";
$_SESSION['assetModel'] = "";
$_SESSION['assetModelNumber'] = "";
$_SESSION['assetComment'] = "";
$_SESSION['assetPONumberId'] = "";
$_SESSION['assetVendor'] = "";
$_SESSION['assetAquireDate'] = "";
$_SESSION['assetEmployeeName'] = "";
$_SESSION['assetNumOfLicenses'] = "";
$_SESSION['assetExpireDate'] = "";
$_SESSION['assetWarrantyDate'] = "";
$_SESSION['assetOrganizationId'] = 0;
//ProperAccessValidate();
if (isset($_POST['submitTest']))
{
	$asset = new Asset();
	$assetId = 0;
	$assetTypeId = 0;
	$assetTag = "";
	$make = "";
	$model = "";
	$modelNumber = "";
	$conditionId = 0;
	$buildingId = 0;
	$buildingLocation = "";
	$poNumberId = 0;
	$vendor = "";
	$aquireDate = "";
	$expireDate = "";
	$numOfLicenses = 0;
	$organizationId = 0;
	$warrantyDate = "";
	$validated = false;
	$status='fail';
	$html="";
	$serialNumber = "";
	$assetTag = "";
	$mac = "";
	$name = "";
	$conditionId = 0;
	$commentText = "";
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;

	if (isset($_POST['assetId']))
	{
		$assetId=strip_tags($_POST['assetId']);
		$asset->GetById($assetId);
	}
	$organizationId = GetTextField("organizationId",0);
	$assetTag = GetTextField("assetTag",$asset->assetTag);
	$assetTypeId = GetDropDownField('assetTypeId');
	$serialNumber = GetTextField('serialNumber');
	$mac = GetTextField('macAddress');
	$make = GetTextField('make');
	$model = GetTextField('model');
	$modelNumber = GetTextField('modelNumber');
	$name = GetTextField('name');
	$employeeName = GetTextField('employeeName');
	$conditionId = GetDropDownField('assetConditionId');
	$buildingId = GetDropDownField('buildingId');
	$buildingLocation = GetTextField('buildingLocation');
	$poNumberId = GetTextField('poNumberId');
	$vendor = GetTextField('vendor');
	$aquireDate = DatePickerUnFormatter(GetDateField('aquireDate'));
	$commentText = GetTextField('description');
	$expireDate = GetDateField("expireDate");
	$warrantyDate = DatePickerUnFormatter(GetDateField("warrantyDate"));
	$enableWarrantyDate = GetTextField("enableWarranty",0);
	$cost = GetTextField("cost",0);
	if ($asset->assetId && (strlen($assetTag)==0))
	{
		$ogranization = new Organization($organizationId);
		$assetTag = $ogranization->assetPrefix."-".$asset->assetId;
	}
	if (!$enableWarrantyDate)
	{
		$warrantyDate = "";
	}

	DebugText("enableWarrantyDate:".$enableWarrantyDate);
	DebugText("warrantyDate:".$warrantyDate);
	$numOfLicenses = GetTextField("numOfLicenses",0);
	$assetType = new AssetType($assetTypeId);

	if (!$organizationId && $permission->hasPermission("Asset: Edit: Organization"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify ".$orgOrDept."</li>";
	}

	if ((strlen($serialNumber) == 0) && (!$assetType->noSerialNumber) && ($assetType->name <> "Software") && $permission->hasPermission("Asset: Edit: Serial Number"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Serial Number</li>";
	}
	if ($buildingId == 0 && $permission->hasPermission("Asset: Edit: Building"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a Building</li>";

	}
	if ($assetTypeId == 0 && $permission->hasPermission("Asset: Edit: Asset Type"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify an Asset Type</li>";

	}
	if (($conditionId == 0) && ($assetType->name <> "Software")  && $permission->hasPermission("Asset: Edit: Condition"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify an Asset Condition</li>";

	}
	if (strlen($make) == 0 && $permission->hasPermission("Asset: Edit: Make"))
	{
		$numErrors++;
		if ($assetType->name <> "Software")
		{
			$errorMsg=$errorMsg."<li>Please Specify a Make</li>";
		}
		else
		{
			$errorMsg=$errorMsg."<li>Please Specify a Software Company</li>";
		}

	}
	if (($numOfLicenses == 0) && ($assetType->name == "Software"))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Number of Licenses</li>";
	}
	if (!$asset->assetId && !$cost)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Cost must be specified</li>";
	}

	if ($numErrors ==0)
	{
		$action = "Create";
		if ($assetId)
		{
			$action = "Change";
		}
		$asset->assetId = $assetId;
		if ($asset->organizationId != $organizationId)
		{
			$oldOrganization = new Organization($asset->organizationId);
			$asset->organizationId = $organizationId;
			$organization = new Organization($organizationId);
	    $historyVal = CreateHistory($action,$orgOrDept,$oldOrganization->name,$organization->name);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->serialNumber != $serialNumber)
		{
			$oldSerialNumber = $asset->serialNumber;
			$asset->serialNumber = $serialNumber;
	    $historyVal = CreateHistory($action,"Serial Number",$oldSerialNumber,$serialNumber);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->assetTag != $assetTag)
		{
			$old = $asset->assetTag;
			$asset->assetTag = $assetTag;
	    $historyVal = CreateHistory($action,"Asset Tag", $old,$assetTag);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->assetTypeId != $assetTypeId)
		{
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
		$assetType = new AssetType($asset->assetTypeId);
		if ($asset->buildingId != $buildingId)
		{
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
		if ($asset->assetConditionId != $conditionId)
		{
			$old = new AssetCondition($asset->buildingId);
			$asset->assetConditionId = $conditionId;
			$assetCondition = new AssetCondition($conditionId);
	    $historyVal = CreateHistory($action,"Condition", $old->name,$assetCondition->name);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->buildingLocation != $buildingLocation)
		{
			$old = $asset->buildingLocation;
			$asset->buildingLocation = $buildingLocation;
	    $historyVal = CreateHistory($action,"Building Location", $old,$buildingLocation);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->make != $make)
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
		if ($asset->model != $model)
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
		if ($asset->modelNumber != $modelNumber)
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
		if ($asset->vendor != $vendor)
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
		if ($asset->poNumberId != $poNumberId)
		{
			$oldPO = new poNumber($asset->poNumberId);
			$old = $oldPO->poNumber;
			$asset->poNumberId = $poNumberId;
			$po = new poNumber($poNumberId);
	    $historyVal = CreateHistory($action,"PO Number", $old,$po->poNumber);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
    }
    $po = new poNumber($poNumberId);
    $param = AddEscapedParam("","poNumberId",$poNumberId);
    $contract = new Contract();
    $contract->Get($param);
      if ($poNumberId && $contract->contractId && !$asset->contractId)
      {
        $assetToContract = new AssetToContract();
        $param = AddEscapedParam("","assetId",$asset->assetId);
        $assetToContract->Get($param);
        $assetToContract->assetId = $asset->assetId;
        $assetToContract->contractId = $contract->contractId;
        $assetToContract->Persist();
        $oldContract = new Contract($asset->contractId);
        $old = $oldContract->name;
        $asset->contractId = $contract->contractId;
      //  $contract = new Contract($po->contractId);
        $historyVal = CreateHistory($action,"Contract", $old,$contract->name);
        DebugText("history:".$historyVal);
        if (strlen($historyVal))
        {
          array_push($historyArray,$historyVal);
        }
      }


		if ($asset->purchasePrice != $cost)
		{
			$oldCost = $asset->purchasePrice;
			$asset->purchasePrice = $cost;
			$historyVal = CreateHistory($action,"Cost ", $oldCost,$cost);
			DebugText("history:".$historyVal);
			if (strlen($historyVal))
			{
				array_push($historyArray,$historyVal);
			}
		}


		if ($asset->aquireDate != $aquireDate)
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
		if ($asset->macAddress != $mac)
		{
			$old = $asset->macAddress;
			$asset->macAddress = $mac;
	    $historyVal = CreateHistory($action,"MAC Address", $old,$mac);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->employeeName != $employeeName)
		{
			$old = $asset->employeeName;
			$asset->employeeName = $employeeName;
	    $historyVal = CreateHistory($action,"Employee Name", $old,$employeeName);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->name != $name)
		{
			$old = $asset->name;
			$asset->name = $name;
	    $historyVal = CreateHistory($action,"Name", $old,$name);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->expireDate != $expireDate)
		{
			$old = $asset->expireDate;
			$asset->expireDate = $expireDate;
	    $historyVal = CreateHistory($action,"Expire Date", $old,$expireDate);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}
		if ($asset->warrantyDate != $warrantyDate)
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
		if ($asset->numOfLicenses != $numOfLicenses)
		{
			$old = $asset->numOfLicenses;
			$asset->numOfLicenses = $numOfLicenses;
	    $historyVal = CreateHistory($action,"Number of Licenses", $old,$numOfLicenses);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	    	array_push($historyArray,$historyVal);
	    }
		}

    $contract = new Contract();
		$param = AddEscapedParam("isLease=1","poNumberId".$asset->poNumberId);
		$contract->Get($param);
		$asset->contractId = $contract->contractId;
		$asset->leased = $contract->isLease;
		if ($asset->assetId)
		{
			$asset->Update();
		}
		else
		{
			$asset->creatorId = $_SESSION['userId'];
			$asset->Insert();
			if (strlen($assetTag) == 0)
			{
				$organization = new Organization($organizationId);
				$assetTag = $organization->assetPrefix."-".$asset->assetId;
			}
			if ($asset->assetTag != $assetTag)
			{
				$old = $asset->assetTag;
		    $asset->assetTag = $assetTag;
        $historyVal = CreateHistory($action,"Asset Tag", $old,$assetTag);
        DebugText("history:".$historyVal);
        if (strlen($historyVal))
        {
	    	  array_push($historyArray,$historyVal);
        }
	    }
		}
		if (strlen($commentText))
		{
			$comment = new Comment();
			$comment->assetId = $asset->assetId;
			$comment->comment = $commentText;
			$comment->Persist();
			$historyVal = "Added Comment";
			array_push($historyArray,$historyVal);

		}
		if ($assetType->hasAccessory)
		{
			$assetId = $asset->assetId;
			$assetToAsset = new AssetToAsset();
			$param = AddEscapedParam("","assetId1",$assetId);
			$ok = $assetToAsset->Get($param);
			while ($ok)
			{
				$history = new History();
				$assetAccessory = new Asset($assetToAsset->assetId2);
				$history->assetId = $assetAccessory->assetId;
				$oldName = $assetAccessory->employeeName;
				$assetAccessory->employeeName = $employeeName;
				$assetAccessory->Persist();
				$history->userId = $_SESSION['userId'];
				$history->actionDate = $now;
				$history->action = "Changed employeeName from ".$oldName." to ".$assetAccessory->employeeName;
				$history->Insert();
				$ok = $assetToAsset->Next();
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
		$asset->Update();
		DebugPause("/assetEdit/$asset->assetId/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";

		$_SESSION['formErrors'] = $html;
		$_SESSION['assetSerialNumber'] = $serialNumber;
		$_SESSION['assetAssetTag'] = $assetTag;
		$_SESSION['assetBuildingId'] = $buildingId;
		$_SESSION['assetBuildingLocation'] = $buildingLocation;
		$_SESSION['assetAssetType'] = $assetTypeId;
		$_SESSION['assetMake'] = $make;
		$_SESSION['assetModel'] = $model;
		$_SESSION['assetModelNumber'] = $modelNumber;
		$_SESSION['assetComment'] = $commentText;
		$_SESSION['assetPONumberId'] = $poNumberId;
		$_SESSION['assetVendor'] = $vendor;
		$_SESSION['assetMacAddress'] = $mac;
		$_SESSION['assetAquireDate'] = $aquireDate;
		$_SESSION['assetConditionId'] = $conditionId;
		$_SESSION['assetEmployeeName'] = $employeeName;
		$_SESSION['assetName'] = $name;
		$_SESSION['assetOrganizationId'] = $organizationId;
		if ($asset->assetId)
		{
			DebugPause("/assetEdit/$asset->assetId/");
		}
		DebugPause("/assetNew/");
	}
}
DebugPause("/listAssets/");
?>
