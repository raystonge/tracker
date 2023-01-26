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
  $parm = AddEscapedParam("","poNumberId",$asset->poNumberId);
  $contract->Get($param);

	$line = $asset->assetTag.",".$asset->serialNumber.",".$assetType->name.",".$asset->make.",".$asset->model.",".$asset->purchasePrice.",".$building->name.",".$asset->employeeName.",".$asset->vendor.",".$asset->aquireDate.",".$contract->name.",".$contract->expireDate."\n";
	$data = $data.$line;
  $ok = $asset->Next();
}
$filename="contract-".$name.".csv";
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo $data; exit();
//DebugOutput();
?>
