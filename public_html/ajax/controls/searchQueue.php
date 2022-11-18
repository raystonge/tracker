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
include_once "tracker/queue.php";
include_once "tracker/ticket.php";
include_once "tracker/organization.php";
$organizationId = GetTextField("organizationId",0);
$ticketId = GetTextField("ticketId",0);
$ticket = new Ticket($ticketId);
if (!$organizationId)
{
	$organizationId = $ticket->organizationId;
}
?>
				<?php if ($permission->hasPermission("Ticket: Search: Queue"))
				{
					if (!GetTextField("hideLabel",0))
					{
					?>
					<!-- Queue: -->
					<?php
					}
					?>
				<select name="queue" id="queue">
            <option value="0">Select a Queue</option>
            <?php
            $param = "";
            if ($organizationId)
            {
            	$param = AddEscapedParam($param,"organizationId",$organizationId);
            }
            else
            {
            	$param = "organizationId in (".GetMyOrganizations().")";
            }
            $queue = new Queue();
            $queue->SetOrderBy("organizationId");
            $ok = $queue->Get($param);
            DebugText("ticket queue:".$ticket->queueId);
            while ($ok)
            {
            	$selected = "";
            	if ($ticket->queueId == $queue->queueId )
            	{
            		$selected = "selected='selected'";
            	}            	?>
            	<option value="<?php echo $queue->queueId;?>" <?php echo $selected;?>><?php if (!$organizationId) { $organization = new Organization($queue->organizationId); echo $organization->name." - ";}?><?php echo $queue->name;?></option>
            	<?php
            	$ok = $queue->Next();
            }
            ?>
          </select>
          <?php
				}
				else
				{
					$queue = new Queue($ticket->queueId);
					CreateHiddenField("queue",$ticket->queueId);
					if ($permission->hasPermission("Ticket: View: Queue"))
					{
						echo $queue->name;
					}
				}
				//DebugOutput();
				?>
