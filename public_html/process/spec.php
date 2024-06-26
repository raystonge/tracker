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
include_once "tracker/spec.php";

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

    $spec = new Spec();

	if (isset($_POST['specId']))
	{
		$specId=strip_tags($_POST['specId']);
		$spec->GetById($specId);
	}
	$name = GetTextField("name");
	$dataType = GetTextField("dataType");




	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "specId<>".$specId;
		$param = AddEscapedParam($param,"name",$name);
		//$param = AddEscapedParam($param, "organizationId", $organizationId);
		$testSpec = new Spec();
		if ($testSpec->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Spec already in use</li>";
		}
	}


	if ($numErrors ==0)
	{
		$spec->name = $name;
		$spec->dataType = $dataType;


    $spec->Persist();

		DebugPause("/listSpecs/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;


		$_SESSION['formErrors'] = $html;
		if ($spec->specId)
		{
			DebugPause("/editAssetCondition/".$spec->specId."/");
		}
		DebugPause("/newSpecs/");
	}
}
//$_SESSION['assetConditionOrganizationId'] = $organizationId;
DebugPause("/listSpecs/");
?>
