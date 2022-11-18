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
$make = GetURLVar("make");
$model= GetURLVar("model");
if (!strlen($make))
{
	exit;
}
if (!strlen($model))
{
	exit;
}
$param = AddEscapedParam("","make",$make);
$param = AddEscapedLikeParam($param,"model",$model);
$query = "select distinct model from asset where ".$param;
$rows = doQuery($query);
$makes = array();
foreach ($rows as $make)
{
	echo $make['model']."\n";
	//$makes[] = array('label' => $make['model'],'value'=>$make['model']);
}
//echo json_encode($makes);
//DebugOutput();
?>