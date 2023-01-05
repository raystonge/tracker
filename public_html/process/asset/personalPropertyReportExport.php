<?php
include_once 'globals.php';
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/set.php";

PageAccess("Report: Billing");

$organizationId =0;
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$organizationId = $request_uri[2];
	}
}
$organizationId = GetURLVar("organizationId",0);
$organization = new Organization($organizationId);

$assetTypes = new Set(",");
$assetType = new AssetType();
$param = "personalProperty=1";
$param = AddEscapedParam($param,"organizationId",$organizationId);
$ok = $assetType->Get($param);
while ($ok)
{
  $assetTypes->Add($assetType->assetTypeId);
  $ok = $assetType->Next();
}
$startDate = GetTextField("startDate");
$stopDate = GetTextField("stopDate");
$asset = new Asset();
$asset->SetOrderBy("buildingId");
$data = "";
$data = "Personal Property Report - ".$organization->name."\n";
$data = $data.$startDate." - ".$stopDate."\n";
$data = $data."Asset Tag,Serial Number,Asset Type,Make,Model,Purchase Price,Building,Employee,Vendor,Aquired Date,Status\n";
$param = "assetConditionId != 5 and assetConditionId != 8 and assetTypeId in (".$assetTypes->data.")";
$param = AddEscapedParam($param,"organizationId",$organizationId);
$ok = $asset->Get($param);
while ($ok)
{
  $assetType = new AssetType($asset->assetTypeId);
  $building = new Building($asset->buildingId);
  $assetCondition = new AssetCondition($asset->assetConditionId);
	$line = $asset->assetTag.",".$asset->serialNumber.",".$assetType->name.",".$asset->make.",".$asset->model.",".$asset->purchasePrice.",".$building->name.",".$asset->employeeName.",".$asset->vendor.",".$asset->aquireDate.",".$assetCondition->name."\n";
	$data = $data.$line;
  $ok = $asset->Next();
}
$filename="personalProperty-".$organization->name.".csv";
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo $data; exit();
//DebugOutput();
?>
