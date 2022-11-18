<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/history.php";
include_once "tracker/user.php";
$history = new History();
?>
<table class="width100">
  <th>
  Date
  </th>
  <th>
  User
  </th>
  <th>
  Action
  </th>
  <?php
  $ok = $history->GetForTicket($ticket->ticketId);
  while ($ok)
  {
  	$user = new User($history->userId);
  	?>
  	<tr>
      <td>
      <?php echo $history->actionDate;?>
      </td>
      <td>
      <?php echo $user->fullName;?>
      </td>
      <td>
      <?php echo $history->action;?>
      </td>
    </tr>
  	<?php
  	$ok = $history->Next();
  }
  ?>
</table>