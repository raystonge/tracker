<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/building.php";
include_once "tracker/assetType.php";



 	$fname = $siteRootPath."/tmp/ipadCarts.csv";
 	$handle = fopen($fname,"r");
 	$delimiter = ",";
 	while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 	{
 		$asset = new Asset();
 		$buildingName = $row[2];
 		$param = AddEscapedParam("","name",$buildingName);
 		$building = new Building();
 		$building->Get($param);
 		$buildingLocation = $row[3];
 		$name = $row[7];
 		$serialNumber = $row[5];
 		$mac = "";
 		//$desc = $row[5];
 		$make = $row[0];
 		$model = $row[6];
 		$modelNumber = "";
 		$assetCategory = $row[1];
 		//DebugText("desc:".$desc);
 		$mac = $asset->FormatMacAddress($mac);
 		$param = "macAddress='$mac'";
 		if (strlen(trim($mac)))
 		{
 		  if (!$asset->Get($param))
 		  {
 			$param = "serialNumber='$serialNumber'";
 			$asset->Get($param);
 		  }
 		}
 		else
 		{
 			$param = "serialNumber='$serialNumber'";
 			$asset->Get($param); 			
 		}
 		$assetTypeId = 0;
 		$param = AddEscapedParam("","name",$assetCategory);
 		$assetType = new AssetType();
 		if (!$assetType->Get($param))
 		{
 			$assetType->name = $assetCategory;
 			$assetType->Persist();
 		}
		$asset->vendor = "";
 		$asset->assetTypeId = $assetType->assetTypeId;
 		$asset->assetConditionId =3;
 		$asset->buildingId = $building->buildingId;
 		$asset->buildingLocation = $buildingLocation;
 		$asset->serialNumber = $serialNumber;
 		$asset->name = $name;
 		$asset->make = $make;
 		$asset->model = $model;
 		$asset->modelNumber = $modelNumber;
 		$asset->macAddress = $mac;
 		$asset->Persist();
 	}
DebugOutput();
?>