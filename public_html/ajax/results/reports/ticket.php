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
include_once "tracker/ticket.php";
include_once "tracker/queue.php";
include_once "tracker/user.php";
include_once "tracker/priority.php";
include_once "tracker/status.php";
include_once "tracker/permission.php";
include_once "tracker/module.php";
include_once "tracker/comment.php"

$ticket = new Ticket();
$ticket->SetPerPage($maxTicketsPerPage);
$param = $module->GetParam();
$pages = 1;
$ticket->SetOrderBy("dueDate desc,priorityId");
$numRows = $ticket->Count($param);
if ($ticket->perPage)
{
	$pages = ceil($numRows/$ticket->perPage);
}
$_SESSION['searchNumPerPage'] = $ticket->perPage;
$page = 1;
DebugText("Compute page we are on");
$page = GetURI(1,1);
$page = GetURI(2,1);
if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}
$page = GetTextField("page",$page);
$ticket->SetPage($page);
?>
<div class='result_bar'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      $firstDir = "listAssets";
      if ($pages > $maxAssetPages)
      {
      	$pages = $maxAssetPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = 'class="is_selected"';
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php

      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
<form name="assets" method="post" action="/process/ticket/jumbo.php">
<?php CreateHiddenField("moduleId",$module->moduleId);?>
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
    <th>
    &nbsp;
    </th>

  </tr>
<?php
  $ok = $ticket->Search($param);
  $showButton = $ok;
  if (!$permission->hasPermission("Ticket: Jumbo"))
  {
  	$showButton = 0;
  }
  $overDueDate = date('Y-m-d', strtotime($today. ' + 3 day'));
  while ($ok)
  {
		$comment = new Comment();
		$param = "ticketId=".$ticket->ticketId;
		$ok = $comment->Get($param);
  	$status = new Status($ticket->statusId);
  	$overDue = "";
  	if (strlen($ticket->dueDate))
  	{
  		if ($ticket->dueDate <= $overDueDate)
  		{
  			$overDue = "overDue";
  		}
  	}
  	?>
  <tr class="mritem <?php echo $overDue;?>">
    <td>
      	<?php
				$ticketLink = "";
      	if ($permission->hasPermission("Ticket: Edit"))
        {
					$ticketLink = "/ticketEdit/".$ticket->ticketId."/";
        	?>
        	<a href="/ticketEdit/<?php echo $ticket->ticketId;?>/"><?php echo $ticket->ticketId;?></a>
        	<?php
        }
        else
        {
        	if ($permission->hasPermission("Ticket: View"))
        	{
						$ticketLink = "/viewTicket/".$ticket->ticketId."/";
        		?>
        		<a href="/viewTicket/<?php echo $ticket->ticketId;?>/"><?php echo $ticket->ticketId;?></a>
        		<?php
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
      <?php echo $status->name;?>
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
    <td>
    <?php
    if ($permission->hasPermission("Ticket: Jumbo"))
    {
    	CreateCheckBox("ticket".$ticket->ticketId,$ticket->ticketId,"",0,"Select To Edit Ticket","ticket");
    }
    ?>
    <!--
    <input type="checkbox" name="ticket<?php echo $ticket->ticketId;?>" class="ticket"/>
    -->
    </td>
  	<?php
  	$ok = $ticket->Next();
  }
?>
</table>
<?php
if ($showButton)
{
?>
  <table class="width100">
    <tr>
      <td>
        <input type="submit" value="Jumbo" name="jumbo" id="jumboTicket"/>
      </td>
      <td align="right">
        <input type="button" value="Select All" name="addSelectAll" id="addSelectAll" />
        <input type="button" value="Unselect All" name="addUnselectAll" id="addUnselectAll" />
      </td>
    </tr>
  </table>
<?php
}
?>

</form>
<div class='result_bar'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      $firstDir = "listTickets";
      if ($pages > $maxTicketPages)
      {
      	$pages = $maxTicketPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = 'class="is_selected"';
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php

      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
<?php DebugOutput();?>
