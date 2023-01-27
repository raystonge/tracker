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
include_once "tracker/monitor.php";
include_once "tracker/asset.php";
include_once "tracker/permission.php";
$state = 0;
$buildingId = 0;
$assetTypeId = 0;
$query = "select m.* from monitor m inner join asset a on m.assetId=a.assetId";
$param = "active=1";
if ($buildingId)
{
	$param = AddEscapedParam($param,"a.buildingId",$buildingId);
}
if ($state >=0)
{
	$param = AddEscapedParam($param,"m.state",$state);
}
if ($assetTypeId)
{
	$param = AddEscapedParam($param,"a.assetTypeId",$assetTypeId);
}
if (strlen($param))
{
	$query = $query." where ".$param;
}
$monitor = new Monitor();
$ok = $monitor->doSelectQuery($query);
if ($ok && $permission->hasPermission("Monitor"))
{
	$pageTitle = $pageTitle." ($monitor->numRows) Devices Down";
}
$status = "success";
echo '{"status":"'.$status.'","pageTitle":"'.$pageTitle.'"}';
exit;
?>
