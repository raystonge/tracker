<?php
/*
 * Created on Aug 1, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/assetType.php";
include_once "tracker/asset.php";
$assetTypeId = $request_uri[2];
$assetType = new AssetType($assetTypeId);
$asset = new Asset();
$param = "assetTypeId=".$assetType->assetTypeId;
if ($asset->Get($param))
{
	echo "Asset Type ".$assetType->name." cannot be deleted because assets of that type exist.";	
}
else
{
	$assetType->Delete();
	echo "Asset Type ".$assetType->name." has been deleted";
}
?>