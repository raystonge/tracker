<?php
include_once "tracker/permission.php";
include_once "tracker/status.php";
$button = "Create";
$statusId = 0;
$formKey = "";
PageAccess("Config: Status Create");
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$statusId = $request_uri[2];
		DebugText("using param 2:".$statusId);
	}
}
$status = new Status($statusId);
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
