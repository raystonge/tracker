<?php
/*
 * Created on Nov 27, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/assetToContract.php";

ProcessFile("transco.csv",1);
ProcessFile("spcCopiers.csv",2);
DebugOutput();

function ProcessFile($fname,$contractId)
{
 	global $siteRootPath;
 	$fname = $siteRootPath."/tmp/".$fname;
 	$handle = fopen($fname,"r");
    $delimiter = ",";
    while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
    {
    	$buildingName = $row[0];
    	$buildingLocation = $row[1];
    	$make = $row[2];
    	$serialNumber = $row[3];
    	$assetTag = $row[4];
    	$status = $row[6];
    	$type = $row[7];
    	$asset = new Asset();
    	$param = AddEscapedParam("","serialNumber",$serialNumber);
    	$asset->Get($param);
    	$param = "";
    	$building = new Building();
    	switch ($buildingName)
    	{
    		case "AES": $param = "name='Ames'";
    		            break;
    		case "DES": $param = "name='Drinkwater'";
    		            break;
    		case "NES": $param = "name='Nickerson'";
    		            break;
    		case "EES": $param = "name='East Belfast'";
    		            break;
    		case "WES": $param = "name='Weymouth'";
    		            break;
    		case "CO-business":
    		case "CO–business":
    		case "CO":  $param = "name='Central Office'";
    		            break;
    		case "B-COPE": $param = "name='BCOPE'";
    		               break;
    		case "6 Mortland-It":
    		case "6 Mortland": $param = "name='6 Mortland'";
    		                   break;
    		default : $param = "name='$buildingName'";
    	}
    	$building->Get($param);
    	$param = "";
    	switch ($status)
    	{
    		case "production": $param="name='Good'";
    		                   break;
    		case "storage":  
    		case "toast":
    		case "Out of SRV": $param = "name='Out of Service'";
    		                   break;
    	    default: $param = "name='Good'";
    	}
    	$assetCondition = new AssetCondition();
    	$assetCondition->Get($param);
    	$assetType = new AssetType();
    	$param = "name='$type'";
    	$assetType->Get($param);
    	$asset->assetTag = $assetTag;
    	$asset->serialNumber = $serialNumber;
    	$asset->buildingId = $building->buildingId;
    	$asset->buildingLocation = $buildingLocation;
    	$asset->make = $make;
    	$make = strtoupper($make);
    	if (substr($make,0,2) == "HP")
    	{
    		$asset->make = "HP";
    		$asset->model = substr($make,2);
    	}
    	if (substr($make,0,5) == "XEROX")
    	{
    		$asset->make = "Xerox";
    		$asset->model = substr($make,5);
    	}
    	if (substr($make,0,7) == "LEXMARK")
    	{
    		$asset->make = "Lexmark";
    		$asset->model = substr($make,7);
    	}
    	if (substr($make,0,7) == "BROTHER")
    	{
    		$asset->make = "Brother";
    		$asset->model = substr($make,7);
    	}
    	if (substr($make,0,5) == "RICOH")
    	{
    		$asset->make = "Ricoh";
    		$asset->model = substr($make,5);
    	}
    	if (substr($make,0,5) == "SAVIN")
    	{
    		$asset->make = "Savin";
    		$asset->model = substr($make,5);
    	}
    	if (substr($make,0,9) == "GESTETNER")
    	{
    		$asset->make = "Gestetner";
    		$asset->model = substr($make,9);
    	}

    	$asset->assetConditionId = $assetCondition->assetConditionId;
    	$asset->assetTypeId = $assetType->assetTypeId;
    	echo "tag:".$assetTag."<br>";
    	echo "sn:".$serialNumber."<br>";
    	echo "building:".$building->name."<br>";
    	echo "location:".$buildingLocation."<br>";
    	echo "make:".$asset->make."<br>";
    	echo "model:".$asset->model."<br>";
    	echo "condition:".$assetCondition->name."<br>";
    	echo "type:".$assetType->name."<br>";
    	$asset->Persist();
    	$assetToContract = new AssetToContract();
    	$param = "assetId=".$asset->assetId;
    	$assetToContract->Get($param);
    	$assetToContract->assetId = $asset->assetId;
    	$assetToContract->contractId = $contractId;;
    	$assetToContract->Persist();
    }
    fclose($handle);
}
?>