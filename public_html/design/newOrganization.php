<?php
include_once "tracker/organization.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: Organization");
$organization = new Organization();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/organization.php";
?>