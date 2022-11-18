<?php
include_once "tracker/user.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: User");
$user = new User();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/user.php";
?>