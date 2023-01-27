<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
<?php
include_once "globals.php";
include_once "tracker/module.php";
include_once "tracker/asset.php";
include_once "tracker/user.php";
include_once "tracker/poNumber.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/assetType.php";

$moduleId = $_GET["id"];
$module = new Module($moduleId);
$reportFname = $module->name;
$reportFname = str_replace(" ","_",$reportFname);
$reportData = "";
$reportData = $reportData.'"Asset Id",';
$reportData = $reportData.'"Serial Number",';
$reportData = $reportData.'"Asset Tag",';
$reportData = $reportData.'"MAC Address",';
$reportData = $reportData.'"Asset Type",';
$reportData = $reportData.'"Make",';
$reportData = $reportData.'"Model",';
$reportData = $reportData.'"Model Number",';
$reportData = $reportData.'"Purchase Price",';
$reportData = $reportData.'"Building",';
$reportData = $reportData.'"Location",';
$reportData = $reportData.'"Name",';
$reportData = $reportData.'"Employee Name",';
$reportData = $reportData.'"PO Number",';
$reportData = $reportData.'"Vendor",';
$reportData = $reportData.'"Aquire Date",';
$reportData = $reportData.'"Warranty Date",';
$reportData = $reportData.'"Number of Licenses",';
$reportData = $reportData.'"Expire Date",';
$reportData = $reportData.'"Aquire Date",';
$reportData = $reportData.'"Creator",';
$reportData = $reportData.'"Create Date",';

$reportData = $reportData."\n";

$param = $module->GetParam();
$asset = new Asset();
$mm_type = "text/csv";

$ok = $asset->Get($param);
while ($ok)
{
	$creator = new User($asset->creatorId);
	$po = new poNumber($asset->poNumberId);
	$assetType = new AssetType($asset->assetTypeId);
	$building = new Building($asset->buildingId);
	$reportData = $reportData.'"'.$asset->assetId.'",';
	$reportData = $reportData.'"'.$asset->serialNumber.'",';
	$reportData = $reportData.'"'.$asset->assetTag.'",';
	$reportData = $reportData.'"'.$asset->macAddress.'",';
	$reportData = $reportData.'"'.$assetType->name.'",';
	$reportData = $reportData.'"'.$asset->make.'",';
	$reportData = $reportData.'"'.$asset->model.'",';
	$reportData = $reportData.'"'.$asset->modelNumber.'",';
	$reportData = $reportData.'"'.$asset->purchasePrice.'",';
	$reportData = $reportData.'"'.$building->name.'",';
	$reportData = $reportData.'"'.$asset->buildingLocation.'",';
	$reportData = $reportData.'"'.$asset->name.'",';
	$reportData = $reportData.'"'.$asset->employeeName.'",';
	$reportData = $reportData.'"'.$po->poNumber.'",';
	$reportData = $reportData.'"'.$asset->vendor.'",';
	$reportData = $reportData.'"'.$asset->aquireDate.'",';
	$reportData = $reportData.'"'.$asset->warrantyDate.'",';
	$reportData = $reportData.'"'.$asset->numOfLicenses.'",';
	$reportData = $reportData.'"'.$asset->expireDate.'",';
	$reportData = $reportData.'"'.$asset->aquireDate.'",';
    $reportData = $reportData.'"'.$creator->fullName.'",';
    $reportData = $reportData.'"'.$asset->createDate.'",';
	$reportData = $reportData."\n";
	$ok = $asset->Next();
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: " . $mm_type);
header("Content-Length: " .(string)(strlen($reportData)) );
header('Content-Disposition: attachment; filename="'.$reportFname.'"');
header("Content-Transfer-Encoding: binary\n");

//echo (strlen($reportData))."<br>";
echo $reportData;
DebugOutput();
?>
