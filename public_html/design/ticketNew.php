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
PageAccess("Ticket: Create","Ticket: Create: User Ticket");
?>
<div class="adminArea">
	<h2><a href="/listTickets/" class="breadCrumb">Tickets</a> -> New Ticket</h2>
<?php
include_once "tracker/ticket.php";
include_once "tracker/asset.php";
include_once "tracker/userToOrganization.php";
include_once "tracker/organization.php";
$ticket = new Ticket();
$ticket->organizationId = GetTextField("organization",0);
$assetId = GetTextFromSession("createTicketForAsset",0,0);

if ($assetId)
{
	$asset = new Asset($assetId);
	$ticket->organizationId = $asset->organizationId;
}
if (!$ticket->organizationId)
{
	$userToOrganization = new UserToOrganization();
	$param = AddEscapedParam("","userId",$currentUser->userId);
	$userToOrganization->Get($param);
	$ticket->organizationId = $userToOrganization->organizationId;

}
$organization = new Organization($ticket->organizationId);
$ticket->billable = $organization->billable;
DebugText("organization billable:".$organization->billable);
include $sitePath."/design/ticket/editor.php";
?>

</div>
