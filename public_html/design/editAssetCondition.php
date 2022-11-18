<?php
include_once "tracker/permission.php";
include_once "tracker/assetCondition.php";
$button = "Create";
$assetConditionId = 0;
$formKey = "";
PageAccess("Config: Asset Condition");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$assetConditionId = $request_uri[2];
		DebugText("using param 2:".$assetConditionId);
	}
}
$assetCondition = new assetCondition($assetConditionId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($assetCondition->assetConditionId)
{
	$button = "Update";
}

include $sitePath."/design/editors/assetCondition.php";
?>
