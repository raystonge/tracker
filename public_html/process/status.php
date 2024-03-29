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
include_once "tracker/status.php";
include_once "tracker/defaultUser.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
if (isset($_POST['submitTest']))
{
	$validated = false;
	$status='fail';
	$html="";

	$assignee = 0;
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;

    $status = new Status();

	if (isset($_POST['statusId']))
	{
		$statusId=strip_tags($_POST['statusId']);
		$param = AddEscapedParam("","statusId",$statusId);
		$status->Get($param);
	}
	$name = GetTextField("name");



	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "statusId<>".$statusId;
		$param = AddEscapedParam($param,"name",$name);

		$testStatus = new Status();
		if ($testStatus->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Status already in use</li>";
		}
	}


	if ($numErrors ==0)
	{
		$status->name = $name;
    $status->Persist();

		DebugPause("/listStatus/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;

		$_SESSION['formErrors'] = $html;
		if ($status->statusId)
		{
			DebugPause("/editStatus/".$status->statusId."/");
		}
		DebugPause("/newStatus/");
	}
}
DebugPause("/listStatus/");
?>
