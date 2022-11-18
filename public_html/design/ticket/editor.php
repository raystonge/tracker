<?php
include_once "tracker/queue.php";
include_once "tracker/user.php";
include_once "tracker/status.php";
include_once "tracker/validStatus.php";
include_once "tracker/comment.php";
include_once "tracker/permission.php";
include_once "tracker/ticketDependencies.php";
include_once "tracker/ticketCC.php";
include_once "tracker/asset.php";
include_once "tracker/building.php";
include_once "tracker/priority.php";
include_once "tracker/organization.php";
include_once "tracker/set.php";
include_once "tracker/timeWorked.php";
$depends = new Set(",");
$ticketDependencies = new TicketDependencies();
$param = "blockId=".$ticket->ticketId;
DebugText("before $depends->data:".$depends->data);

$ok = $ticketDependencies->Get($param);
while ($ok)
{
	$depends->Add($ticketDependencies->dependsId);
	DebugText("$depends->data:".$depends->data);
	$ok = $ticketDependencies->Next();
}
$blocks = new Set(",");
$param = "dependsId=".$ticket->ticketId;
$ok = $ticketDependencies->Get($param);
while ($ok)
{
	$blocks->Add($ticketDependencies->blockId);
	DebugText("depends->data:".$blocks->data);
	$ok = $ticketDependencies->Next();
}
DebugText("after blocks->data:".$blocks->data);

$commentText = "";
$queue = new Queue();
$formKey = getFormKey();
DebugText("get createTicketForAsset");
$createTicketForAsset  = GetTextFromSession("createTicketForAsset",0);
$createDependentTicket = GetTextFromSession("createDependentTicket",0);
$createBlockTicket = GetTextFromSession("createBlockTicket",0);
if ($createDependentTicket)
{
	$depends->Add($createDependentTicket);
	DebugText("after adding depended ticket blocks->data:".$blocks->data);

}
if ($createBlockTicket)
{
	$blocks->Add($createBlockTicket);
}
if ($createTicketForAsset)
{
	$asset = new Asset($createTicketForAsset);
	$building = new Building($asset->buildingId);
	$ticket->queueId = $building->queueId;
	DebugText("Queue for asset:".$ticket->queueId);
}
?>
<style>
.custom-combobox {
position: relative;
display: inline-block;
}
.custom-combobox-toggle {
position: absolute;
top: 0;
bottom: 0;
margin-left: -1px;
padding: 0;
/* support: IE7 */
*height: 1.7em;
*top: 0.1em;
}
.custom-combobox-input {
margin: 0;
padding: 0.3em;
}
</style>
  <!--  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->
    <script src="https://cdn.tiny.cloud/1/udklcg4ghf32p6fo376bvfap162ddwbu1oq6jhb0tgs9qoi0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


  <script type="text/javascript">
  tinymce.init({
  //  selector: '#myeditablediv',
  //  inline: true
	  selector: 'textarea',
	  height: 250,
	  statusbar: false,
	  toolbar: 'undo redo  bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
	  plugins: 'code',
	  menubar: false
  });
  </script>
  <!--
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/adapters/jquery.js"></script>
-->
<script type="text/javascript" >
$(document).ready(function ()
{
	/*
$("#requestorName").autocomplete({
    source: function(request, response) {
        $.ajax({
            url: src,
            dataType: "json",
            data: {
                term : request.term,
                country_id : $("#organizationId").val()
            },
            success: function(data) {
                response(data);
            }
        });
    },
    min_length: 3,
    delay: 300
});
	*/
  $("#requestorId").change(function (){
    var formData = $(":input").serializeArray();
    link = "/ajax/lookups/getRequestorName.php?requestorId="+$("#requestorId").val()+"&organizationId="+$("#organizationId").val();
    $.post(link, formData, function (theResponse) {
      $("#requestorName").val(theResponse);
    });
   });
   $(document).on('click', '#editDepend', function ()
   {
     $('#dependIds').attr("class","showEdit");
     $('#listDependentIds').attr("class","hidden");
   });
   $(document).on('click', '#editBlock', function ()
   {
     $('#blockIds').attr("class","showEdit");
     $('#listBlockIds').attr("class","hidden");
   });
	 $('#hasDuplicateId').change(function (){
		 if($("#hasDuplicateId").is(':checked'))
		 {
			 $('#duplicate').attr("class","showEdit");
		 }
		 else {
		 	 $('#duplicate').attr("class","hidden");
		 }

	 })

   function initQueue()
   {
	 $('#queue').change(function () {
       link = "/ajax/controls/assignee.php";
       var formData = $(":input").serializeArray();
       $.post(link, formData, function (theResponse) {
        $("#assigneeResults").html(theResponse);
	    $("#requestorId").change();
       });

       link = "/ajax/controls/defaultCC.php";
       var formData = $(":input").serializeArray();
       $.post(link, formData, function (theResponse) {
        $("#CCResults").html(theResponse);
	    //$("#requestorId").change();
       });
     });
     $('#queue').change();
   }
   $("#organizationId").change(function() {
      link = "/ajax/controls/setOrgSession.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
       });

      link = "/ajax/controls/queue.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#queueResults").html(theResponse);
	    $("#requestorId").change();
	    initQueue();
       });
   });
   $("#organizationId").change();
});
</script>
<script type="text/javascript">
adminFilePath="";
function toggle()
{
  var dueDate_Month_ID = document.getElementById('dueDate_Month_ID');
  var dueDate_ID = document.getElementById('dueDate_Day_ID');
  var dueDate_Year_ID = document.getElementById('dueDate_Year_ID');
  dueDate_Month_ID.disabled = !dueDate_Month_ID.disabled;
  dueDate_Day_ID.disabled = !dueDate_Day_ID.disabled;
  dueDate_Year_ID.disabled = !dueDate_Year_ID.disabled;

}
function disableDueDate()
{
  var dueDate_Month_ID = document.getElementById('dueDate_Month_ID');
  var dueDate_Day_ID = document.getElementById('dueDate_Day_ID');
  var dueDate_Year_ID = document.getElementById('dueDate_Year_ID');
  dueDate_Month_ID.disabled = true;
  dueDate_Day_ID.disabled = true;
  dueDate_Year_ID.disabled = true;
}
function enableDueDate()
{
  var dueDate_Month_ID = document.getElementById('dueDate_Month_ID');
  var dueDate_Day_ID = document.getElementById('dueDate_Day_ID');
  var dueDate_Year_ID = document.getElementById('dueDate_Year_ID');
  dueDate_Month_ID.disabled = false;
  dueDate_Day_ID.disabled = false;
  dueDate_Year_ID.disabled = false;
}

</script>
    <?php
    if ($ticket->ticketId == 0)
    {
        $ticket->requestorId = $currentUser->userId;
    }
    if (FormErrors())
    {
    	    $ticket->organizationId = GetTextFromSession("ticketOrganizationId",0);
            $ticket->subject = GetTextFromSession("ticketSubject");
            $ticket->ownerId = GetTextFromSession("ticketAssigneeId",0);
            $ticket->queueId = GetTextFromSession("ticketQueueId",0);
            $ticket->requestorId = GetTextFromSession("ticketRequestorId",0);
            $ticket->priorityId = GetTextFromSession("ticketPriorityId",0);
            $ticket->poNumber = GetTextFromSession("ticketPONumber");
            $blocks->data = GetTextFromSession("ticketBlockData");
            $depends->data = GetTextFromSession("ticketDependsData");
            $commentText = GetTextFromSession("ticketComment");
      //      $ccs->data = GetTextFromSession("ticketCCs");
            DisplayFormErrors();
    }
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }

    ?>

	<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/ticket/ticket.php">
		<table>
          <tr>
            <td>
            <?php echo $orgOrDept;?>:
            <?php
            $organization = new Organization($ticket->organizationId);
						$organizationId = $organization->organizationId;
            if (!$permission->hasPermission("Ticket: Edit Organization"))
            {
							if ($organization->organizationId)
							{
								echo $organization->name;
							}
							else
							{
								echo "Unassigned";
							}
                CreateHiddenField("organizationId",$organization->organizationId);
            }
            else
            {
                $organizationId = $organization->organizationId;
								DebugText("organizationId:".$organizationId);
                $param = "(organizationId in (".GetMyOrganizations().") and active=1)";
								if ($ticket->ticketId)
								{
									$param1 = AddEscapedParam("","organizationId",$ticket->ticketId);
									$param = $param." or ".$param1;
								}
                $organization= new Organization();
                $ok = $organization->Get($param);
                ?>
                <select id="organizationId" name="organizationId">
                <?php
                while ($ok)
                {
                    $selected = "";
                    if ($organizationId == $organization->organizationId)
                    {
                        $selected = "selected='selected'";
                    }
                    ?>
        		<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
        		<?php
        		$ok = $organization->Next();
        	}
					DebugText("organizationId after select:".$organizationId);
                ?>
                </select>
                <?php
            }
            ?>

            </td>
            <td>&nbsp;
            </td>
          </tr>


			<tr>
				<td valign="top">
				<div id="queueResults"></div>
				</td>
				<td>


				<?php if ($permission->hasPermission("Ticket: Edit: Requestor"))
				{
					?>
					 Requestor:
					 <select id="requestorId" name="requestorId">
					   <?php
					   DebugText("ticket requestorId:".$ticket->requestorId);
						 DebugText("organizationId:".$organizationId);
					   $user = new User();
					   $query = "SELECT * FROM users u inner join userToOrganization utg on utg.userId=u.userId where (utg.organizationId=".$organizationId." and u.active=1)";
						 $userSet = new Set();
						 $userSet->separator=",";
						 $userSet->Add($ticket->requestorId);
					   $ok = $user->doQuery($query);
						 while ($ok)
						 {
							 $userSet->Add($user->userId);
							 $ok = $user->Next();
						 }
						 $query = "Select * from users where userId in (".$userSet->data.")";
             $organization = new Organization($organizationId);
             DebugText("showAllUsers:".$ogranization->showAllUsers);
						 if ($organization->showAllUsers)
						 {
							 $query = "Select * from users where active=1";
						 }
						 $ok = $user->doQuery($query);
					   while ($ok)
					   {
					       $selected = "";
					       if ($user->userId == $ticket->requestorId)
					       {
					           $selected = "selected='selected'";
					       }
					       ?>
					       <option value="<?php echo $user->userId;?>"<?php  echo $selected;?>><?php echo $user->fullName;?></option>
					       <?php
					       $ok = $user->Next();
					   }


					   ?>
					 </select>
					 <?php
					 //CreateTextField("requestorName","",0,"Requestor","autoc");
					 //CreateHiddenField("requestorId",$ticket->requestorId);
				}
				else
				{
					$user = new User($ticket->requestorId);
					CreateHiddenField("requestorId",$ticket->requestorId);
					if ($permission->hasPermission("Ticket: View: Requestor"))
					{
						echo "Requestor: ".$user->fullName;
					}
				}
				?>
				</td>
			</tr>
			<tr>
			  <td>
				<?php if ($permission->hasPermission("Ticket: Edit: Priority"))
				{
					?>
					Priority:
			  <select name="priority" >
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
					CreateHiddenField("priority",$ticket->priorityId);
					if ($permission->hasPermission("Ticket: View: Priority"))
					{
						echo "Priority: ".$priority->name;
					}
				}
				?>
			  </td>
			  <td>
				<?php if ($permission->hasPermission("Ticket: Edit: Status"))
				{
					?>
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
            <?php
				}
				else
				{
					$status = new Status($ticket->statusId);
					if ($permission->hasPermission("Ticket: View: Status"))
					{
						echo "Status: ".$status->name;
					}
					CreateHiddenField("status",$ticket->statusId);
				}
				?>
			  </td>
			</tr>

			<tr>
			  <td valign="top">
			  <div id="assigneeResults"></div>
			  </td>
			  <td valign="top">
<div id="CCResults"></div>			  </td>
			</tr>
		<?php
    if ($ticket->statusId == 4)
		{
		 ?>
		<tr>
			<td>
				Date Completed : <?php echo $ticket->dateCompleted;?>
			<td>
			<td>
			 &nbsp;
		 </td>
		</tr>
	 <?php
   } ?>
   <?php
    if ($permission->hasPermission("Ticket: Schedule"))
		{
	  ?>
		<tr>
		  <td>
		    Date Due: <?php
		                     if ($permission->hasPermission("Ticket: Edit: Due Date"))
		                     {
													 $on = 0;
													 DebugText("dueDate:".$ticket->dueDate);
													 if (strlen($ticket->dueDate))
													 {
															 $on = 1;
													 }
													 if ($ticket->statusId != 4)
													 {
														 CreateCheckBox("useDueDate",1,"Enable Due Date",$on,"Click to enable the due date","","onclick='toggle()'");
														 PrintBR();
														 CreateDateField("dueDate",$ticket->dueDate);
													 }
													 else {
														 echo $ticket->dueDate;
													 	CreateHiddenField("useDueDate",0);
														CreateHiddenField("dueDate",$ticket->dueDate);
													 }

		                     }
		                     else
		                     {
		                         echo $ticket->dueDate;
		                         CreateHiddenField("dueDate",$ticket->dueDate);
												 }
		                    ?>
		  </td>
		  <td>
				<?php

         if ($permission->hasPermission("Ticket: Edit: Time Worked "))
				 {

				 ?>
		    Time worked: <?php echo $ticket->timeWorked." hours";
				 CreateHiddenField("timeWorked",$ticket->timeWorked);?>
				<?php
		     }
				 else {
				 	if ($permission->hasPermission("Ticket: View: Time Worked "))
					{
						echo "Time worked: ".$ticket->timeWorked;
					}
					CreateHiddenField("timeWorked",$ticket->timeWorked);
				 } ?>

		  </td>
		  <td>&nbsp;</td>
		</tr>
		<?php
  	}
	 ?>
		</table>
		<table>
			  <?php
				DebugText("before permission test for duplicate");
				if ($permission->hasPermission("Ticket: Edit: Duplicate"))
				{
					$duplicateStyle = "hidden";
					if ($ticket->duplicateId)
					{
						$duplicateStyle = "showEdit";
					}
					?>
					<tr>
					  <td valign="top">
						<?php
						CreateCheckBox("hasDuplicateId",1,"Duplicate",$ticket->duplicateId);
						?>
						</td>
						<td>
							<div id="duplicate" class="<?php echo $duplicateStyle;?>">
								<?php
								CreateTextField("duplicateId",$ticket->duplicateId);
								?>
							</div>
					  </td>
					</tr>
				<?php
				}
				?>
				<?php
				DebugText("before permission test blocks->data:".$blocks->data);

				if ($permission->hasPermission("Ticket: Edit: Dependencies"))
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

		Depends :</td><td><div id="blockIds" class="<?php echo $blocksStyle;?>">
		 <?php
		 CreateTextField("blocks",$blocks->data);
		 if ($ticket->ticketId)
		 {
			PrintNBSP();
			CreateLink("/process/ticket/createBlock.php?ticketId=".$ticket->ticketId,"Create Dependent Ticket","","Create a ticket that this ticket is blocked upon","showEdit");
		}?>
		<br/></div>
		<?php
		if (strlen($blocks->data))
		{
			?>
			<div id="listBlockIds">
			<?php
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
				CreateLink("/ticketEdit/$blockTicket->ticketId/",$blockTicket->ticketId,"ticket".$blockTicket->ticketId,"Edit Ticket",$ticketClass);
				PrintNBSP();
			}
			?>
			(
			<?php CreateLink("#","edit","editBlock","Edit Dependent Tickets","showEdit");?>
			)
			</div>
			<?php

		}


		?></td>

		</tr>
		<tr>
		<td valign="top">
		Blocks :</td><td><div id="dependIds" class="<?php echo $dependsStyle;?>">
		 <?php
		 CreateTextField("depends",$depends->data);
		 if ($ticket->ticketId)
		 {
			PrintNBSP();
			CreateLink("/process/ticket/createDependent.php?ticketId=".$ticket->ticketId,"Create Blocking Ticket","","Create a ticket that this ticket is dependent upon","showEdit");
		}?>
		<br/></div>
		<?php
		if (strlen($depends->data))
		{
			?>
			<div id="listDependentIds">
			<?php
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
				CreateLink("/ticketEdit/$dependTicket->ticketId/",$dependTicket->ticketId,"ticket".$dependTicket->ticketId,"Edit Ticket",$ticketClass);
				PrintNBSP();
			}
			?>
			(
			<?php CreateLink("#","edit","editDepend","Edit Block Tickets","showEdit");?>
			)
			</div>
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
				<?php if ($permission->hasPermission("Ticket: Edit: Subject") || $permission->hasPermission("Ticket: Create: User Ticket"))
				{
					$fieldSize = getFieldSize("ticket","subject");
					CreateTextField("subject",$ticket->subject,$fieldSize);
				}
				else
				{
					echo $ticket->subject;
					CreateHiddenField("subject",$ticket->subject);
				}
				?>
				<?php if ($permission->hasPermission("Ticket: Edit: Add Comment") || $permission->hasPermission("Ticket: Create: User Ticket"))
				{
					?>

			    <textarea id="description" name="description" rows="10"  wrap="off"><?php echo $commentText;?></textarea>
			    <?php
				}
				else
				{
					echo "<Br>";
				}
				PrintFormKey();
				CreateHiddenField("submitTest",1);
				CreateHiddenField("ticketId",$ticket->ticketId);
				CreateHiddenField("createTicketForAsset",$createTicketForAsset);
				if ($permission->hasPermission("Ticket: Edit") || $permission->hasPermission("Ticket: Edit: Add Comment")  || $permission->hasPermission("Ticket: Create: User Ticket"))
				{
					$button = "Create";
					if ($ticket->ticketId)
					{
						$button = "Update";
					}
					CreateSubmit("Submit",$button);
				}
				?>
				</td>

	</form>


	<?php
	$comment = new Comment();
	$param = "ticketId=".$ticket->ticketId;
	$ok = $comment->Get($param);

	if ($ok && ($permission->hasPermission("Ticket: Edit: View Comments") || $permission->hasPermission("Ticket: View: View Comments")))
	{
		?><hr>
	<table class="width100">
	<?php
	while ($ok && $ticket->ticketId)
	{
		$user = new User($comment->userId);
		$class = "";
		$timeWorked = new TimeWorked();
		$param = AddEscapedParam("","commentId",$comment->commentId);
		if ($timeWorked->Get($param))
		{
			$class = "class='timeWorked'";
		}

		if (!$timeWorked->timeWorkedId || ($timeWorked->timeWorkedId && $permission->hasPermission("Ticket: View TimeWorked Comments")))
		{
			?>
		<tr <?php echo $class;?> >
		  <td><?php echo $user->fullName." on ".$comment->posted;?>
		  </td>
		</tr>
		<tr <?php echo $class;?> >
		  <td>
		  <?php echo $comment->comment;?>
		  <!--<hr>-->
		  </td>
		</tr>
		<tr>
			<td><hr></td>
		</tr>
		<?php
	  }
		$ok = $comment->Next();
	}
	?>
	</table>
	<?php
	}
	?>

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
	<!--
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

 // alert('config editor');
	$('#description').ckeditor(config);
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

-->
