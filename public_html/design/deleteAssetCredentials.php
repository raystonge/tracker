<?php
/*
 * Created on Aug 1, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/assetCredentials.php";
$assetCredentialsId = $request_uri[2];
$assetCredentials = new AssetCredentials($assetCredentialsId);
$param = "assetCredentialsId=".$assetCredentials->assetCredentialsId;
if (!$assetCredentials->Get($param))
{
	echo "Asset Credentials cannot be deleted because assets of that type exist.";
}
else
{
	$assetCredentials->Delete();
	echo "Asset Credentials ".$assetCredentials->userName." has been deleted";
}
?>
