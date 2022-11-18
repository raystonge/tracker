<?php
include_once 'globals.php';
include_once "tracker/asset.php";
$asset = new Asset();
$query = "update asset set startingBuildingIdPP=buildingId";
$asset->execQuery($query);
DebugPause("/");
 ?>
