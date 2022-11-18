<?php
include_once "tracker/module.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: Module");
$module = new Module();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/module.php";
?>
