<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/building.php";


Process("cass","CASS");

function Process($building,$name)
{
 	global $siteRootPath;
 	$fname = $siteRootPath."/tmp/inventory".$building.".csv";
 	$handle = fopen($fname,"r");
 	$delimiter = ",";
 	$building = new Building();
 	$building->Get("name='$name'");
 	while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 	{
 		$asset = new Asset();
 		$buildingLocation = $row[1];
 		$name = $row[2];
 		$serialNumber = $row[3];
 		$mac = $row[4];
 		$desc = $row[5];
 		DebugText("desc:".$desc);
 		$mac = $asset->FormatMacAddress($mac);
 		$param = "macAddress='$mac'";
 		if (strlen(trim($row[4])))
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
 		$pos = strpos($desc,"AccelScan");
 		if ($pos !== false)
 		{
 			DebugText("desc:".$desc);
 			DebugText("pos:".$pos);
 			$assetTypeId = 13;
 			$asset->make = "Accel Scan";
 			$asset->model = "";
 			
 		}
 		else
 		if (strpos($desc,"Amer.com") !== false)
 		{
 			DebugText("found amer.com");
 			$assetTypeId = 11;
 			$asset->make = "Amer.com";
 			$asset->model = trim(str_replace("Amer.com","",$desc));
 			
 		}
 		else
 
 		if (strpos($desc,"MacMini") !== false)
 		{
 			$assetTypeId = 1;
 			$asset->make = "Apple";
 			$asset->model = "MacMini";
 		}
 		else
 		if (strpos($desc,"Server") !== false)
 		{
 			$assetTypeId = 1;
 			$asset->make = "";
 			$asset->model = "";
 		}
 		else
 		if (strpos($desc,"NetGear") !== false)
 		{
 			$assetTypeId = 11;
 			$asset->make = "NetGear";
 			$asset->model = "";
 		}
 		$asset->vendor = "";
 		$asset->assetTypeId = $assetTypeId;
 		$asset->assetConditionId =3;
 		$asset->buildingId = $building->buildingId;
 		$asset->buildingLocation = $buildingLocation;
 		$asset->serialNumber = $serialNumber;
 		$asset->name = $name;
 		$asset->macAddress = $mac;
 		$asset->Persist();
 	}
}
DebugOutput();
?>