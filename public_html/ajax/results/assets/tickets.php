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
<fieldset>
  <legend>
    Associated Tickets
  </legend>
</fieldset>
<?php
include "globals.php";
include_once "tracker/assetToTicket.php";
include_once "tracker/ticket.php";
include_once "tracker/permission.php";
include_once "tracker/queue.php";
include_once "tracker/priority.php";
include_once "tracker/status.php";
include_once "tracker/comment.php";
$permission = new Permission();
?>
<table class="width100">
  <tr>
    <th>
      Ticket
    </th>
    <th>
      Subject
    </th>
    <th>
      Status
    </th>
    <th>
      Queue
    </th>
    <th>
      Priority
    </th>
    <th>
      Owner
    </th>
    <th>
      Last Updated
    </th>

  </tr>
<?php
  $assetId = GetTextField("assetId",0);
  $assetToTicket = new AssetToTicket();
  $ticket = new Ticket();
  $param = "assetId=".$assetId;
  $ok = $assetToTicket->Get($param);
  while ($ok)
  {
    $comment = new Comment();
    $param = "ticketId=".$assetToTicket->ticketId;
    $ok = $comment->Get($param);
  	$ticket = new Ticket($assetToTicket->ticketId);
  	?>
  <tr class="mritem">
    <td>
      	<?php
        $ticketLink = "";
      	if ($permission->hasPermission("Ticket: Edit"))
        {
          $ticketLink = "/ticketEdit/".$ticket->ticketId."/";
        	CreateLink("/ticketEdit/$ticket->ticketId/",$ticket->ticketId);
        }
        else
        {
        	if ($permission->hasPermission("Ticket: View"))
        	{
            $ticketLink = "/viewTicket/".$ticket->ticketId."/";
        		CreateLink("/viewTicket/$ticket->ticketId/",$ticket->ticketId);
        	}
        	else
        	{
        		echo $ticket->ticketId;
        	}

        }
	    ?>

    </td>
    <td>
      <a href="<?php echo $ticketLink;?>" title="<?php DisplayText(strip_tags($comment->comment),255);?>"><?php DisplayText($ticket->subject,45);?></a>
    </td>
    <td>
      <?php
      $status = new Status($ticket->statusId);
      echo $status->name;
       ?>
    </td>
    <td>
      <?php
      $queue = new Queue($ticket->queueId);
      echo $queue->name;
      ?>
    </td>
    <td>
      <?php
      $priority = new Priority($ticket->priorityId);
      echo $priority->name;
      ?>
      </td>
    <td>
      <?php
      $user= new User($ticket->ownerId);
      echo $user->fullName;
      ?>
     </td>
    <td>
      <?php echo $ticket->lastUpdated;?>
    </td>
  	<?php
  	$ok = $assetToTicket->Next();
  }
?>
</table>
<?php
$statusId = 1;
if ($statusId = 0)
{
  DebugText("This is true");
}
else {
  DebugText("This is false");
}
DebugOutput();
?>
