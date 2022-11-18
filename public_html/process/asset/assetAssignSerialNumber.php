<?php
/*
 * Created on Feb 26, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/assetToAsset.php";
$_SESSION['formErrors'] ="";
$_SESSION['formSuccess'] = "";
ProperAccessValidate();
$status='fail';
$html="";
$errorMsg  = "";
$numErrors = 0;

$assetToAssetId = GetTextField("assetToAssetId");
$serialNumber = GetTextField("serialNumber");
$assetToAsset = new AssetToAsset($assetToAssetId);
if (strlen($serialNumber)==0)
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify a SerialNumber</li>";
}
$action = "Create";
if ($numErrors == 0)
{
	if ($assetToAsset->serialNumber != $serialNumber)
	{
		$oldSerialNumber = $assetToAsset->serialNumber;
		$assetToAsset->serialNumber = $serialNumber;
		$historyVal = CreateHistory($action,"Serial Number",$oldSerialNumber,$serialNumber);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
		  	array_push($historyArray,$historyVal);
		}		
		$assetToAsset->Update();
	} 
	$historyVal = array_pop($historyArray);
	DebugText("sizeof History:".sizeof($historyArray));
	while (strlen($historyVal))
	{
		DebugText("historyVal:".$historyVal);
		$history = new History();
		$history->assetId = $assetToAsset->assetId1;
		$history->userId = $_SESSION['userId'];
		$history->actionDate = $now;
		$history->action = $historyVal;
		$history->Insert();
		$history->assetId = $assetToAsset->assetId2;
		$history->Insert();
		$historyVal = array_pop($historyArray);
	}		
	$_SESSION['formSuccess'] = "Success";
}
else
{
	$html = "<ul>".$errorMsg."</ul>";
	$_SESSION['formErrors'] = $html;
	$_SESSION['assetSerialNumber'] = $serialNumber;	
}
DebugPause("/assetAssignSerialNumber/".$assetToAsset->assetToAssetId."/");
?>