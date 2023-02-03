<?php
//
//  Tracker - Version 1.5.0
//
//  v1.5.0
//   - relaced each() with legacy_each()

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
include_once "tracker/moduleQuery.php";
include_once "tracker/set.php";
$module = new Module(GetTextField("moduleId",0));
$moduleQuery = new ModuleQuery();
$moduleQuery->Reset($module->moduleId);
$module->name = GetTextField("moduleName");
$module->userId = $currentUser->userId;
$module->Persist();
foreach ($_POST as $key=>$value)
{
	DebugText("key:".$key);
	DebugText("value:".$_POST[$key]);
	if (strpos($key,"Test"))
	{
		DebugText("test key:".$_POST[$key]);
		if (strlen($_POST[$key]))
		{
			$test = $_POST[$key];
			$testValue = str_replace("Test","",$key);
			DebugText("key:".$key." value:".$testValue);
			$value = "";
			$values = new Set(",");
			if (is_array($_POST[$testValue]))
			{
			  @$testValues = $_POST[$testValue];
			  while (list ($key, $val) = legacy_each ($testValues))
			  {
			  	$values->Add($val);
			  }
			  $value = $values->data;
			}
			else
			{
				$value = trim($_POST[$testValue]);
			}
			$moduleQuery = new ModuleQuery();
			$moduleQuery->moduleId = $module->moduleId;
			$moduleQuery->fieldToTest = $testValue;
			$moduleQuery->fieldTest = $test;

			$moduleQuery->testValue = $value;
			if ($value == 0)
			{
				$value = "";
			}
			if (strlen($value))
			{
				$moduleQuery->Insert();
			}
			DebugText($testValue." ".$test." ".$value);
		}

	}
}
$query = "";
$param = "moduleId=".$module->moduleId." and testValue <> ''";
$ok = $moduleQuery->Get($param);
while ($ok)
{
	switch($moduleQuery->fieldTest)
	{
		case "In" : $query = AddParam($query,$moduleQuery->fieldToTest." ".$moduleQuery->fieldTest." (".$moduleQuery->testValue.")");
		            break;
	    case "matches" : $query = AddEscapedLikeParamIfNotBlank($query,$moduleQuery->fieldToTest,$moduleQuery->testValue);
	                     break;
	    default        : $query = AddEscapedParamWithTest($query,$moduleQuery->fieldToTest,$moduleQuery->fieldTest,$moduleQuery->testValue);
	}
	$ok = $moduleQuery->Next();
}
$module->moduleType = "Ticket";
$module->query = $query;
$module->Persist();
DebugPause("/viewReports/".$module->moduleId."/");
?>
