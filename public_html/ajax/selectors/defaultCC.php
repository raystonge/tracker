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
include "globals.php";
include_once "tracker/set.php";
include_once "tracker/defaultUser.php";
$defaultUser = new DefaultUser();
$queueId=0;
if (isset($_POST['queue']))
{
	$queueId = $_POST['queue'];
}
$param = "userType='cc'";
$param = AddEscapedParam($param,"queueId",$queueId);
$ok = $defaultUser->Get($param);
$cc = new Set(",");
while ($ok)
{
	$cc->Add($defaultUser->userId);
	$ok = $defaultUser->Next();
}
echo $cc->data;
?>
