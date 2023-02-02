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
include_once "tracker/asset.php";

ProperAccessValidate();

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
