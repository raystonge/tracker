<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
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
	     <select id="queueId" name="queueId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>

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
            	if ($ticket->queueId == $queue->queueId)
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
					if (!$queue->queueId)
					{
					    $queue->name = "Unassigned";
					}
					if ($permission->hasPermission("Ticket: View: Queue"))
					{
						echo "Queue: ".$queue->name;
					}
				}
				//DebugOutput();
				?>
