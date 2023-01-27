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
include_once "tracker/permission.php";
include_once "tracker/assetCredentials.php";
$button = "Create";
$formKey = "";
PageAccess("Asset: User Credentials");
$assetId = GetURI(2,0);
$assetCredentialsId = GetURI(3,0);
DebugText("assetCredentialsId:".$assetCredentialsId);
$assetCredentials = new AssetCredentials($assetCredentialsId);
$formKey = "";

if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($assetCredentials->assetCredentialsId)
{
	$button = "Update";
}

include $sitePath."/design/editors/userCredentials.php";
?>
