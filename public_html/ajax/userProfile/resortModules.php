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
