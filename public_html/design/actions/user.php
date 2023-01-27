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
$htmlAction=' <div class="roptions">';
if ($permission->hasPermission("Config: User: Edit"))
{
	$htmlAction=$htmlAction.'<a href="/editUser/'.$user->userId. '/" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="Edit User"';
	}
	$htmlAction=$htmlAction.' class="edit_user"><img src="/images/icon_edit.png" alt="Edit"/></a>';
}
/*
if ($permission->hasPermission("Config: User: View"))
{
	$htmlAction=$htmlAction.'<a href="/viewUser/'.$user->userId. '/" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="View User"';
	}
	$htmlAction=$htmlAction.' class="view_user"><img src="/images/view.png" alt="View"/></a>';
}
*/
if ($permission->hasPermission("Config: User: Permissions"))
{
	$htmlAction=$htmlAction.'<a class="edit_userPermissions" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="User Permissions"';
	}
	$htmlAction=$htmlAction.' href="/editUserPermission/'.$user->userId. '/"><img alt="Permissions" src="/images/icons/list_security.gif"></a>';
}
if ($permission->hasPermission("Config: User: Delete"))
{
	$htmlAction = $htmlAction.'<a href="/deleteUser/'.$user->userId. '/"  class="delete_user"';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.' title="Delete User"';
	}
	$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"/></a>';
}
$htmlAction=$htmlAction.'</div>';
