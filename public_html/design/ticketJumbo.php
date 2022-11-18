<?php
include_once "tracker/permission.php";
$permission = new Permission();
/*
if (!$permission->hasPermission("Config: Queue"))
{
	include $sitePath."/design/noAccess.php";
}*/
include_once "tracker/ticket.php";
$ticket = new Ticket();
include $sitePath."/design/ticket/jumboEditor.php";
?>