<?php
include_once "tracker/queue.php";
include_once "tracker/user.php";
include_once "tracker/status.php";
include_once "tracker/validStatus.php";
include_once "tracker/comment.php";
include_once "tracker/permission.php";
include_once "tracker/ticketDependencies.php";
include_once "tracker/ticketCC.php";
include_once "tracker/poNumber.php";
include_once "tracker/organization.php";
$blocks = new Set(",");
$depends = new Set(",");
$commentText = "";
$tickets = GetTextFromSession("ticketJumbo");
$ticket->PrepJumboEditor();
?>
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" >
$(document).ready(function ()
{

	 $(document).on("click", '#editDepend', function ()
        {
        	$("#dependIds").attr("class","showEdit");
        	$("#editDepend").attr("class","hidden");

        });
	 $(document).on("click", '#editBlock', function ()
        {
        	$("#blockIds").attr("class","showEdit");
        	$("#editBlock").attr("class","hidden");

        });
     $('#append').change(function() {
        if($(this).is(":checked")) {
            $('#prepend').prop('checked',false);
        }
    });
     $('#prepend').change(function() {
        if($(this).is(":checked")) {
            $('#append').prop('checked',false);
        }
    });


	 $("#queue").change(function () {
      link ="/ajax/selectors/defaultAssignee.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#assignee").val(theResponse);
      });
      link ="/ajax/selectors/defaultCC.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // clear what is selected
        $("#cc").val([]);
        // Display Results.
        $response = theResponse.split(",");
        $.each($response, function( intIndex, objValue ){
          $("#cc option[value=' + objValue + ']").attr("selected", true);
        });
      });
	 });
});
</script>
    <?php
    if (FormErrors())
    {
            $ticket->subject = GetTextFromSession("ticketSubject");
            $ticket->ownerId = GetTextFromSession("ticketAssigneeId");
            $ticket->queueId = GetTextFromSession("ticketQueueId");
            $ticket->requestorId = GetTextFromSession("ticketRequestorId");
            $ticket->statusId = GetTextFromSession("ticketStatusId");
            $ticket->priorityId = GetTextFromSession("ticketPriorityId");
            $ticket->poNumberId = $GetTextFromSession("ticketPONumber");
            $blocks->data = GetTextFromSession("ticketBlockData");
            $depends->data = GetTextFromSession("ticketDependsData");
            $commentText = GetTextFromSession("ticketComment");
            DisplayFormErrors();
    }
    ?>

	<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/ticket/ticketJumbo.php">
		<table>
			<tr>
				<td valign="top">    Queue:
				<?php if ($permission->hasPermission("Ticket: Edit: Queue"))
				{
					?>
				<select name="queue" id="queue">
            <option value="--do_not_change--">--do_not_change--</option>
            <?php
            $queue = new Queue();
						$queue->setOrderBy("organizationId,name");
            $ok = $queue->Get("");
            while ($ok)
            {
            	$selected = "";
            	if ($ticket->queueId == $queue->queueId)
            	{
            		$selected = "selected='selected'";
            	}
							$organization = new Organization($queue->organizationId);

							?>
            	<option value="<?php echo $queue->queueId;?>" <?php echo $selected;?>><?php echo $organization->name." - ".$queue->name;?></option>
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
					echo $queue->name;
					CreateHiddenField("queue",$queue->queueId);
				}
				?>
				</td>
				<td>

				Requestor:
				<?php if ($permission->hasPermission("Ticket: Edit: Requestor"))
				{
					?>
				<select name="requestor">
            <option value="--do_not_change--">--do_not_change--</option>
            <?php
            $user = new User();
            $ok = $user->Get("active=1");
            while ($ok)
            {
            	$selected = "";
            	if ($ticket->requestorId == $user->userId)
            	{
            		$selected = "selected='selected'";
            	}            	?>
            	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $user->fullName;?></option>
            	<?php
            	$ok = $user->Next();
            }
            ?>
            </select>
            <?php
				}
				else
				{
					$user = new User($ticket->requestorId);
					echo $user->fullName;
					CreateHiddenField("requestor",$ticket->requestorId);
				}
				?>
				</td>
			</tr>
			<tr>
			  <td>Priority:
				<?php if ($permission->hasPermission("Ticket: Edit: Priority"))
				{
					?>
			  <select name="priority" >
			  <option value="--do_not_change--" <?php if ($ticket->priorityId=="--do_not_change--"){echo "selected='selected'";}?>>--do_not_change--</option>
			  <option value="1" <?php if ($ticket->priorityId == 1){echo "selected='selected'";}?>>Urgent</option>
              <option value="2" <?php if ($ticket->priorityId == 2){echo "selected='selected'";}?>>High</option>
              <option value="3" <?php if ($ticket->priorityId == 3){echo "selected='selected'";}?>>Normal</option>
              <option value="4" <?php if ($ticket->priorityId == 4){echo "selected='selected'";}?>>Low</option>
              </select>
              <?php
				}
				else
				{
					$priority = new Priority($ticket->priorityId);
					echo $priority->name;
					CreateHiddenField("priority",$ticket->priorityId);
				}
				?>
			  </td>
			  <td>Status:
				<?php if ($permission->hasPermission("Ticket: Edit: Status"))
				{
					?>
			  <select name="status">
			  <option value="--do_not_change--">--do_not_change--</option>
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
            <?php
				}
				else
				{
					$status = new Status($ticket->statusId);
					echo $status->name;
					CreateHiddenField("status",$ticket->statusId);
				}
				?>
			  </td>
			</tr>

			<tr>
			  <td valign="top">Assignee:
				<?php if ($permission->hasPermission("Ticket: Edit: Assignee"))
				{
					?>
			  <select name="assignee" id="assignee">
			  <option value="--do_not_change--">--do_not_change--</option>
			<?php
            $user = new User();
            $user->setOrderBy("fullName");
            $ok = $user->GetAssignees("");
            while ($ok)
            {
            	?>
            	<option value="<?php echo $user->userId;?>"><?php echo $user->fullName;?></option>
            	<?php
            	$ok = $user->Next();
            }
            ?>
            </select>
            <?php
				}
				else
				{
					$user = new User($ticket->ownerId);
					echo $user->fullName;
					CreateHiddenField("assignee",$ticket->ownerId);
				}
				?>
			  </td>
			  <td valign="top"> CC:
              <?php if ($permission->hasPermission("Ticket: Edit: CC"))
				{
					?>

			  <select name="cc[]" size="5" id="cc" multiple="multiple">
			<?php
            $user = new User();
            $user->setOrderBy("fullName");
            $ok = $user->GetAssignees("");
            DebugText("Getting CCs");
            while ($ok)
            {
            	$ticketCC = new TicketCC();
            	$selected = "";
            	$param = "userId=".$user->userId;
            	$param = AddParam($param,"ticketId=".$ticket->ticketId);
            	if ($ticketCC->Get($param))
            	{
            		$selected = "selected='selected'";
            	}
            	?>
            	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $user->fullName;?></option>
            	<?php
            	$ok = $user->Next();
            }
            ?>
            </select>
            <?php
				}
				else
				{
					echo "need to put cc here";
				}
				?>
			  </td>
			</tr>
			<tr>
			  <td>
			  PO Number:
				<?php
				$po = new poNumber($ticket->poNumberId);
				if ($permission->hasPermission("Ticket: Edit: PO Number"))
				{
					?>
					<select id="poNumberId" name="poNumberId">
					  <option value="--do_not_change--">--do_not_change--</option>
					  <option value="0">Remove PO Number</option>
					  <?php
					    $ok = $po->Get("poType='Ticket'");
					    while ($ok)
					    {
					    	?>
					    	<option value="<?php $po->poNumberId;?>"><?php echo $po->poNumber;?></option>
					    	<?php
					    	$ok = $po->Next();
					    }
					  ?>
					</select>
					<?php
				}
				else
				{
					$po = new poNumber($ticket->poNumber);
					echo $po->poNumber;
				}
				?>
			  </td>
			  <td>&nbsp;
			  </td>
			</tr>
		</table>
		<table>
				<?php if ($permission->hasPermission("Ticket: Edit: Dependencies"))
				{
					$blocksStyle = "show";
					$dependsStyle = "show";
					if (strlen($blocks->data))
					{
						$blocksStyle = "hidden";
					}
					if (strlen($depends->data))
					{
						$dependsStyle = "hidden";
					}
					?>
		<tr>
		 <td valign="top">
		Blocks : </td><td><div id="blockIds" class="<?php echo $blocksStyle;?>"><input type="text" name="blocks" value="<?php echo $blocks->data;?>"/><br/></div>
		<?php
		if (strlen($blocks->data))
		{
			while ($blocks->GetIndex() >=0)
			{
				$blockTicket = new Ticket($blocks->GetValue());
				$ticketStatus = new Status($blockTicket->statusId);
				$ticketTitle = $ticketStatus->name." - ".$blockTicket->subject;
				$ticketClass = "statusNotClosed";
				if ($blockTicket->statusId == 4)
				{
					$ticketClass = "statusClosed";
				}
				?>
				<a href="/ticketEdit/<?php echo $blockTicket->ticketId;?>/" class="<?php echo $ticketClass;?>" title="<?php echo $ticketTitle;?>"><?php echo $blockTicket->ticketId;?></a>&nbsp;
				<?php
			}
			?>
			&nbsp;(<a href="#" id="editBlock" class="showEdit">edit</a>)
			<?php
		}
		?>
		</td>
		</tr>
		<tr>
		<td valign="top">
		Depends :</td><td><div id="dependIds" class="<?php echo $dependsStyle;?>">  <input type="text" name="depends" value="<?php echo $depends->data;?>"/><br/></div>
		<?php
		if (strlen($depends->data))
		{
			while ($depends->GetIndex() >=0)
			{
				$dependTicket = new Ticket($depends->GetValue());
				$ticketStatus = new Status($dependTicket->statusId);
				$ticketTitle = $ticketStatus->name." - ".$dependTicket->subject;
				$ticketClass = "statusNotClosed";
				if ($dependTicket->statusId == 4)
				{
					$ticketClass = "statusClosed";
				}
				CreateLink("/ticketEdit/$dependTicket->ticketId/",$dependTicket->ticketId,"ticket".$ticket->ticketId,$ticketTitle,$ticketClass);
				PrintNBSP();
			}
			?>
			(<?php CreateLink("#","edit","editDepend","Edit dependent Tickets","showEdit");?>
			)
			<?php

		}
		?></td>
		</tr>
		<?php
				}
				else
				{
					CreateHiddenField("blocks",$blocks->data);
					CreateHiddenField("depends",$depends->data);
				}
				?>
				</table>
		Subject :
				<?php if ($permission->hasPermission("Ticket: Edit: Subject"))
				{
					$fieldSize = getFieldSize("ticket","subject");
					CreateTextField("subject",$ticket->subject);
					CreateCheckBox("append",1,"Append");
					CreateCheckBox("prepend",1,"Prepend");
				}
				else
				{
					echo $ticket->subject;
					CreateHiddenField("subject",$ticket->subject);
				}
				?>
				<?php if ($permission->hasPermission("Ticket: Edit: Add Comment"))
				{
					?>

			    <textarea id="description" name="description" rows="10"  wrap="off"><?php echo $commentText;?></textarea>
			    <?php
				}
				PrintFormKey();
				CreateHiddenField("submitTest","1");
				//CreateHiddenField("ticketId",$ticket->ticketId);
				CreateHiddenField("ticketIds",$tickets);
				//CreateHiddenField("createTicketForAsset",$createTicketForAsset);
				CreateSubmit("Submit","Submit");
				?>
				</td>
	</form>
	<?php
	$comment = new Comment();
	$param = "ticketId=".$ticket->ticketId;
	$ok = $comment->Get($param);

	if ($ok && $permission->hasPermission("Ticket: Edit: View Comments"))
	{
		?><hr>
		<?php
	}
	?>
	<table>
	<?php
	while ($ok && $ticket->ticketId)
	{
		$user = new User($comment->userId);
		?>
		<tr>
		  <td><?php echo $user->fullName." on ".$comment->posted;?>
		  </td>
		</tr>
		<tr>
		  <td>
		  <?php echo $comment->comment;?>
		  </td>
		</tr>
		<?php
		$ok = $comment->Next();
	}
	?>
	</table>
<script type="text/javascript">
$(document).ready(function()
{
	var config = {
		skin:'v2',
		height: 500,
		toolbar:  [
['Source','DocProps'],
['Cut','Copy','Paste','PasteText','PasteFromWord','-',
'Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['SpellChecker','Scayt'],

'/',
['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','HorizontalRule'],
['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],['Link','Unlink','Maximize','ShowBlocks'] // No comma for the last row.
]
	};

 // alert("config editor");
	$("#description").ckeditor(config);
});
</script>
<script type="text/javascript">
//<![CDATA[
CKEDITOR.replace( 'description',
{
//extraPlugins : 'uicolor',
height: '200px',
} );
//]]>
</script>
