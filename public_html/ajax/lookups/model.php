<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
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
