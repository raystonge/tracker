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
include_once "tracker/defaultUser.php";
$defaultUser = new DefaultUser();
$queueId=GetTextField("queue",0);
$organizationId = GetTextField("organization",0);
$param = "userType='assignee'";
$param = AddEscapedParam($param,"queueId",$queueId);
//$param = AddEscapedParam($param,"organizationId",$organizationId);
$defaultUser->Get($param);
echo $defaultUser->userId;
DebugOutput();
?>