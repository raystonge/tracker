<?php
include_once "tracker/permission.php";
include_once "tracker/spec.php";
$button = "Create";
$formKey = "";
PageAccess("Config: Spec");
$specId = GetURI(2,0);
$spec = new Spec($specId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($spec->specId)
{
	$button = "Update";
}

include $sitePath."/design/editors/spec.php";
?>
