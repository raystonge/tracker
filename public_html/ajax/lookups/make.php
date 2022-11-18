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
$term = GetURLVar("make");
if (!strlen($term))
{
	exit;
}
$param = AddEscapedLikeParam("","make",$term);
if (isset($_GET['assetTypeId']))
{
	$assetTypeId = $_GET['assetTypeId'];
	if ($assetTypeId=="undefined")
	{
	    $assetTypeId = 0;
	}
	if ($assetTypeId)
	{
		$param = AddEscapedParam($param,"assetTypeId",$assetTypeId);
	}
}
if (isset($_GET['organizationId']))
{
    $organizationId = $_GET['organizationId'];
    if ($organizationId == "undefined")
    {
        $organizationId = 0;
    }
    if ($organizationId)
    {
        $param = AddEscapedParam($param,"organizationId",$organizationId);
    }
}
$query = "select distinct make from asset where ".$param;
$rows = doQuery($query);
$makes = array();
foreach ($rows as $make)
{
	echo $make['make']."\n";
	//$makes[] = array('label' => $make['make'],'value'=>$make['make']);
}
//echo json_encode($makes);
?>