<?php
/*
 * Created on Aug 19, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/ticketCC.php";
include_once "tracker/ticket.php";
include_once "tracker/defaultUser.php";

$defaultUser = new DefaultUser();
$ticketId = GetTextField("ticketId",0);
$ticket = new Ticket($ticketId);
$organizationId = GetTextField("organizationId",0);
$ccs = new Set(",");
$queueId = GetTextField("queue",0);
$ticketCC = new TicketCC();
$param = AddParam("","ticketId=".$ticket->ticketId);
if ($ticket->ticketId)
{
	$ok = $ticketCC->Get($param);
	while ($ok)
	{
		$ccs->Add($ticketCC->userId);
		$ok = $ticketCC->Next();
	}
}
else
{
	$param = "userType='cc'";
	$param = AddEscapedParam($param,"queueId",$queueId);
	$ok = $defaultUser->Get($param);
	while ($ok)
	{
		$ccs->Add($defaultUser->userId);
		$ok = $defaultUser->Next();
	}}
?>
<?php if ($permission->hasPermission("Ticket: Edit: CC"))
{
	?>
	CC:
	<select name="cc[]" size="5" id="cc" multiple="multiple">
	  <?php
      $user = new User();
      $user->setOrderBy("fullName");
      $ok = $user->GetAssignees("uto.organizationId=".$organizationId);
      DebugText("Getting CCs");
      while ($ok)
      {
      	$selected = "";
        if ($ccs->InSet($user->userId))
        {
        	$selected = "selected='selected'";
        }
        ?>
        <option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $user->fullName;?></option>
        <?php
        $ok = $user->Next();
      }
      ?>
    </select>
    <?php
}
else
{
	if ($permission->hasPermission("Ticket: View: CC"))
	{
		echo "CC:<br>";
		$user = new User();
		$user->setOrderBy("fullName");
		$ok = $user->GetAssignees("");
		DebugText("Getting CCs");
		while ($ok)
		{
			$selected = "";
			if ($ccs->InSet($user->userId))
			{
				echo $user->fullName."<br>";
			}
			$ok = $user->Next();
        }
	}
}
?>
<?php // DebugOutput();?>