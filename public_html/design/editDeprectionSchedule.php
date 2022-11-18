<?php
include_once "tracker/permission.php";
include_once "tracker/assetType.php";
include_once "tracker/assetTypeDepreciationSchedule.php";

$button = "Create";
$formKey = "";
PageAccess("Config: AssetType Edit");
$assetTypeId = GetURI(2,0);
$assetType = new AssetType($assetTypeId);

$assetTypeDepreciationSchedule = new AssetTypeDepreciationSchedule();
$param = AddEscapedParam("","assetTypeId",$assetTypeId);
$assetTypeDepreciationSchedule->Get($param);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($assetTypeDepreciationSchedule->assetTypeId)
{
	$button = "Update";
}

include $sitePath."/design/editors/assetTypeDepreciationSchedule.php";
?>
