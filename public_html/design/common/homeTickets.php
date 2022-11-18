<?php
/*
 * Created on Jan 27, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/status.php";
include_once "tracker/priority.php";
include_once "tracker/user.php";
include_once "tracker/organization.php";
include_once "tracker/comment.php";
?>
  <table id="myTickets" class="tablesorter" width="100%">
    <tr>
      <th>
      Ticket
      </th>
      <th>
        Org
      </th>
      <th>
      Subject
      </th>
      <th>
      Status
      </th>
      <th>
      Requestor
      </th>
      <th>
      Queue
      </th>
      <th>
      Last Updated
      </th>
    </tr>
    <?php
    $overDueDate = date('Y-m-d', strtotime($today. ' + 3 day'));
    DebugText("in homeTickets");
    $ticket = new Ticket();

    $ticket->SetOrderBy("dueDate desc,priorityId asc");
    $ok = $ticket->Get($param);
    while ($ok)
    {
      $ticketLink = "/ticketEdit/".$ticket->ticketId."/";
      $comment = new Comment();
      $param = "ticketId=".$ticket->ticketId;
      $ok = $comment->Get($param);
    	$status = new Status($ticket->statusId);
    	$rowClass = "";
    	$priority = new Priority($ticket->priorityId);
    	if ($priority->sortOn <= 2)
    	{
    		$rowClass="urgent";
    	}
    	if (strlen($ticket->dueDate))
    	{
    		if ($ticket->dueDate <= $today)
    		{
    			$rowClass = "overDue";
    		}
    		else
    		{
    		if ($ticket->dueDate <= $overDueDate)
    		{
    			$rowClass = "comingDue";
  		    }
    		}
  	    }
       if ($ticket->priorityId == 4)
       {
         $rowClass = $rowClass." lowPriority";
       }
     ?>
    <tr  class="mritem <?php echo $rowClass;?>">
      <td>
      <a href="/ticketEdit/<?php echo $ticket->ticketId;?>/">
      <?php echo $ticket->ticketId;?>
      </a>
      </td>
      <?php $organization = new Organization($ticket->organizationId);?>
      <td>
        <?php echo $organization->assetPrefix;?>
      </td>

      <td>
        <a href="<?php echo $ticketLink;?>" title="<?php DisplayText(strip_tags($comment->comment),255);?>"><?php DisplayText($ticket->subject,45);?></a>
      </td>
      <td>
      <?php echo $status->name;?>
      </td>
      <td>
      <?php
      $owner = new User($ticket->requestorId);
      echo $owner->fullName;
      ?>
      </td>
      <td>
      <?php
      $queue = new Queue($ticket->queueId);
      echo $queue->name;
      ?>
      </td>
      <td>
      <?php echo $ticket->lastUpdated;?>
      </td>
    </tr>
     <?php
    	$ok = $ticket->Next();
    }
    ?>
  </table>
