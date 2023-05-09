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
include_once "tracker/building.php";
include_once "tracker/asset.php";
$buildingId = GetURI(2,0);
$key = GetURI(3,"");
if (!$buildingId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteBuilding"))
{
	echo "This is not allowed at this time";
	exit;
}

$building = new Building($buildingId);
if (!$building->buildingId)
if (!$buildingId)
{
	echo "Invalid operation";
	exit;
}
$asset = new Asset();
$param = "buildingId=".$building->buildingId;
if ($asset->Get($param))
{
	echo "Building ".$building->name." cannot be deleted because assets are marked for that building.";
}
else
{
	$building->Delete();
	echo "Building ".$building->name." has been deleted";
}
?>
