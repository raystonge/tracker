<?php
/*
 * Created on Mar 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/status.php";
include_once "tracker/defaultUser.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
if (isset($_POST['submitTest']))
{
	$validated = false;
	$status='fail';
	$html="";

	$assignee = 0;
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;

    $assetType = new AssetType();

	if (isset($_POST['assetTypeId']))
	{
		$assetTypeId=strip_tags($_POST['assetTypeId']);
		$assetType->GetById($assetTypeId);
	}
	$name = GetTextField("name");
	$monitor = GetTextField("monitor",0);
	$hasMacAddress =GetTextField("hasMacAddress",0);
	$requireMacAddress = GetTextField("requireMacAddress",0);
	$hasContract = GetTextField("contract",0);
	$organizationId = GetTextField("organization",0);
	$hasAccessory = GetTextField("hasAccessory",0);
	$isAccessory = GetTextField("isAccessory",0);
	$hasUserPassword = GetTextField("hasUserPassword",0);
	$hasConstantDownMonitor = GetTextField("constantMonitor",0);
	$hasUserCredentials = GetTextField("hasUserCredentials",0);

	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please specify an organization<li>";
	}
	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "assetTypeId<>".$assetTypeId;
		$param = AddEscapedParam($param,"name",$name);
		$param = AddEscapedParam($param, "organizationId", $organizationId);
		$testAssetType = new AssetType();
		if ($testAssetType->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Asset Type already in use</li>";
		}
	}


	if ($numErrors ==0)
	{
		$assetType->name = $name;
		if (strlen($monitor))
		{
			$assetType->monitor = 1;
			$assetType->monitorType = $monitor;
		}
		$assetType->hasMacAddress = $hasMacAddress;
		$assetType->requireMacAddress = $requireMacAddress;
		$assetType->hasContract = $hasContract;
		$assetType->organizationId = $organizationId;
		$assetType->hasAccessory = $hasAccessory;
		$assetType->isAccessory = $isAccessory;
		$assetType->hasUserPassword = $hasUserPassword;
		$assetType->hasConstantMonitorDown = $hasConstantDownMonitor;
		$assetType->hasUserCredentials = $hasUserCredentials;
        $assetType->Persist();
		$_SESSION['assetTypeOrganizationId'] = $organizationId;
		DebugPause("/listAssetType/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;
		$_SESSION['monitor'] = $monitor;
		$_SESSION['hasMacAddress'] = $hasMacAddress;
		$_SESSION['requireMacAddress'] = $requireMacAddress;
		$_SESSION['hasContract'] = $hasContract;
		$_SESSION['organizationId'] = $organizationId;
		$_SESSION['hasAccessory'] = $hasAccessory;
		$_SESSION['isAccessory'] = $isAccessory;
		$_SESSION['hasUserPassword'] = $hasUserPassword;
		$_SESSION['hasConstantMonitorDown'] = $hasConstantDownMonitor;
		$_SESSION['hasUserCredentials'] = $hasUserCredentials;
		$_SESSION['formErrors'] = $html;
		if ($assetType->assetTypeId)
		{
			DebugPause("/editAssetType/".$assetType->assetTypeId."/");
		}
		DebugPause("/newAssetType/");
	}
}
$_SESSION['assetTypeOrganizationId'] = $organizationId;
DebugPause("/listAssetType/");
?>
