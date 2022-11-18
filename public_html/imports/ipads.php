<?php
/*
 * Created on Oct 28, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
 include "globals.php";
 include "tracker/asset.php";
 include "tracker/building.php";
 
 $fname = $siteRootPath."/tmp/ipads.csv";
 $handle = fopen($fname,"r");
 $delimiter = ",";
 while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 {
 	$buildingName = trim($row[0]);
 	$building = new Building();
 	$param = AddEscapedParam("","name",$buildingName);
 	$building->Get($param);
 	$asset = new Asset();
 	$name = trim($row[1]);
 	$serial = trim($row[2]);
 	$mac = trim($row[3]);
 	if (substr($serial,0,1) == "S")
 	{
 		$serial = substr($serial,1);
 	}
 	$aquireDate = trim($row[4]);
 	$po = trim($row[5]);
 	$asset = new Asset();
 	$mac = $asset->FormatMacAddress($mac);
 	$param = AddEscapedParam("","macAddress",$mac);
 	if (!$asset->Get($param))
 	{
 		$asset->name = $name;
 	}

 	$asset->serialNumber = $serial;
 	$asset->make = "Apple";
 	$asset->model = "iPad";
 	if ($asset->IsValid($mac) && $building->buildingId)
 	{
 		$asset->macAddress = $mac;
 		$asset->buildingId = $building->buildingId;
 		$asset->poNumber = $po;
 		$asset->assetTypeId =10;
 		$asset->assetConditionId = 2;
 
 		$asset->aquireDate = $aquireDate;
 		$asset->Persist();
    }
 }
 DebugOutput();
 ?>