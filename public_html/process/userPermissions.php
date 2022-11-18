<?php
include_once "globals.php";
include_once "tracker/permission.php";
include_once "tracker/userToPermission.php";

$userId = 0;
if (isset($_POST['userId']))
{
	$userId = strip_tags($_POST['userId']);
}
if (isset($_POST['submitTest']))
{
	$userId = strip_tags($_POST['userId']);
	$userToPermission = new UserToPermission();
	$userToPermission->userId = $userId;
	$userToPermission->Reset();
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
    		$userToPermission->userId = $userId;
    		$userToPermission->permissionId = $permission->permissionId;
    		$userToPermission->Insert();
    	}

    	$ok = $permission->Next();
    }
    $status = 'success';
    DebugPause("/listUsers/");
}
?>