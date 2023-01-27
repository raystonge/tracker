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
include_once "tracker/module.php";
$moduleId = GetTextField("moduleId",0);
$module = new Module($moduleId);
$param = "";
$asset = new Asset();
$assets = new Set(",");
$param = $module->GetParam();
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
$_SESSION['reportId']= $moduleId;
DebugPause("/assetJumbo/");
?>
