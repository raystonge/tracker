<?php
include_once "tracker/permission.php";
include_once "tracker/assetCredentials.php";
$button = "Create";
$assetId = GetURI(2,0);

$assetCredentialsId = 0;
$formKey = "";
PageAccess("Asset: User Credentials");

$assetCredentials = new AssetCredentials();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/userCredentials.php";
?>