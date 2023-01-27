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
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/defaultUser.php";
$ticketId = GetTextField("ticketId",0);
$organizationId = GetTextField("organizationId",0);
$ticket = new Ticket($ticketId);
$queueId = GetTextField("queue",0);
$requestorId = GetTextField("requestorId",0);
if (!$ticket->ticketId)
{
	$defaultUser = new DefaultUser();
    $param = "userType='assignee'";
    $param = AddEscapedParam($param,"queueId",$queueId);
    $defaultUser->Get($param);
    $ticket->ownerId = $defaultUser->userId;
}

if ($permission->hasPermission("Ticket: Edit: Assignee"))
{
	if (!GetTextField("hideLabel",0))
	{
?>
Assignee:
<?php
	}
	?>
<select name="assignee" id="assignee">
  <option value="0">Select Assignee</option>
  <?php
  $groups = new Set(",");
  $userGroup = new UserGroup();
  $ok = $userGroup->Get("assignee=1");
  while ($ok)
  {
      $groups->Add($userGroup->userGroupId);
      DebugText("assignee Group:".$userGroup->userGroupId);
      $ok = $userGroup->Next();
  }
  if (strlen($groups->data) == 0)
  {
      $groups->Add("0");
  }
  $user = new User();
  $user->setOrderBy("fullName");
  $query = "select * from users u inner join userToGroup utg on u.userId=utg.userId inner join userToOrganization uto on u.userId=uto.userId where (u.active=1 and utg.userGroupId in ($groups->data) and uto.organizationId=".$organizationId.") or (u.userId=".$requestorId." and utg.userGroupId in ($groups->data) and uto.organizationId=".$organizationId.")";
  //$ok = $user->GetAssignees("uto.organizationId=".$organizationId);
  $ok = $user->doQuery($query);
  while ($ok)
  {
  	$select = "";
    if ($user->userId == $ticket->ownerId)
    {
    	$select = "selected='selected'";
    }
    ?>
    <option value="<?php echo $user->userId;?>" <?php echo $select;?>><?php echo $user->fullName;?></option>
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
	if ($permission->hasPermission("Ticket: View: Assignee"))
	{
		echo "Assignee: ".$user->fullName;
	}
	CreateHiddenField("assignee",$ticket->ownerId);
}
?>
