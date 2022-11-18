<?php
include_once "tracker/permission.php";
include_once "tracker/assetType.php";
$button = "Create";
$assetTypeId = 0;
$formKey = "";
PageAccess("Config: AssetType Create");

$assetType = new AssetType();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/assetType.php";
?>
