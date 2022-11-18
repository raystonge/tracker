<?php
include_once "tracker/userGroup.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: User Group");
$userGroup = new UserGroup();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/userGroup.php";
?>