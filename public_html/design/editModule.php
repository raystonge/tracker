<?php
include_once "tracker/permission.php";
include_once "tracker/module.php";
$button = "Create";
$moduleId = 0;
$formKey = "";
PageAccess("Config: Module");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$moduleId = $request_uri[2];
		DebugText("using param 2:".$moduleId);
	}
}
$module = new Module($moduleId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($module->moduleId)
{
	$button = "Update";
}

include $sitePath."/design/editors/module.php";
?>
