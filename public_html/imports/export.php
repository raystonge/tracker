<?php
/*
 * Created on Mar 24, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$param = "buildingId=3 and assetConditionId not in (4,5,7)";
$asset = new Asset();
$ok = $asset->Get($param);
$fname = $siteRootPath."/tmp/drinkwater.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$assetType = new AssetType($asset->assetTypeId);
	$assetInfo = array();
	$assetInfo[0] = $asset->macAddress;
	$assetInfo[1] = $asset->serialNumber;
	$assetInfo[2] = $assetType->name;
	$assetInfo[3] = $asset->name;
	fputcsv($fp,$assetInfo);
	$ok = $asset->Next();
}
fclose($fp);
DebugOutput();
?>