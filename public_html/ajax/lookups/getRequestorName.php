<?php
/*
 * Created on May 15, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/user.php";
$organizationId = GetTextField("organization",0);
$userId= GetTextField("requestorId",0);
if (isset($_GET['requestorId']))
{
	$userId = $_GET['requestorId'];
}
$user = new User($userId);
echo $user->fullName;
?>