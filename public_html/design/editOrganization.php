<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
$button = "Create";
$organizationId = 0;
$formKey = "";
PageAccess("Config: Organization");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$organizationId = $request_uri[2];
		DebugText("using param 2:".$organizationId);
	}
}
$organization = new Organization($organizationId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($organization->organizationId)
{
	$button = "Update";
}

include $sitePath."/design/editors/organization.php";
?>