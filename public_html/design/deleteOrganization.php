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
include_once "tracker/organization.php";
include_once "tracker/ticket.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/contract.php";
include_once "tracker/poNumber.php";
include_once "tracker/queue.php";

$organizationId = GetURI(2,0);
$key = GetURI(3,"");
if (!$organizationId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteOrganization"))
{
	echo "This is not allowed at this time";
	exit;
}

$organization = new Organization($organizationId);
if (!$organization->organizationId)
if (!$organizationId)
{
	echo "Invalid operation";
	exit;
}
$param = AddEscapedParam("","organizationId",$organizationId);
$inUser = 0;
$ticket = new Ticket();
$asset = new Asset();
$assetType = new AssetType();
$building = new Building();
$contract = new Contract();
$po = new poNumber();
$queue = new Queue();

if ($ticket->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are tickets to the organization.<br>";
  $inUse = 1;
}
if ($asset->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are assets to the organization.<br>";
  $inUse = 1;
}
if ($assetType->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are Asset Types to the organization.<br>";
  $inUse = 1;
}
if ($building->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are buildings to the organization.<br>";
  $inUse = 1;
}
if ($contract->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are contracts to the organization.<br>";
  $inUse = 1;
}
if ($po->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are Purchase Orders to the organization.<br>";
  $inUse = 1;
}
if ($queue->Get($param))
{
  echo "Organizion ".$organization->name." cannot be deleted because there are queues to the organization.<br>";
  $inUse = 1;
}
if ($inUse)
{
  echo "Organization ".$organization->name." has not been deleted<br>";
  exit;
}
$organization->Delete();
echo "Organization ".$organization->name." has been deleted";
