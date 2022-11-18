<?php
include_once "tracker/permission.php";
include_once "tracker/userGroup.php";
$button = "Create";
$userGroupId = 0;
$formKey = "";
PageAccess("Config: User Group");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$userGroupId = $request_uri[2];
		DebugText("using param 2:".$userGroupId);
	}
}
$userGroup = new UserGroup($userGroupId);
$formKey = GetTextField("formKey");
if ($userGroup->userGroupId)
{
	$button = "Update";
}

include $sitePath."/design/editors/userGroup.php";
?>