<?php
/*
 * Created on Nov 30, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "db/dbTools.php";
include_once "tracker/asset.php";
$term = GetURLVar("term");
if (!strlen($term))
{
	exit;
}
$param = AddEscapedLikeParam("","buildingLocation",$term);
$query = "select distinct buildingLocation from asset where ".$param;
$rows = doQuery($query);
$buildingLocations = array();
foreach ($rows as $buildingLocation)
{
	$buildingLocations[] = array('label' => $buildingLocation['buildingLocation'],'value'=>$buildingLocation['buildingLocation']);
}
echo json_encode($buildingLocations);
?>