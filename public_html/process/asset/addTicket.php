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
include_once "tracker/ticket.php";
include_once "tracker/assetToTicket.php";

$_SESSION['formErrors'] ="";
$_SESSION['assetTicketId'] = "";
$html = "";
$numErrors = 0;

//ProperAccessValidate();
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
if (!$asset->assetId)
{
  DebugPause("/");
}
$ticketId = GetTextField("ticketId",0);
$ticket = new Ticket($ticketId);
if (!$ticket->ticketId)
{
  $html = "<li>Ticket Number does not exist</li>";
  $numErrors++;
}

$assetToTicket = new AssetToTicket();
$param = AddEscapedParam("","assetId",$assetId);
$param = AddEscapedParam($param,"ticketId",$ticketId);
$ok = $assetToTicket->Get($param);
if ($ok)
{
  $numErrors++;
  $html = $html."<li>Ticket Number already assigned</li>";

}

if ($numErrors)
{
  $_SESSION['formErrors'] = $html;
  DebugPause("/assetTickets/".$asset->assetId."/");
}
$assetToTicket->assetId = $assetId;
$assetToTicket->ticketId = $ticketId;
$assetToTicket->Insert();
$_SESSION['formSuccess'] = "Success";
DebugPause("/assetTickets/".$asset->assetId."/");
?>
