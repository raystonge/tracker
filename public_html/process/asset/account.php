<?php
include_once 'globals.php';
include_once "tracker/asset.php";

$_SESSION['formErrors'] ="";
$_SESSION['assetAdminAccount'] = "";
$_SESSION['assetAdminPassword'] = "";

ProperAccessValidate();
if (isset($_POST['submitTest']))
{
	$assetId = GetTextField("assetId");
	$asset = new Asset($assetId);
	if ($asset->assetId == 0)
	{
		DebugText("no assetId");
		DebugPause("/listAssets/");
	}
	$asset->adminUser = GetTextField("adminUser");
	$asset->adminPassword = GetTextField("adminPassword");
	$asset->Persist();
	$_SESSION['formSuccess'] = "Success";
	DebugPause("/assetAccount/".$assetId);
}
DebugText("submitTest failed");
DebugPause("/listAssets/");
?>