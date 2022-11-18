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
 
 $fname = $siteRootPath."/tmp/title1-ipads.csv";
 $handle = fopen($fname,"r");
 $delimiter = ",";
 while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 {
 	$buildingName = trim($row[0]);
 	$building = new Building();
 	$param = AddEscapedParam("","name",$buildingName);
 	$building->Get($param);
 	$name = "";
 	//$name = trim($row[1]);
 	$serial = trim($row[1]);
 	$mac = trim($row[2]);
 	if (substr($serial,0,1) == "S")
 	{
 		$serial = substr($serial,1);
 	}
 	$aquireDate = trim($row[3]);
 	$po = trim($row[4]);
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
 	$asset->buildingLocation = "Title 1";
 	if ($asset->IsValid($mac))
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