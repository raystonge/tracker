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
include_once 'tracker/user.php';
include_once "tracker/control.php";
include_once "tracker/userToGroup.php";
include_once "tracker/userGroup.php";
include_once "tracker/organization.php";
include_once "tracker/userToOrganization.php";
include_once "tracker/permission.php";
$control = new Control();
$permission = new Permission();
$userToGroup = new UserToGroup();

$editingUser = 0;
$editCurrentUser=0;
$userId = 0;
$cnt = 0;
$numErrors = 0;
$errorMsg = "";
$ogranization = new Organization();
$userGroupList = new Set(",");
$userOrganizationList = new Set(",");
$userGroups = new UserToGroup();
$userToOrganization = new UserToOrganization();
$param = "userId=".$user->userId;
DebugText("Get the groups for the user");
$ok = $userGroups->Get($param);
while ($ok)
{
	$userGroupList->Add($userGroups->userGroupId);
	$ok = $userGroups->Next();
}
DebugText("Get the organizations for the user");
$ok = $userToOrganization->Get($param);
while ($ok)
{
	$userOrganizationList->Add($userToOrganization->organizationId);
	$ok = $userToOrganization->Next();
}

?>
<div class="adminArea">
    <h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listUsers/">Users</a></h2>
    <?php
    if (FormErrors())
    {
    	$user->fullName = GetTextFromSession("userFullName");
    	$user->email = GetTextFromSession("userEmail");
    	$user->active = GetTextFromSession("userActive");
    	$userGroupList->data = GetTextFromSession("userUserGroups");
    	DisplayFormErrors();
    }
    ?>

<form  method="post" name="form1" id="form1"  autocomplete="<?php echo $autoComplete;?>" action="/process/user.php">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25%">Name: </td>
    <td><?php CreateTextField("fullName",$user->fullName,getFieldSize("users","fullName"),"Enter User&apos;s Full Name",$editFieldClass);?></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><?php CreatePasswordField("password","",getFieldSize("users","password"),"Enter Password",$editFieldClass);?></td>
  </tr>
  <tr>
    <td>Confirm Password:</td>
    <td><?php CreatePasswordField("confirmPassword","",getFieldSize("users","password"),"Confirm Password",$editFieldClass);?></td>
  </tr>

  <tr>
    <td>Email:</td>
    <td> <?php CreateTextField("email",$user->email,getFieldSize("users","email"),"Enter Email address. Also used to login",$editFieldClass);?></td>
  </tr>
  <tr>
    <td>SNS Topic:</td>
    <td> <?php CreateTextField("snsTopic",$user->snsTopic,getFieldSize("users","snsTopic"),"Enter SNS Topic. Used to send text notifications",$editFieldClass);?></td>
  </tr>

  <tr>
    <td class="alignTop">
	  <?php echo $orgOrDept;?>:	</td>
	<?php

	$isAdmin = 1;
	if ($isAdmin)
	{
	DebugText("user is admin");
	?>
	<td><select name="userOrganizations[]" size="5" multiple="multiple"  <?php if ($showMouseOvers){echo 'title="Select Organizations for the User"';}?>>
	  <?php
	    $organization = new Organization();
		$ok = $organization->Get("");
		while ($ok)
		{
		  $param = "userId=$user->userId and organizationId=$organization->organizationId";
		  $inGroup = $userOrganizationList->InSet($organization->organizationId);
		  //$inGroup = $userToGroup->Get($param);
		?>
		  <option value="<?php echo $organization->organizationId;?>" <?php if ($inGroup) {?>selected="selected" <?php }?>><?php echo $organization->name;?></option>
		<?php
		  $ok = $organization->Next();
		}
	  ?>
	</select>
	</td>
	<?php
	}
	else
	{
	?>
	<td valign="top">
	user's organizations	</td>
	<?php
	}
	?>
  </tr>
  <tr>
    <td>Groups:
    </td>
  <?php
	if ($isAdmin)
	{
	DebugText("user is admin");
	?>
	<td><select name="userGroups[]" size="5" multiple="multiple"  <?php if ($showMouseOvers){echo 'title="Select Groups for the User"';}?>>
	  <?php
	    $userGroups = new UserGroup();
		$ok = $userGroups->Get("");
		while ($ok)
		{
		  $param = "userId=$user->userId and userGroupId=$userGroups->userGroupId";
		  $inGroup = $userGroupList->InSet($userGroups->userGroupId);
		  //$inGroup = $userToGroup->Get($param);
		?>
		  <option value="<?php echo $userGroups->userGroupId;?>" <?php if ($inGroup) {?>selected="selected" <?php }?>><?php echo $userGroups->name;?></option>
		<?php
		  $ok = $userGroups->Next();
		}
	  ?>
	</select>
	</td>
	<?php
	}
	else
	{
	?>
	<td valign="top">
	user's group	</td>
	<?php
	}
	?>
  </tr>

  <?php
  if ($isAdmin)
  {
  ?>
  <tr>
  <td>Active:
  </td>
  <td><select name="active"  <?php if ($showMouseOvers){echo 'title="Is User Active?"';}?>>
    <option value="1" <?php if ($user->active) echo "selected='selected'";?>>Active</option>
    <option value="0" <?php if (!$user->active) echo "selected='selected'";?>>InActive</option>
  </select>
  </td>
  </tr>
  <?php
  }
  ?>

  <tr>
    <td>
    <?php
    CreateHiddenField("userId",$user->userId);
    CreateHiddenField("editCurrentUser",$editCurrentUser);
    PrintAJAXFormKey();
    CreateHiddenField("submitTest","1");
	if (!$isAdmin)
	{
		CreateHiddenField("accessLevel",$user->accessLevel);
	}
	?>
	</td>
    <td><?php CreateSubmit("Submit","Submit");?></td>
  </tr>
</table>
</form>
</div>
