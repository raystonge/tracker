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
