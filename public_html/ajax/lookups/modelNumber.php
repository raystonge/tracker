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
$modelNumber = GetURLVar("modelNumber");
if (!strlen($make))
{
	exit;
}

if (!strlen($model))
{
	exit;
}
if (!strlen($modelNumber))
{
	exit;
}

$param = AddEscapedParam("","make",$make);
$param = AddEscapedParam($param,"model",$modelNumber);
$param = AddEscapedLikeParam($param,"modelNumber",$modelNumber);
$query = "select distinct modelNumber from asset where ".$param;
$rows = doQuery($query);
$modelNumbers = array();
foreach ($rows as $modelNumber)
{
	echo $make['modelNumber']."\n";
	//$makes[] = array('label' => $make['model'],'value'=>$make['model']);
}
//echo json_encode($makes);
//DebugOutput();
?>