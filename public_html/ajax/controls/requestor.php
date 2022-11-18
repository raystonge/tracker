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
$organizationId = GetTextField("organization",0);
$ticket = new Ticket($ticketId);
$queueId = GetTextField("queue",0);

?>
			    <select name="searchRequestorId" id="searchRequestorId">
			      <option value="0">All</option>
			      <?php
			      $user = new User();
			      $param = "active=1";
			      $param = AddEscapedParam($param,"uto.organizationId",$organizationId);
			      $ok = $user->GetRequestors($param);
			      while($ok)
			      {
							$userInfo = new User($user->userId);
			      	$selected="";
			      	if ($user->userId == $searchRequestorId)
			      	{
			      		$selected = "selected='selected'";
			      	}
			      	?>
			      	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $userInfo->fullName;?></option>
			      	<?php
			      	$ok = $user->Next();
			      }
			      ?>
			    </select>
