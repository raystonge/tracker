<?php
/*
 * Created on Apr 8, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/monitor.php";
include_once "tracker/asset.php";
include_once "tracker/permission.php";
$state = 0;
$buildingId = 0;
$assetTypeId = 0;
$query = "select m.* from monitor m inner join asset a on m.assetId=a.assetId";
$param = "active=1";
if ($buildingId)
{
	$param = AddEscapedParam($param,"a.buildingId",$buildingId);
}
if ($state >=0)
{
	$param = AddEscapedParam($param,"m.state",$state);
}
if ($assetTypeId)
{
	$param = AddEscapedParam($param,"a.assetTypeId",$assetTypeId);
}
if (strlen($param))
{
	$query = $query." where ".$param;
}
$monitor = new Monitor();
$ok = $monitor->doSelectQuery($query);
if ($ok && $permission->hasPermission("Monitor"))
{
	$pageTitle = $pageTitle." ($monitor->numRows) Devices Down";
}
$status = "success";
echo '{"status":"'.$status.'","pageTitle":"'.$pageTitle.'"}';
exit;
?>
