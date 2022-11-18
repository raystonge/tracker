<?php
include_once "tracker/permission.php";
include_once "tracker/user.php";
$button = "Create";
$userId = 0;
$formKey = "";
PageAccess("Config: User Group");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$userId = $request_uri[2];
		DebugText("using param 2:".$userId);
	}
}
$user = new User($userId);
$formKey = getFormKey();

if ($user->userId)
{
	$button = "Update";
}

include $sitePath."/design/editors/user.php";
?>