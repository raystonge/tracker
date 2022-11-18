<?php
/*
 * Created on Oct 29, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
