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
include_once "tracker/assetType.php";
$button = "Create";
$formKey = "";
PageAccess("Config: AssetType Edit");
$assetTypeId = GetURI(2,0);
$assetType = new AssetType($assetTypeId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($assetType->assetTypeId)
{
	$button = "Update";
}

include $sitePath."/design/editors/assetType.php";
?>
