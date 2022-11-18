<?php
/*
 * Created on Dec 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
$ticketId = GetURLVar("ticketId",0);
if (!$ticketId)
{
	DebugPause("/listTickets/");
}
$_SESSION['createDependentTicket'] = $ticketId;
DebugPause("/ticketNew/");
?>