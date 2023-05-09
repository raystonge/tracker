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
include_once "tracker/status.php";
include_once "tracker/ticket.php";
$statusId = GetURI(2,0);
$key = GetURI(3,"");
if (!$statusId)
{
	echo "Invalid operation";
	exit;
}
if (!testLinkKey($key,"deleteStatus"))
{
	echo "This is not allowed at this time";a
	exit;
}

$status = new Status($statusId);
if (!$status->statusId)
if (!$statusId)
{
	echo "Invalid operation";
	exit;
}
$ticket = new Ticket();
$param = "statusId=".$status->statusId;
if ($ticket->Get($param))
{
	echo "Status ".$ticket->name." cannot be deleted because tickets are marked for that status.";
}
else
{
	$status->Delete();
	echo "Status ".$status->name." has been deleted";
}
?>
