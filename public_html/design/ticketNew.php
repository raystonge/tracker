<?php
PageAccess("Ticket: Create","Ticket: Create: User Ticket");
?>
<div class="adminArea">
	<h2><a href="/listTickets/" class="breadCrumb">Tickets</a> -> New Ticket</h2>
<?php
include_once "tracker/ticket.php";
include_once "tracker/asset.php";
include_once "tracker/userToOrganization.php";
include_once "tracker/organization.php";
$ticket = new Ticket();
$ticket->organizationId = GetTextField("organization",0);
$assetId = GetTextFromSession("createTicketForAsset",0,0);

if ($assetId)
{
	$asset = new Asset($assetId);
	$ticket->organizationId = $asset->organizationId;
}
if (!$ticket->organizationId)
{
	$userToOrganization = new UserToOrganization();
	$param = AddEscapedParam("","userId",$currentUser->userId);
	$userToOrganization->Get($param);
	$ticket->organizationId = $userToOrganization->organizationId;

}
$organization = new Organization($ticket->organizationId);
$ticket->billable = $organization->billable;
DebugText("organization billable:".$organization->billable);
include $sitePath."/design/ticket/editor.php";
?>

</div>
