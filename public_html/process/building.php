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
include_once "tracker/building.php";
include_once "tracker/defaultUser.php";
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
    $building = new Building();

	if (isset($_POST['buildingId']))
	{
		$buildingId=strip_tags($_POST['buildingId']);
		$building->GetById($buildingId);
	}
	$name = GetTextField("name");
	$queueId = GetTextField("queueId",0);
	$domain = GetTextField("network");
	$organizationId = GetTextField("organizationId",0);
	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";

	}
    else
	{
		$param = "buildingId<>".$buildingId;
		$param = AddEscapedParam($param,"name",$name);
		$param = AddEscapedParam($param,"organizationId",$organizationId);
		$testBuilding = new Building();
		if ($testBuilding->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Building already in use</li>";

		}
	}
  /*
	if (strlen($domain) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Network Name</li>";

	}
    else
	{
		$param = "buildingId<>".$buildingId;
		$param = AddEscapedParam($param,"domain",$domain);
		$testBuilding = new Building();
		if ($testBuilding->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Network name already in use</li>";

		}
	}*/

	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg = $errorMsg."<li>Please Specify a default ".$orgOrDept."</li>";
	}
/*
	if (!$queueId)
	{
		$numErrors++;
		$errorMsg = $errorMsg."<li>Please Specify a default Queue</li>";
	}
*/

	if ($numErrors ==0)
	{
		$building->name = $name;
		$building->queueId = $queueId;
		$building->domain = $domain;
		$building->organizationId = $organizationId;

		if ($building->buildingId)
		{
			$building->Update();
		}
		else
		{
			$building->Insert();
		}
		DebugPause("/listBuildings/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['buildingName']=$name;
		$_SESSION['buildingBuildingId'] = $queueId;
		$_SESSION['buildingDomain'] = $domain;
		$_SESSION['buildingOrganizationId'] = $organizationId;
		$_SESSION['formErrors'] = $html;
		if ($building->buildingId)
		{
			DebugPause("/editBuilding/".$building->buildingId."/");
		}
		DebugPause("/newBuilding/");
	}
	//echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$building->buildingId.'"}';
//DebugOutput();
}
DebugPause("/listBuildings/");
?>
