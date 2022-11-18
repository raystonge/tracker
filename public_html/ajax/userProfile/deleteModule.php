<?php
/*
 * Created on Jan 5, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/module.php";
$moduleId = 0;
$status='fail';
if (isset($_GET['moduleId']))
{
	$moduleId = $_GET['moduleId'];
	$moduleId = str_replace("itemId_","",$moduleId);
	$moduleId = str_replace("moduleId_","",$moduleId);
}
$module = new Module($moduleId);
if ($module->moduleId)
{
	$control = new Control();
	$param = "sectionValue='userId".$currentUser->userId."' and keyValue like 'myMod%' and valueInt=".$moduleId;
	if ($control->Get($param))
	{
		$control->Delete();
		$status = 'success';
	}
}
echo '{"status":"'.$status.'"}';
	//DebugOutput();
?>