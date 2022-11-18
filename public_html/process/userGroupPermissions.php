<?php
include_once "globals.php";
include_once "tracker/permission.php";
include_once "tracker/userGroupToPermission.php";
include_once "tracker/userGroup.php";
$userGroupId = 0;
if (isset($_POST['userGroupId']))
{
	$userGroupId = strip_tags($_POST['userGroupId']);
}
if (isset($_POST['submitTest']))
{
	$userGroup = new UserGroup($userGroupId);
	$userGroupId = strip_tags($_POST['userGroupId']);
	$userGroupToPermission = new UserGroupToPermission();
	$userGroupToPermission->userGroupId = $userGroupId;
	$userGroupToPermission->organizationId = $userGroup->organizationId;
	$userGroupToPermission->Reset();
    $permission = new Permission();
    $param = "developer = 0";
    if ($permission->hasPermission("Developer"))
    {
    	$param = "";
    }
    $ok = $permission->Get($param);
    while ($ok)
    {
    	$field = "permission".$permission->permissionId;
    	if (isset($_POST[$field]))
    	{
    		$userGroupToPermission->userGroupId = $userGroupId;
    		$userGroupToPermission->permissionId = $permission->permissionId;
    		$userGroupToPermission->Insert();
    	}

    	$ok = $permission->Next();
    }
    $status = 'success';
    DebugPause("/listUserGroups/");
}
?>