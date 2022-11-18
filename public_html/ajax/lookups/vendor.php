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
$param = AddEscapedLikeParam("","vendor",$term);
$query = "select distinct vendor from asset where ".$param;
$rows = doQuery($query);
$vendors = array();
foreach ($rows as $vendor)
{
	$vendors[] = array('label' => $vendor['vendor'],'value'=>$vendor['vendor']);
}
echo json_encode($vendors);
?>