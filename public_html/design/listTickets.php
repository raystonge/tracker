<?php
include_once "tracker/ticket.php";
include_once "tracker/queue.php";
include_once "tracker/priority.php";
include_once "tracker/user.php";
include_once "tracker/status.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Ticket: List");
$ticket = new Ticket();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

?>

<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Tickets</a></h2>
	<?php
	if ($permission->hasPermission("Ticket: Create"))
  {
	?>
	<!--
	<div class="options">
		<a id="newTicket" href="/ticketNew/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Ticket"';}?>>New Ticket</a>
	</div>
	-->
	<?php
  }
  $searchOrganizationId = GetTextFromSession("searchTicketOrganizationId",0,0);

	$searchPriorityId = GetTextFromSession("searchTicketPriorityId",0,0);
	$searchOwnerId = GetTextFromSession("searchTicketOwnerId",$currentUser->userId,0);

	$searchStatusId = GetTextFromSession("searchTicketStatusId",-1,0);
	$searchTicketID = GetTextFromSession("searchTicketTicketId","",0);


$page = 1;
DebugText("Compute page we are on");
if (isset($request_uri[1]))
{
	DebugText("first:".$request_uri[1]);
  if (strlen($request_uri[1]))
  {
  	if (is_numeric($request_uri[1]))
    {
    	$page = $request_uri[1];
    	DebugText("uri1:".$request_uri[1]);
    }
  }
}

if (isset($request_uri[2]))
{
  if (strlen($request_uri[2]))
  {
  	$page = $request_uri[2];
  	DebugText("uri2:".$request_uri[2]);
  }
}
if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}

	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
		<table>
		    <tr>
		      <td>
		      <?php echo $orgOrDept;?>:
		      </td>
		      <td>
		        <?php CreateHiddenField("hideLabel",1);?>
		        <select id="organizationId" name="organizationId">
		          <option value="0">All <?php echo $orgOrDept;?></option>
		          <?php
		          $param = "organizationId in (".GetMyOrganizations().") and active=1";
		          $organization= new Organization();
		          $ok = $organization->Get($param);
							DebugText("organization numRows:".$organization->numRows);
							DebugText("searchOrganizationId:".$searchOrganizationId);
		          while ($ok)
		          {
		          	$selected = "";
		          	if ($searchOrganizationId == $organization->organizationId || $organization->numRows == 1)
		          	{
									DebugText("set organization");
		          		$selected = "selected='selected'";
		          	}
		          	?>
		          	<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
		          	<?php
		          	$ok = $organization->Next();
		          }
		          ?>
		        </select>
		      </td>
		      <td>
		      Ticket Id:
		      </td>
		      <td>
		      <?php CreateTextField("searchTicketId",$searchTicketID);?>
		      </td>
		    </tr>
			<tr>
				<td valign="top">Queue:
				</td>
				<td>
				<div id="queueResults"></div>
				</td>
				<td>
				Priority:
				</td>
				<td>
				  <select name="searchPriorityId" id="searchPriorityId">
				   <option value="0">All</option>
				<?php
				$priority = new Priority();
				$ok = $priority->Get("");
				while ($ok)
				{
					$selected = "";
					if ($priority->priorityId == $searchPriorityId)
					{
						$selected = "selected='selected'";
					}
					?>
					<option value="<?php echo $priority->priorityId;?>" <?php echo $selected;?>><?php echo $priority->name;?></option>
					<?php
					$ok = $priority->Next();
				}
				?>
				</select>
				</td>
			</tr>
			<tr>
			  <td>Requestor:
			  </td>
			  <td>
			    <div id="requestorResults"></div>
			  </td>
			  <td>Owner:
			  </td>
			  <td>
			  <?php CreateHiddenField("hideLabel",1);?>
			  <div id="assigneeResults"></div>
			  </td>
			</tr>

			<tr>
			  <td>
Status:
			  </td>
			  <td>
			    <select name="searchStatusId" id="searchStatusId">
			      <option value="0">All</option>
			      <?php
			      $selected = "";
			      if ($searchStatusId == -1)
			      {
			      	$selected = "selected='selected'";
			      }
			      ?>
			      <option value="-1" <?php echo $selected;?>>Not Closed</option>
			      <?php
			      $status = new Status();
			      $param = "";
			      $ok = $status->Get($param);
			      while($ok)
			      {
			      	$selected="";
			      	if ($status->statusId == $searchStatusId)
			      	{
			      		$selected = "selected='selected'";
			      	}
			      	?>
			      	<option value="<?php echo $status->statusId;?>" <?php echo $selected;?>><?php echo $status->name;?></option>
			      	<?php
			      	$ok = $status->Next();
			      }
			      ?>
			    </select>
			  </td>
			  <td>&nbsp;
			  </td>
			  <td>&nbsp;
			  </td>
			</tr>
			<tr>
				<td>
					Completed After
				</td>
				<td>
					<?php
					$afterDate = date('Y-m-d', strtotime($today.' - 29 days'));
					CreateDateField("afterDate",$afterDate);
					 ?>
				</td>
				<td>
					Completed Before
				</td>
				<td>
					<?php
					$beforeDate = "";
					CreateDateField("beforeDate",$beforeDate);
					 ?>
				</td>
			</tr>

			<tr>
			  <td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">

				</td>
				<td><input id="search" type="button" name="Submit" value="Submit" />
				&nbsp;
				&nbsp;
				<?php CreateResetButton();?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
