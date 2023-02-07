<?php
//
//  Tracker - Version 1.5.2
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
include_once 'globals.php';
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/contract.php";
include_once "tracker/set.php";

PageAccess("Report: Leases");

$organizationId =0;
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$contractId = $request_uri[2];
	}
}
$contractId = GetURLVar("contractId",0);
$contract = new Contract($contractId);

$poNumbers = new Set(",");
$assetType = new AssetType();
$param = AddEscapedParam("","contractId",$contractId);
$name = str_replace(' ', '', $contract->name);
if (!$contractId)
{
  $param = "expireDate >='".$today."' and isLease=1";
  $ok = $contract->Get($param);
  while ($ok)
  {
    $poNumbers->Add($contract->poNumberId);
    $ok = $contract->Next();
  }
  $param = "poNumberId in (".$poNumbers->data.")";
  $name = "allLeases";
}
$asset = new Asset();
$data = "";
$data = "Lease Report - ";
if ($contractId)
{
  $data = $data.$contract->name."\n";
}
else {
  $data = $data."All Contract\n";
}
$asset->setOrderBy("poNumberId");
$ok = $asset->Search($param);
while ($ok)
{
  $assetType = new AssetType($asset->assetTypeId);
  $building = new Building($asset->buildingId);
  $assetCondition = new AssetCondition($asset->assetConditionId);
  $param = AddEscapedParam("","poNumberId",$asset->poNumberId);
  $contract->Get($param);

	$line = $asset->assetTag.",".$asset->serialNumber.",".$assetType->name.",".$asset->make.",".$asset->model.",".$asset->purchasePrice.",".$building->name.",".$asset->employeeName.",".$asset->vendor.",".$asset->aquireDate.",".$contract->name.",".$contract->expireDate."\n";
	$data = $data.$line;
  $ok = $asset->Next();
}
$filename="contract-".$name.".csv";
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo $data;
//DebugOutput();
exit();
?>
