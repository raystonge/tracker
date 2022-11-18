<?php 
include_once "globals.php";
ValidateFormKey("searchKey");
include_once "tracker/ticket.php";
include_once "tracker/asset.php";
$searchText = GetTextField("s");
if (is_numeric($searchText))
{
	$ticket = new Ticket($searchText);
	if ($ticket->ticketId)
	{
		DebugPause("/ticketEdit/".$ticket->ticketId."/");
	}
}
$param = AddEscapedParam("","serialNumber",$searchText);
$asset = new Asset();
if ($asset->Get($param))
{
	DebugPause("/assetEdit/".$asset->assetId."/");
}
$_SESSION['searchText'] = $searchText;
DebugPause("/search/");
?>