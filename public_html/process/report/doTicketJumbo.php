<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/module.php";
$moduleId = GetTextField("moduleId",0);
$module = new Module($moduleId);
$param = "";
$ticket = new Ticket();
$tickets = new Set(",");
$param = $module->GetParam();
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
$_SESSION['reportId']= $moduleId;
DebugPause("/ticketJumbo/");
?>