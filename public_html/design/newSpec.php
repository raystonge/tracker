<?php
include_once "tracker/permission.php";
include_once "tracker/spec.php";
$button = "Create";
$assetTypeId = 0;
$formKey = "";
PageAccess("Config: Spec");

$spec = new Spec();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/spec.php";
?>
