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
