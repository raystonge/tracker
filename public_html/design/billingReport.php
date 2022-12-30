``<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/ticket.php";
include_once "tracker/comment.php";
include_once "tracker/duplicateTicket.php";


PageAccess("Report: Billing");
$organizationId = GetTextField("organizationId",0);
$organization = new Organization($organizationId);
$startDate = GetTextField("startDate");
$stopDate = GetTextField("stopDate");
?>
<div class="adminArea">
<h2><a href="/billing/" class="breadCrumb">Billing Report</a><?php PrintNBSP(); PrintNBSP(); echo $organization->name;?></h2>
<p>Dates: <?php echo $startDate." - ".$stopDate;?></p>
<table width="100%">
  <tr>
    <th>Ticket</th><th>Description</th><th>Requestor</th><th>Date</th><th>Time</th>
  </tr>
  <?php

  $param = "statusId=4";
  $param = AddEscapedParam($param, "organizationId", $organizationId);
  $param = AddEscapedParamWithTest($param,"dateCompleted",">=",$startDate);
  $param = AddEscapedParamWithTest($param,"dateCompleted","<=",$stopDate);
  $ticket = new Ticket();
  $ok = $ticket->Get($param);
  $totalTime = 0;
  while ($ok)
  {
    $duplicateTicket = new DuplicateTicket();
    $param = AddEscapedParam("","duplicateOfId",$ticket->ticketId);
    $isDuplicate = $duplicateTicket->Get($param);
    if (!$isDuplicate)
    {
      $comment = new Comment();
      $param = "ticketId=".$ticket->ticketId;
      $okComment = $comment->Get($param);

      $totalTime = $totalTime+$ticket->timeWorked;
      $requestor = new User($ticket->requestorId);
      ?>
      <tr class="mritem">
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
      <?php
       $timeWorked = $ticket->timeWorked;
       $param = AddEscapedParam("","ticketId",$ticket->ticketId);
       $duplicateTicket = new DuplicateTicket();
       $hasDuplicates = $duplicateTicket->Get($param);
       while ($hasDuplicates)
       {
         $dupTicket = new Ticket($duplicateTicket->duplicateOfId);
         $timeWorked = $timeWorked + $dupTicket->timeWorked;
         $totalTime = $totalTime+$dupTicket->timeWorked;
         $hasDuplicates = $duplicateTicket->Next();
       }
      ?>
      </td>
      <td><a href="<?php echo $ticketLink;?>" title="<?php DisplayText(strip_tags($comment->comment),255);?>"><?php DisplayText($ticket->subject,45);?></a></td><td><?php echo $requestor->fullName;?></td><td><?php echo $ticket->dateCompleted;?></td>
      <td><?php echo sprintf("%01.2f", $timeWorked);?></td>
    </tr>
    <?php
    } ?>
      <?php
      $ok = $ticket->Next();
  }

  ?>
  <tr>
      <td>&nbsp;</td><td>Total Time worked</td><td>&nbsp;</td><td>&nbsp;</td><td><?php echo sprintf("%01.2f", $totalTime);?></td>

  </tr>
</table>
</div>
