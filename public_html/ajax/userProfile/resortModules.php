<?php
/*
 * Created on Jan 4, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
$control = new Control();
$param = "sectionValue='userId$currentUser->userId' and keyValue like 'myMod%'";
$query = "delete from control where ".$param;
$control->doQuery($query);
$control->section= "userId".$currentUser->userId;
$updateRecordsArray 	= $_POST['module'];
$cnt = 1;
foreach ($updateRecordsArray as $recordIDValue) 
{
	$key = "myMod".$cnt++;
	$control->key = $key;
	$control->valueInt = $recordIDValue;
	$control->datatype = "integer";
	$control->Insert();
}
//DebugOutput();
?>