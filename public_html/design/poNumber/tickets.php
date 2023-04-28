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
include_once "tracker/permission.php";
include_once "tracker/status.php";
include_once "tracker/user.php";
$param = "";
$pages = 1;
$ticket = new Ticket();
$poNumberId= $request_uri[2];
$numRows = 0;
$param = AddEscapedParam("", "poNumberId", $poNumberId);
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
      $firstDir = "listTickets";
      if ($pages > $maxTicketPages)
      {
      	$pages = $maxTicketPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = "is_selected";
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
<table class="width100">
  <tr>
    <th>Tickit Id
    </th>
    <th>
    Description
    </th>
    <th>
    Status
    </th>
    <th>
    Requestor
    </th>
    <th>Assignee
    </th>
    <th>
    &nbsp;
    </th>
  </tr>
  <?php
  $ticketPO = new TicketPO();
  $ok = $ticketPO->Search($param);
  $showButton = $ok;
  while ($ok)
  {
    $ticket = new Ticket($ticketPO->ticketId);
  	?>
  <tr class="mritem">
    <td>
      	<?php
      	if ($permission->hasPermission("Ticket: Edit"))
        {
          $title = "Edit Ticket";
        	CreateLink("/ticketEdit/$ticket->ticketId/",$ticket->ticketId,"ticket".$ticket->ticketId,$title);
        }
        else
        {
        	if ($permission->hasPermission("Ticket: View"))
        	{
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
    <?php echo $ticket->subject;?>
    </td>
    <td>
    <?php
    $status = new Status($ticket->statusId);
    echo $status->name;
    ?>
    </td>
    <td>
    <?php
    $requestor = new User($ticket->requestorId);
    echo $requestor->fullName;
    ?>
    </td>
    <td>
      <?php
      $assignee = new User($ticket->ownerId);
      echo $requestor->fullName;
      ?>
    </td>

    <td>
    </td>
  </tr>
  	<?php
  	$ok = $ticketPO->Next();
  }
  ?>
</table>
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
<?php
DebugOutput();
?>
