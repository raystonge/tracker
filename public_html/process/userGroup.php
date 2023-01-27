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
include_once "tracker/userGroup.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";

if (isset($_POST['submitTest']))
{
	$validated = false;
	$status='fail';
	$html="";
	$name = "";
	$assignee = 0;
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;
	if (!validateAJAXFormKey())
	{
		DebugPause("/improperAccess/");
	}
    $userGroup = new UserGroup();
    $userGroupId = GetTextField("userGroupId",0);
    $userGroup->GetById($userGroupId);
    $organizationId = GetTextField("organizationId",0);
    $name = GetTextField("name");
	if (isset($_POST['assignee']))
	{
		$assignee= 1;
	}
	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify ".$orgOrDept."</li>";
	}
	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "userGroupId<>".$userGroupId;
		$param = AddEscapedParam($param,"name",$name);
		$param = AddEscapedParam($param,"organizationId",$organizationId);
		$testUserGroup = new UserGroup();
		if ($testUserGroup->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>User Group already in use</li>";
		}
	}

	if ($numErrors ==0)
	{
		$userGroup->name = $name;
		$userGroup->assignee = $assignee;
		$userGroup->organizationId = $organizationId;

		if ($userGroup->userGroupId)
		{
			$userGroup->Update();
		}
		else
		{
			$userGroup->Insert();
		}
		DebugPause("/listUserGroups/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;
		$_SESSION['assignee'] = $assignee;
		$_SESSION['formErrors'] = $html;
		if ($userGroup->userGroupId)
		{
			DebugPause("/editUserGroup/".$userGroup->userGroupId."/");
		}
		DebugPause("/newUserGroup/");
	}
	//echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$userGroup->userGroupId.'"}';
//DebugOutput();
}
DebugPause("/listUserGroups/");
?>
