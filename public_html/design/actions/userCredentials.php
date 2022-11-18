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

	$htmlAction=$htmlAction.'<a href="/editUserCredentials/'.$assetCredentials->assetCredentialsId."/".$assetCredentials->assetCredentialsId. '/" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="Edit User Credentials"';
	}
	$htmlAction=$htmlAction.' class="edit_assetCredentials"><img src="/images/icon_edit.png" alt="Edit"/></a>';
/*
if ($permission->hasPermission("Config: User Group: View"))
{
	$htmlAction=$htmlAction.'<a href="/viewAssetCredentials/'.$assetCredentials->assetCredentialsId. '/" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="View User Group"';
	}
	$htmlAction=$htmlAction.' class="view_user"><img src="/images/view.png" alt="View"/></a>';
}
*/
/*
	$htmlAction=$htmlAction.'<a class="edit_assetCredentialsPermissions" ';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.'title="User GroupPermissions"';
	}
	$htmlAction=$htmlAction.' href="/editAssetCredentialsPermission/'.$assetCredentials->assetCredentialsId. '/"><img alt="Permissions" src="/images/icons/list_security.gif"></a>';
*/
	$htmlAction = $htmlAction.'<a href="/deleteAssetCredentials/'.$assetCredentials->assetCredentialsId. '/"  class="delete_assetCredentials"';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.' title="Delete User Group"';
	}
	$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"/></a>';
$htmlAction=$htmlAction.'</div>';
