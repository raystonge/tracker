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
