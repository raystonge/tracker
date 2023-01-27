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

$_SESSION['formErrors'] ="";
$_SESSION['assetAdminAccount'] = "";
$_SESSION['assetAdminPassword'] = "";

ProperAccessValidate();
if (isset($_POST['submitTest']))
{
	$assetId = GetTextField("assetId");
	$asset = new Asset($assetId);
	if ($asset->assetId == 0)
	{
		DebugText("no assetId");
		DebugPause("/listAssets/");
	}
	$asset->adminUser = GetTextField("adminUser");
	$asset->adminPassword = GetTextField("adminPassword");
	$asset->Persist();
	$_SESSION['formSuccess'] = "Success";
	DebugPause("/assetAccount/".$assetId);
}
DebugText("submitTest failed");
DebugPause("/listAssets/");
?>
