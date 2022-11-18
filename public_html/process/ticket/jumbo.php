<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/mailSupport.php";
include_once "tracker/history.php";
$param = "";

$tickets = new Set(",");
  $searchQueueId = GetTextField("searchQueueId",0);
  $searchPriorityId = GetTextField("searchPriorityId",0);
  $searchOwnerId = GetTextField("searchOwnerId",0);
  $searchRequestorId = GetTextField("searchRequestorId",0);
  $searchStatusId = GetTextField("searchStatusId",0);

  $ticket = new Ticket();
  $param = "";
  if ($searchQueueId)
  {
  	$param = AddEscapedParam($param,"queueId",$searchQueueId);
  }

  if ($searchPriorityId)
  {
  	$param = AddEscapedParam($param,"priorityId",$searchPriorityId);
  }
  if ($searchRequestorId)
  {
  	$param = AddEscapedParam($param,"requestorId",$searchRequestorId);
  }
  if ($searchOwnerId)
  {
  	$param = AddEscapedParam($param,"ownerId",$searchOwnerId);
  }
  if ($searchStatusId)
  {
  	if ($searchStatusId == -1)
  	{
  		$param = AddParam($param,"statusId <> 4");
  	}
  	else
  	{
  		$param = AddEscapedParam($param,"statusId",$searchStatusId);
  	}
  }
$ok = $ticket->Get($param);
while ($ok)
{
	$field = "ticket".$ticket->ticketId;
	if (isset($_POST[$field]))
	{

		$tickets->Add($ticket->ticketId);
	}
	$ok = $ticket->Next();
}
$_SESSION['ticketJumbo'] = $tickets->data;
DebugPause("/ticketJumbo/");
?>
