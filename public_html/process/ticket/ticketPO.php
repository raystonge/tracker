<?php
//
//  Tracker - Version 1.8.0
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
include_once "tracker/ticket.php";
include_once "tracker/ticketPO.php";

ProperAccessValidate();
if (!GetTextField("submitTest",0))
{
	DebugPause("/");
}
$html = "";
$numErrors = 0;
$errMsg = "";

$ticketId = GetTextField("ticketId",0);
if (!$ticketId)
{
	DebugPause("/");
}
$poNumberId = GetTextField("poNumberId");

if (!$poNumberId)
{
	$numErrors++;
	$errMsg = $errMsg."<li>Please select a PO Number</li>";
}
$ticketPO = new TicketPO();
$param = AddEscapedParam("","ticketId",$ticketId);
$param = AddEscapedParam($param,"poNumberId",$poNumberId);
if ($ticketPO->Get($param))
{
	$numErrors++;
	$errMsg = $errMsg."<li>PO is already assigned to this ticket</li>";
}
if ($numErrors)
{
	$html = "<ul>".$errMsg."</ul>";
	$_SESSION['formErrors'] = $html;
	DebugPause("/ticketPO/".$ticketId."/");
}
$ticketPO->ticketId = $ticketId;
$ticketPO->poNumberId = $poNumberId;
$ticketPO->Persist();
DebugPause("/ticketPO/".$ticketId."/");
?>
