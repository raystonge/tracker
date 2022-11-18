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
include_once "tracker/assetCondition.php";
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

    $assetCondition = new AssetCondition();

	if (isset($_POST['assetConditionId']))
	{
		$assetConditionId=strip_tags($_POST['assetConditionId']);
		$assetCondition->GetById($assetConditionId);
	}
	$name = GetTextField("name");
	$showAll = GetTextField("showAll",0);



	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "assetConditionId<>".$assetConditionId;
		$param = AddEscapedParam($param,"name",$name);
		//$param = AddEscapedParam($param, "organizationId", $organizationId);
		$testAssetCondition = new AssetCondition();
		if ($testAssetCondition->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Asset Condition already in use</li>";
		}
	}


	if ($numErrors ==0)
	{
		$assetCondition->name = $name;
		$assetCondition->showAll = $showAll;

    $assetCondition->Persist();

		DebugPause("/listAssetCondition/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;
		$_SESSION['showAll'] = $showAll;

		$_SESSION['formErrors'] = $html;
		if ($assetCondition->assetConditionId)
		{
			DebugPause("/editAssetCondition/".$assetCondition->assetConditionId."/");
		}
		DebugPause("/newAssetCondition/");
	}
}
//$_SESSION['assetConditionOrganizationId'] = $organizationId;
DebugPause("/listAssetCondition/");
?>
