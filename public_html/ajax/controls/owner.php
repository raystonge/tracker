<?php
/*
 * Created on Aug 16, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/defaultUser.php";
$ticketId = GetTextField("ticketId",0);
$organizationId = GetTextField("organizationId",0);
$ticket = new Ticket($ticketId);
$queueId = GetTextField("queue",0);
if (!$ticket->ticketId)
{
	$defaultUser = new DefaultUser();
    $param = "userType='assignee'";
    $param = AddEscapedParam($param,"queueId",$queueId);
    $defaultUser->Get($param);
    $ticket->ownerId = $defaultUser->userId;
}

if ($permission->hasPermission("Ticket: Edit: Assignee"))
{
	if (!GetTextField("hideLabel",0))
	{
?>
Assignee:
<?php
	}
	?>
<select name="assignee" id="assignee">
  <option value="0">Select Assignee</option>
  <?php
  $user = new User();
  $user->setOrderBy("fullName");
	$param = "uto.organizationId in (".GetMyOrganizations().")";
	if ($organizationId)
	{
		$param = "uto.organizationId=".$organizationId;
	}

  $ok = $user->GetAssignees($param);
  while ($ok)
  {
  	$select = "";
    if ($user->userId == $ticket->ownerId)
    {
    	$select = "selected='selected'";
    }
    ?>
    <option value="<?php echo $user->userId;?>" <?php echo $select;?>><?php echo $user->fullName;?></option>
    <?php
    $ok = $user->Next();
  }
  ?>
</select>
<?php
}
else
{
	$user = new User($ticket->ownerId);
	if ($permission->hasPermission("Ticket: View: Assignee"))
	{
		echo "Assignee: ".$user->fullName;
	}
	CreateHiddenField("assignee",$ticket->ownerId);
}
?>
