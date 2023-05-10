<?php
//
//  Tracker - Version 1.8.2
//
//  v1.8.2
//   - fixing cross site security error on delete
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
include_once "tracker/spec.php";
include_once "tracker/specToAssetType.php";
include_once "tracker/assetToSpec.php";
$specId = GetURI(2,0);
$key = GetURI(3,"");
if (!$specId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteSpec"))
{
	echo "This is not allowed at this time";
	exit;
}

$spec = new Spec($specId);
if (!$spec->specId)
if (!$specId)
{
	echo "Invalid operation";
	exit;
}
$param = AddEscapedParam("","specId",$specId);
$assetToSpec = new assetToSpec();
$specToAssetType = new specToAssetType();
$inUse = 0;
if ($assetToSpec->Get($param))
{
  echo "Spec ".$spec->name." is assigned to Assets<br>";
  $inUse = 1;
}
if ($specToAssetType->Get($param))
{
  echo "Spec ".$spec->name." is assigned to AssetTypes<br>";
  $inUse = 1;
}
if ($inUse)
{
  echo "Spec ".$spec->name." cannot be deleted at this time<br>";
  exit;
}
$spec->Delete();
echo "Spec ".$spec->name." has been deleted";
?>
