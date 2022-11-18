<?php
/*
 * Created on Aug 1, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/userGroup.php";
include_once "tracker/userToGroup.php";
include_once "tracker/userGroupToPermission.php";
$userGroupId = 0;
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$userGroupId = $request_uri[2];
		DebugText("using param 2:".$userGroupId);
	}
}
$userGroup = new UserGroup($userGroupId);
$userToGroup = new UserToGroup();
$userGroupToPermission = new UserGroupToPermission();
$param = "userGroupId=".$userGroup->userGroupId;
$userToGroup->Delete($param);
$userGroupToPermission->Delete($param);
$userGroup->Delete();

echo $userGroup->name." has been deleted"

?>