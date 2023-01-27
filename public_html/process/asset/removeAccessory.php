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
include_once 'tracker/asset.php';
include_once 'tracker/assetToAsset.php';
include_once 'tracker/assetType.php';
ProperAccessTest("removeAccessory");
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$param = "";
//$param = AddEscapedParam("","organizationId",$asset->organizationId);

$ok = $asset->Get($param);
$showButton = $ok;
while ($ok)
{
	$assetType = new assetType($asset->assetTypeId);
	$field = "asset".$asset->assetId;

	if (strlen(GetTextField($field)))
	{
		$param = AddEscapedParam("", "assetId1", $assetId);
  	$param = AddEscapedParam($param,"assetId2", $asset->assetId);

	  $param1 = AddEscapedParam("", "assetId1", $asset->assetId);
	  $param1 = AddEscapedParam($param1,"assetId2", $assetId);

	  $param = "(".$param.") or (".$param1.")";
		$assetPair = new AssetToAsset();
		if ($assetPair->Get($param))
		{
			$assetPair->Delete();
		}
	}
	$ok = $asset->Next();
}
DebugPause("/accessory/".$assetId."/");
?>
