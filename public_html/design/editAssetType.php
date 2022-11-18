<?php
include_once "tracker/permission.php";
include_once "tracker/assetType.php";
$button = "Create";
$formKey = "";
PageAccess("Config: AssetType Edit");
$assetTypeId = GetURI(2,0);
$assetType = new AssetType($assetTypeId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($assetType->assetTypeId)
{
	$button = "Update";
}

include $sitePath."/design/editors/assetType.php";
?>