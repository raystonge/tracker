<?php
//
//  Tracker - Version 1.11.0
//
//  v1.11.0
//   - added orderBy field
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
include_once "tracker/module.php";
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
	/*
	if (!validateFormKey())
	{
		DebugPause("/improperAccess/");
	}*/

    $module = new Module();

	if (isset($_POST['moduleId']))
	{
		$moduleId=strip_tags($_POST['moduleId']);
		$module->GetById($moduleId);
	}
	$name = GetTextField("name");
	$description = GetTextField("description");
	$moduleQuery = GetTextField("moduleQuery");
	$moduleType = GetTextField("moduleType");
	$adminOnly = GetTextField("adminOnly",0);
  $orderByResults = GetTextField("moduleOrderBy");

	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
    else
	{
		$param = "moduleId<>".$moduleId;
		$param = AddEscapedParam($param,"name",$name);
		$testModule = new Module();
		if ($testModule->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>".$orgOrDept." already in use</li>";

		}
	}
	if (strlen($description) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Description</li>";
	}
	if (strlen($moduleQuery) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Query</li>";
	}
  if (strlen($orderByResults) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Order By</li>";
	}

	if ($numErrors ==0)
	{
		$module->name = $name;
		$module->description = $description;
		$module->query = $moduleQuery;
		$module->moduleType = $moduleType;
		$module->admin = $adminOnly;
    $module->orderByResults = $orderByResults;

		if ($module->moduleId)
		{
			$module->Update();
		}
		else
		{
			$module->Insert();

		}
		DebugPause("/listModules/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['moduleName']=$name;
		$_SESSION['moduleModuleId'] = $moduleId;
		$_SESSION['moduleDescription'] = $description;
		$_SESSION['moduleQuery'] = $moduleQuery;
		$_SESSION['moduleType'] = $moduleType;
		$_SESSION['moduleAdminOnly'] = $adminOnly;
    $_SESSION['moduleOrderBy'] = $orderByResults;
		$_SESSION['formErrors'] = $html;
		if ($module->moduleId)
		{
			DebugPause("/editModule/".$module->moduleId."/");
		}
		DebugPause("/newModule/");
	}
	//echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$module->moduleId.'"}';
//DebugOutput();
}
DebugPause("/listModules/");
?>
