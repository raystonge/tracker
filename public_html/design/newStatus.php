<?php
include_once "tracker/permission.php";
include_once "tracker/status.php";
$button = "Create";
$assetTypeId = 0;
$formKey = "";
PageAccess("Config: Status Create");

$status = new Status();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/status.php";
?>
