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
$key = CreateLinkKey("deleteUserGroup");
$htmlAction=' <div class="roptions">';
if ($permission->hasPermission("Config: User: Edit"))
{
	$htmlAction=$htmlAction.'<a href="/editUserGroup/'.$userGroup->userGroupId. '/" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="Edit User Group"';
	}
	$htmlAction=$htmlAction.' class="edit_userGroup"><img src="/images/icon_edit.png" alt="Edit"/></a>';
}
/*
if ($permission->hasPermission("Config: User Group: View"))
{
	$htmlAction=$htmlAction.'<a href="/viewUserGroup/'.$userGroup->userGroupId. '/" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="View User Group"';
	}
	$htmlAction=$htmlAction.' class="view_user"><img src="/images/view.png" alt="View"/></a>';
}
*/
if ($permission->hasPermission("Config: User Group: Permissions"))
{
	$htmlAction=$htmlAction.'<a class="edit_userGroupPermissions" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="User GroupPermissions"';
	}
	$htmlAction=$htmlAction.' href="/editUserGroupPermission/'.$userGroup->userGroupId. '/"><img alt="Permissions" src="/images/icons/list_security.gif"></a>';
}
if ($permission->hasPermission("Config: User Group: Delete"))
{
	$htmlAction = $htmlAction.'<a href="/deleteUserGroup/'.$userGroup->userGroupId.'/'.$key. '/"  class="delete_userGroup"';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.' title="Delete User Group"';
	}
	$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"/></a>';
}
$htmlAction=$htmlAction.'</div>';
