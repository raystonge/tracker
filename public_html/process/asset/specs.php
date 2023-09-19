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
