<?php
/*
 * Created on Oct 29, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include "globals.php";
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/assetToTicket.php";
$assetId = 0;
$ticketId = 0;
$historyArray = array();
if (isset($_POST['ticketId']))
{
	$ticketId = $_POST['ticketId'];
}
$ticket = new Ticket($ticketId);
DebugText("ticketId:".$ticket->ticketId);
$param  = AddEscapedParam("","ticketId",$ticket->ticketId);
$assetToTicket = new AssetToTicket();
$ok = $assetToTicket->Get($param);

while ($ok)
{
	$field="attachedAsset".$assetToTicket->assetId;
	if (isset($_POST[$field]))
	{
		$asset = new Asset($assetToTicket->assetId);
		$assetToTicket->Delete();
  		$historyText = "";
  		if (strlen($asset->serialNumber))
  		{
  			$historyText = "Serial Number: ".$asset->serialNumber;
  		}
  		else
  		{
  			if (strlen($asset->assetTag))
  			{
  				$historyText = "Asset Tag: ".$asset->assetTag;
  			}
  			else
  			{
  				$historyText = "Asset Id:".$asset->assetId;
  			}
  		}
		$historyVal = "Removed Asset ".$historyText;
		array_push($historyArray,$historyVal);

	}
	$ok = $assetToTicket->Next();
}
  		$historyVal = array_pop($historyArray);
		DebugText("sizeof History:".sizeof($historyArray));
		while (strlen($historyVal))
		{
			DebugText("historyVal:".$historyVal);
			$history = new History();
			$history->ticketId = $ticket->ticketId;
			$history->userId = $_SESSION['userId'];
			$history->actionDate = $now;
			$history->action = $historyVal;
			$history->Insert();
			$historyVal = array_pop($historyArray);
		}

//DebugOutput();
?>
