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
include_once "tracker/ticket.php";
include_once "tracker/asset.php";
include_once "tracker/assetToTicket.php";
ProperAccessValidate("ticketAdd");
$ticketId = GetTextField('ticketId',0);
$ticket = new Ticket($ticketId);
if (!$ticket->ticketId)
{
	exit;
}
$asset = new Asset();
$ok = $asset->Get();
while ($ok)
{
  $fieldName = "asset".$asset->assetId;
  $assetToTicket = new AssetToTicket();
  $param = AddEscapedParam("","assetId",$asset->assetId);
  $param = AddEscapedParam($param,"ticketId",$ticketId);
  if (GetTextField($fieldName,0) && !$assetToTicket->Get($param))
  {
    $assetToTicket = new AssetToTicket();
    $assetToTicket->assetId = $asset->assetId;
    $assetToTicket->ticketId = $ticketId;
    $assetToTicket->Insert();
  }
  $ok = $asset->Next();
}
DebugPause("/ticketAssets/".$ticketId."/");
