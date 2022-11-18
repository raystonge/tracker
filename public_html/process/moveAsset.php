<?php
include_once "globals.php";
include_once "tracker/asset.php";

//ProperAccessValidate();

$assetId = GetTextField("assetId",0);

$asset = new Asset($assetId);

if (!$asset->assetId)
{
  DebugPause("/");
}
$buildingId = GetTextField("building",0);
$assetTypeId = GetTextField("assetTypeId",0);
$organizationId = GetTextField("organization",0);
$asset->organizationId = $organizationId;
$asset->buildingId = $buildingId;
$asset->assetTypeId = $assetTypeId;
$asset->Persist();
DebugPause("/assetEdit/".$asset->assetId."/");
?>
