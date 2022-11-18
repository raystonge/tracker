<?php
include_once 'globals.php';
include_once "tracker/asset.php";
include_once "tracker/assetToSpec.php";
include_once "tracker/specToAssetType.php";
include_once "tracker/spec.php";

ProperAccessValidate();
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$specToAssetType = new SpecToAssetType();
$param = AddEscapedParam("","assetTypeId",$asset->assetTypeId);
$ok = $specToAssetType->Get($param);
while ($ok)
{
  $spec = new Spec($specToAssetType->specId);
  $assetToSpec = new AssetToSpec();
  $param = AddEscapedParam("","assetId",$asset->assetId);
  $param = AddEscapedParam($param,"specId",$spec->specId);
  $assetToSpec->Get($param);
  $assetToSpec->specId = $spec->specId;
  $assetToSpec->assetId = $asset->assetId;
  $assetToSpec->specValue = GetTextField("specId".$spec->specId);
  $assetToSpec->Persist();

  $ok = $specToAssetType->Next();
}
$_SESSION['formSuccess'] = "Success";
DebugPause("/assetSpecs/".$assetId."/");
 ?>
