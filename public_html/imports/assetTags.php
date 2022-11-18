<?php
/*
 * Created on Sep 25, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include "globals.php";
 include "tracker/asset.php";
 
 AddAssetTag("casscow.csv");
 AddAssetTag("assetTags.csv");
 AddAssetTag("assetTags1.csv");
 AddAssetTag("assetTags2.csv");
 
 function AddAssetTag($fname)
 {
 	global $siteRootPath;
 $fname = $siteRootPath."/tmp/".$fname;
 $handle = fopen($fname,"r");
 $delimiter = ",";
 $asset = new Asset();
 while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 {
 	$assetTag = $row[0];
 	$serial = $row[1];
 	$mac = $row[2];
 	$mac = $asset->FormatMacAddress($mac);
 	$asset = new Asset();
 	$param = AddEscapedParam("","macAddress",$mac);
 	if ($asset->Get($param))
 	{
 		$asset->assetTag = $assetTag;
 		$asset->Update();
 	}
 	else
 	{
 		$param = AddEscapedParam("","serialNumber",$serial);
 		if ($asset->Get($param))
 		{
 			$asset->assetTag = $assetTag;
 			$asset->Update();
 		}
 	}
 }
 }
DebugOutput();
?>
