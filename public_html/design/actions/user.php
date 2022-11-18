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