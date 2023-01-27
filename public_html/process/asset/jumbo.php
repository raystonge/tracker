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
$param = "";
$asset = new Asset();
$assets = new Set(",");
$searchAssetTag = GetTextFromSession('searchAssetTag');
$searchAssetType = GetTextFromSession('searchAssetType',0);
$searchBuildingId = GetTextFromSession('searchBuildingId',0);
$searchConditionId = GetTextFromSession('searchConditionId',0);
$searchMacAddress = GetTextFromSession('searchMacAddress');
$searchSerialNumber = GetTextFromSession('searchSerialNumber');
$searchName = GetTextFromSession('searchName');
if (strlen($searchAssetTag))
{
	$_SESSION['searchAssetTag'] = $searchAssetTag;
	$param = AddEscapedParamIfNotBlank($param,"assetTag",$searchAssetTag);
}
if ($searchAssetType >	0)
{
	$_SESSION['searchAssetType'] = $searchAssetType;
	$param = AddEscapedParam($param,'assetTypeId',$searchAssetType);
}
if ($searchBuildingId >	0)
{
	$_SESSION['searchBuildingId'] = $searchBuildingId;
	$param = AddEscapedParam($param,'buildingId',$searchBuildingId);
}

if ($searchConditionId > 0)
{
	$_SESSION['searchConditionId'] = $searchConditionId;
	$param = AddEscapedParam($param,'assetConditionId',$searchConditionId);
}
if (strlen($searchMacAddress))
{
	$_SESSION['searchMacAddress'] = $searchMacAddress;
	$mac = $asset->FormatMacAddress($searchMacAddress);
	$param = AddEscapedParamIfNotBlank($param,"macAddress",trim($mac));
}
if (strlen($searchSerialNumber))
{
	$_SESSION['searchSerialNumber'] = $searchSerialNumber;
	$param = AddEscapedParamIfNotBlank($param,"serialNumber",$searchSerialNumber);
}
if (strlen($searchName))
{
	$_SESSION['searchName'] = $searchName;
	$param = AddEscapedLikeParamIfNotBlank($param,"name",$searchName);
}
$ok = $asset->Get($param);
while ($ok)
{
	$field = "asset".$asset->assetId;
	if (isset($_POST[$field]))
	{
		$assets->Add($asset->assetId);
	}
	$ok = $asset->Next();
}
$_SESSION['assetJumbo'] = $assets->data;
DebugPause("/assetJumbo/");
?>
