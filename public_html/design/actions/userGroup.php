<?php
/*
 * Created on Dec 7, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
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
	$htmlAction = $htmlAction.'<a href="/deleteUserGroup/'.$userGroup->userGroupId. '/"  class="delete_userGroup"';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.' title="Delete User Group"';
	}
	$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"/></a>';
}
$htmlAction=$htmlAction.'</div>';
