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
$key = CreateLinkKey("deleteAssetCredentials");
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
	$htmlAction = $htmlAction.'<a href="/deleteAssetCredentials/'.$assetCredentials->assetCredentialsId.'/'.$key. '/"  class="delete_assetCredentials"';
	if ($showMouseOvers)
	{
		$htmlAction=$htmlAction.' title="Delete User Group"';
	}
	$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"/></a>';
$htmlAction=$htmlAction.'</div>';
