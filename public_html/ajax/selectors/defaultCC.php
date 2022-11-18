<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php 
include "globals.php";
include_once "tracker/set.php";
include_once "tracker/defaultUser.php";
$defaultUser = new DefaultUser();
$queueId=0;
if (isset($_POST['queue']))
{
	$queueId = $_POST['queue'];
}
$param = "userType='cc'";
$param = AddEscapedParam($param,"queueId",$queueId);
$ok = $defaultUser->Get($param);
$cc = new Set(",");
while ($ok)
{
	$cc->Add($defaultUser->userId);
	$ok = $defaultUser->Next();
}
echo $cc->data;
?>