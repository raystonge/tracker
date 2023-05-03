<?php
//
//  Tracker - Version 1.8.1
//
//  v1.8.1
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
include_once "tracker/assetCredentials.php";
$assetCredentialsId = $request_uri[2];
$assetCredentialsId = GetURI(2,0);
$key = GetURI(3,"");
if (!$assetCredentialsId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteAssetType"))
{
	echo "This is not allowed at this time";
	exit;
}
$assetCredentials = new AssetCredentials($assetCredentialsId);
if (!$assetCredentials->assetCredentialsId)
{
	echo "Invalid operation";
	exit;
}
$param = "assetCredentialsId=".$assetCredentials->assetCredentialsId;
if (!$assetCredentials->Get($param))
{
	echo "Asset Credentials cannot be deleted because assets of that type exist.";
}
else
{
	$assetCredentials->Delete();
	echo "Asset Credentials ".$assetCredentials->userName." has been deleted";
}
?>
