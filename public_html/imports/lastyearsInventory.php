<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/building.php";
include_once "tracker/assetType.php";

Process("Ames","Ames");
//Process("CASS","CASS");
Process("Drinkwater","Drinkwater");
Process("Weymouth","Weymouth");

function Process($building,$name)
{
 	global $siteRootPath;
 	$fname = $siteRootPath."/tmp/lastyear/".$building.".csv";
 	$handle = fopen($fname,"r");
 	$delimiter = ",";
 	$building = new Building();
 	$building->Get("name='$name'");
 	while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 	{
 		$asset = new Asset();
 		$buildingLocation = $row[3];
 		$name = $row[11];
 		$serialNumber = $row[7];
 		$mac = $row[1];
 		//$desc = $row[5];
 		$make = $row[4];
 		$model = $row[5];
 		$modelNumber = $row[6];
 		$assetCategory = $row[9];
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
}
DebugOutput();
?>