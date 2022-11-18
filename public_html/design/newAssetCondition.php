<?php
include_once "tracker/permission.php";
include_once "tracker/assetCondition.php";
$button = "Create";
$assetConditionId = 0;
$formKey = "";
PageAccess("Config: Asset Condition Create");

$assetCondition = new AssetCondition();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/assetCondition.php";
?>
