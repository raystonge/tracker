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
include_once "tracker/assetType.php";
include_once "tracker/asset.php";
$assetTypeId = $request_uri[2];
$assetType = new AssetType($assetTypeId);
$asset = new Asset();
$param = "assetTypeId=".$assetType->assetTypeId;
if ($asset->Get($param))
{
	echo "Asset Type ".$assetType->name." cannot be deleted because assets of that type exist.";
}
else
{
	$assetType->Delete();
	echo "Asset Type ".$assetType->name." has been deleted";
}
?>
