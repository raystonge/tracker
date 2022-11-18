<?php
/*
 * Created on Sep 25, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include "globals.php";
 include "tracker/asset.php";
 include "tracker/monitor.php";
 include "tracker/assetType.php";
 set_time_limit(60000);
 $fname = "";
 $buildingId = 0;
 $domain = "";
 $building = "drinkwater";
 ProcessBuilding("cass");
 ProcessBuilding("ames");
 ProcessBuilding("weymouth");
 ProcessBuilding("drinkwater");
 function ProcessBuilding($building)
 {
 	global $siteRootPath;
 $fname = "";
 $buildingId = 0;
 $domain = "";

 switch($building)
 {
 	case "cass": $fname = $siteRootPath."/tmp/fixedleases.cass";
 	             $buildingId = 2;
 	             $domain = "cass.net";
 	             break;
 	case "weymouth": $fname = $siteRootPath."/tmp/fixedleases.weymouth";
 	             $buildingId = 11;
 	             $domain = "weymouth.net";
 	             break;
 	case "ames": $fname = $siteRootPath."/tmp/fixedleases.ames";
 	             $buildingId = 1;
 	             $domain = "ames.net";
 	             break;
 	case "drinkwater": $fname = $siteRootPath."/tmp/fixedleases.drinkwater";
 	             $buildingId = 3;
 	             $domain = "drinkwater.net";
 	             break;
 	             
 }
 
 $handle = fopen($fname,"r");
 $delimiter = ",";
 while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 {
 	$mac = $row[0];
 	$ipAddress = $row[1];
 	$serial = $row[6];
 	$user = $row[7];
 	$asset = new Asset();
 	$mac = $asset->FormatMacAddress($mac);
 	$param = AddEscapedParam("","macAddress",$mac);
 	if (!$asset->Get($param))
 	{
 		$asset->assetTypeId = 4;
 		$asset->assetConditionId = 2;
 		
 		$asset->make = "Apple";
 		$asset->model = "Macbook";
 		$asset->vendor = "MLTI";
 		
 	}
 	$asset->buildingId = $buildingId;
 	$asset->serialNumber = $serial;
 	$asset->macAddress = $mac;
 	$asset->employeeName = $user;
 	$asset->name = $user;
 	if (strpos($asset->name,".outofservice"))
 	{
 		$asset->assetConditionId = 4;
 		$asset->employeeName = "";
 		$asset->name = "";
 	}
 	$asset->creatorId = 1;
 	$originalSerial = $serial;
 	/*
	$pos = strpos($serial,"(");
	if ($pos)
	{
		$asset->name = substr($serial,0,$pos-1);
		$serial = substr($serial,$pos);
		$serial = str_replace("(","",$serial);
		$serial = str_replace(")","",$serial);
		$asset->serialNumber = $serial;
	}
*/
 	if (strpos($user,".wap"))
 	{
 		$asset->assetTypeId = 2;
 		$asset->name=$serial;
 		$asset->serialNumber = "Unknown";
 		$asset->make = "";
 		$asset->model = "";
 		$asset->vendor = "";
 		DebugText("serialNumber of WAP:".$serial);

 		if (strpos($serial,"HP") || strpos($serial,"Pro"))
 		{
 			$asset->make = "HP";
 			if (strpos($serial,"Pro"))
 			{
 				$asset->model = "Pro Curve";
 				$asset->modelNumber = "J8130B";
 			}
 			$pos = strpos($serial,"(");
 			if ($pos)
 			{
 				$asset->name = substr($serial,0,$pos-1);
 				$serial = substr($serial,$pos);
 				$serial = str_replace("(","",$serial);
 				$serial = str_replace(")","",$serial);
 				$asset->serialNumber = $serial;
 			}
 		}
 		if (strpos($serial,"Aurba"))
 		{
 			$asset->make = "Aruba";
			$asset->model = "105";
			$asset->modelNumber = "";

 			$pos = strpos($serial,"(");
 			if ($pos)
 			{
 				$asset->name = substr($serial,0,$pos-1);
 				$serial = substr($serial,$pos);
 				$serial = str_replace("(","",$serial);
 				$serial = str_replace(")","",$serial);
 				$asset->serialNumber = $serial;
 			}
 		}

 	}
 	if (strpos($user,".printer"))
 	{
 		$asset->assetTypeId = 5;
 		$asset->serialNumber = "Unknown";
 		$asset->make = "";
 		$asset->model = "";
 		$asset->vendor = "";
 			$pos = strpos($serial,"(");
 			if ($pos)
 			{
 				$asset->name = substr($serial,0,$pos-1);
 				$serial = substr($serial,$pos);
 				$serial = str_replace("(","",$serial);
 				$serial = str_replace(")","",$serial);
 				$asset->serialNumber = $serial;
 			}

 	}
 	if (strpos($user,".switch"))
 	{
 		$asset->assetTypeId = 3;
 		$asset->serialNumber = "Unknown";
 		$asset->make = "";
 		$asset->model = "";
 		$asset->vendor = "";	
 			$pos = strpos($serial,"(");
 			if ($pos)
 			{
 				$asset->name = substr($serial,0,$pos-1);
 				$serial = substr($serial,$pos);
 				$serial = str_replace("(","",$serial);
 				$serial = str_replace(")","",$serial);
 				$asset->serialNumber = $serial;
 			}
 	}
 	if (strpos($user,".ipad"))
 	{
 		$asset->assetTypeId = 10;
 		//$asset->serialNumber = "Unknown";
 		$asset->make = "Apple";
 		$asset->model = "iPad";
 		$asset->vendor = "";	
 	} 	
 	if (strpos($user,".netbook"))
 	{
 		$asset->assetTypeId = 9;
 		//$asset->serialNumber = "Unknown";
 		$asset->make = "";
 		$asset->model = "";
 		$asset->vendor = "";	
 	} 	
 	if (strpos($user,".emac"))
 	{
 		$asset->assetTypeId = 1;
 		//$asset->serialNumber = "Unknown";
 		$asset->make = "Apple";
 		$asset->model = "eMac";
 		$asset->vendor = "";	
 	} 	
 	if (strpos($user,".chromebook"))
 	{
 		$assetType = new AssetType();
 		$assetType->Get("name='chromebook'");
 		$asset->assetTypeId = $assetType->assetTypeId;
 		//$asset->serialNumber = "Unknown";
 		$asset->make = "Lenovo";
 		$asset->model = "";
 		$asset->vendor = "";	
 	} 	

 	if (strpos($user,".macmini"))
 	{
 		$asset->assetTypeId = 1;
 		//$asset->serialNumber = "Unknown";
 		$asset->make = "Apple";
 		$asset->model = "MacMini";
 		$asset->vendor = "";	
 	} 	

 	if (strlen($asset->name) == 0)
 	{
 		$asset->assetConditionId = 4;
 	}
 	if (strpos($user,".airport"))
 	{
 		$asset->assetTypeId = 2;
 		//$asset->serialNumber = "Unknown";
 		$asset->make = "Apple";
 		$asset->model = "Airport";
 		$asset->vendor = "";	
 			$pos = strpos($serial,"(");
 			if ($pos)
 			{
 				$asset->name = substr($serial,0,$pos-1);
 				$serial = substr($serial,$pos);
 				$serial = str_replace("(","",$serial);
 				$serial = str_replace(")","",$serial);
 				$asset->serialNumber = $serial;
 			}
 	} 	
 	
 	if (strpos($user,".phone"))
 	{
 		$asset->assetTypeId = 0;
 	}
 	/*
 	if ($asset->serialNumber == "imported")
 	{
 		$asset->assetTypeId = 0;
 	}
 	*/
	$pos = strpos($originalSerial,"(");
	if ($pos)
	{
		$asset->name = substr($originalSerial,0,$pos-1);
		$serial = substr($originalSerial,$pos);
		$serial = str_replace("(","",$serial);
		$serial = str_replace(")","",$serial);
		$asset->serialNumber = $serial;
	}
 	
 	if ($asset->assetTypeId)
 	{
 		$asset->Persist();
 	}
 	$assetType = new AssetType();
 	$param = "assetTypeId=".$asset->assetTypeId;
 	$param = $param." and assetTypeId in (2,3,5,6)";
 	$assetType->Get($param);
 	if ($assetType->monitor && strlen($user))
 	{
 		$monitor = new Monitor();
 		$param = "assetId=".$asset->assetId;
 		$monitor->Get($param);
 		$monitor->fqdn = $user.".".$domain;
 		$monitor->ipAddress = $ipAddress;
 		$monitor->assetId = $asset->assetId;
 		$monitor->Persist();
 	}
 }
 }
DebugOutput();
?>
