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
include_once "tracker/assetCondition.php";
include_once "tracker/asset.php";
$assetConditionId = GetURI(2,0);
$key = GetURI(3,"");
if (!$assetConditionId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteAssetCondition"))
{
	echo "This is not allowed at this time";
	exit;
}

$assetCondition = new AssetCondition($assetConditionId);
if (!$assetCondition->assetConditionId)
if (!$assetConditionId)
{
	echo "Invalid operation";
	exit;
}
$asset = new Asset();
$param = "assetConditionId=".$assetCondition->assetConditionId;
if ($asset->Get($param))
{
	echo "AssetCondition ".$assetCondition->name." cannot be deleted because assets are marked for that Asset Condition.";
}
else
{
	$assetCondition->Delete();
	echo "AssetCondition ".$assetCondition->name." has been deleted";
}
?>
