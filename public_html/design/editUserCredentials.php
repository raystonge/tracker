<?php
include_once "tracker/permission.php";
include_once "tracker/assetCredentials.php";
$button = "Create";
$formKey = "";
PageAccess("Asset: User Credentials");
$assetId = GetURI(2,0);
$assetCredentialsId = GetURI(3,0);
DebugText("assetCredentialsId:".$assetCredentialsId);
$assetCredentials = new AssetCredentials($assetCredentialsId);
$formKey = "";

if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($assetCredentials->assetCredentialsId)
{
	$button = "Update";
}

include $sitePath."/design/editors/userCredentials.php";
?>
