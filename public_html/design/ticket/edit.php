<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include "globals.php";
include_once "tracker/ticket.php";
$ticketId = 0;
if (isset($_GET['ticketId']))
{
	$ticketId = $_GET['ticketId'];
}
$ticket = new Ticket($ticketId);
include $sitePath."/design/ticket/editor.php";
?>
