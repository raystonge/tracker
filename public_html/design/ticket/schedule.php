<?php
include_once "tracker/insurancePayment.php";
include_once "tracker/insuranceRepair.php";
include_once "tracker/insuranceRepairComplete.php";
include_once "tracker/user.php";
include_once "tracker/comment.php";
include_once "tracker/status.php";
include_once "tracker/validStatus.php";

//PageAccess("Ticket: Schedule");


$formKey = "";
$commentText = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if (FormErrors())
{
   	DisplayFormErrors();
}
if (FormSuccess())
{
	DisplayFormSuccess();
}
?>

<script type="text/javascript">
adminFilePath="";
function toggle()
{
  var dueDate = document.getElementById('dueDate');
  dueDate.disabled = !dueDate.disabled;

}
function disableDueDate()
{
	var dueDate = document.getElementById('dueDate');
  dueDate.disabled =  true;
}
function enableDueDate()
{
  var dueDate = document.getElementById('dueDate');
  dueDate.disabled = false;
}

</script>

	<form method="post" autocomplete="<?php echo $autoComplete;?>"  action="/process/ticket/schedule.php">
		<table>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Ticket: Edit: Due Date") || $permission->hasPermission("Ticket: View: Due Date"))
			  {
			  	?>
			  <table>
			    <tr>
			     <td span="2">Due Date :

			  <?php
				DebugText("dueDate0:".$ticket->dueDate);
			  if ($permission->hasPermission("Ticket: Edit: Due Date"))
			  {
			      $on = 0;
						DebugText("dueDate:".$ticket->dueDate);
			      if (strlen($ticket->dueDate))
			      {
			          $on = 1;
			      }
						DebugText("on:".$on);
			      CreateCheckBox("useDueDate",1,"Enable Due Date",$on,"Click to enable the due date","","onclick='toggle()'");
			      PrintBR();
			      CreateDatePicker("dueDate",$ticket->dueDate);

			  }
			  else
			  {
			  	if ($permission->hasPermission("Ticket: View: Due Date"))
			  	{
			  		echo $ticket->dueDate;
			  	}
			  	CreateHiddenField("dueDate",DatePickerFormatter($ticket->dueDate));
			  	CreateHiddenField("userDueDate",$on);
			  }
			  ?>
			      </td>
			    </tr>
			    			<tr>
				<td>Billable: <?php CreateCheckBox("billable",1,"",$ticket->billable); ?> </td>
				<td>&nbsp; </td>
			</tr>
			<?php
			$status = new Status($ticket->statusId);
			if ($status->name != "Closed")
			{
			?>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Ticket: Edit: Time Estimate"))
			  {
				?>Time Estimate: <?php CreateTextField("timeEstimate",$ticket->timeEstimate,0,"Estimate of how many hours",$editFieldClass);?>
				<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Ticket: View: Time Estimate"))
			  	{
			  		echo "Time Estimate: ".$ticket->timeEstimate;
			  	}
			  		CreateHiddenField("timeEstimate",$ticket->timeEstimate);
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Ticket: Edit: Time Worked"))
			  {
			  	?>
			  Time Worked: <?php CreateTextField("timeWorked",$timeWorked,0,"Actual time worked",$editFieldClass);?>
			  <?php
			  }

			  ?>
			  </td>
			</tr>
			<?php
			}
			?>
			<tr>
			 <td colspan="2">
			Status:
			  <select name="status">
			  <option value="0">Select Status</option>
			<?php
			$validStatus = new ValidStatus();


            $ok = $validStatus->GetForCurrentStatus($ticket->statusId);
            while ($ok)
            {
            	$status = new Status($validStatus->statusId);
            	$selected = "";
            	if ($ticket->statusId == $status->statusId)
            	{
            		$selected = "selected='selected'";
            	}
            	?>
            	<option value="<?php echo $status->statusId;?>" <?php echo $selected;?>><?php echo $status->name;?></option>
            	<?php
            	$ok = $validStatus->Next();
            }
            ?>
            </select>
            </td>
			</tr>

			  </table>
			  <?php
			  }
			  ?>
			  </td>
			  <td>
			  &nbsp;
			  </td>
			</tr>
		</table>
		<textarea id="description" name="description" rows="5"  wrap="off"><?php echo $commentText;?></textarea>
		<?php
		CreateHiddenField("submitTest",1);
		CreateHiddenField("ticketId",$ticket->ticketId);
		PrintFormKey();
		if ($permission->hasPermission("Ticket: Edit: Time Estimate") ||
		    $permission->hasPermission("Ticket: Edit: Time Worked") ||
		    $permission->hasPermission("Ticket: Edit: Due Date")
		)
		{
			CreateSubmit();
		}
		?>
    </form>
<table width="100%">
	<tr>
		<th>
			Date
		</th>
		<th>
			User
		</th>
		<th>
			Time Worked
		</th>
	  <th>
			Comment
		</th>
	</tr>
	<?php
  $timeWorked = new TimeWorked();
	$param = "ticketId=".$ticket->ticketId;
	$ok = $timeWorked->Get($param);
	while ($ok)
	{
		?>
		<tr>
			<td>
				<?php echo $timeWorked->dateWorked;?>
			</td>
		  <td>
			  <?php
				$user = new User($timeWorked->userId);
				echo $user->fullName;
				?>
			</td>
			<td>
				<?php echo $timeWorked->amtWorked;?>
			</td>
			<td>
				<?php
				$comment = new Comment($timeWorked->commentId);
				echo $comment->comment;?>

			</td>
		</tr>
		<?php
		$ok = $timeWorked->Next();
	}
	 ?>
</table>
<?php
if (!strlen($ticket->dueDate))
{
	?>
<script type="text/javascript">
disableDueDate();
</script>
<?php
}
else
{
	?>
<script type="text/javascript">
enableDueDate();
</script>
<?php

}
?>
