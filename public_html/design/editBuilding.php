<?php
include_once "tracker/permission.php";
include_once "tracker/building.php";
$button = "Create";
$buildingId = 0;
$formKey = "";
PageAccess("Config: Building");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$buildingId = $request_uri[2];
		DebugText("using param 2:".$buildingId);
	}
}
$building = new Building($buildingId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($building->buildingId)
{
	$button = "Update";
}

include $sitePath."/design/editors/building.php";
?>