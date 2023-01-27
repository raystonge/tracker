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
include_once "tracker/assetType.php";
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

    $assetType = new AssetType();

	if (isset($_POST['assetTypeId']))
	{
		$assetTypeId=strip_tags($_POST['assetTypeId']);
		$assetType->GetById($assetTypeId);
	}
	$name = GetTextField("name");
	$monitor = GetTextField("monitor",0);
	$hasMacAddress =GetTextField("hasMacAddress",0);
	$requireMacAddress = GetTextField("requireMacAddress",0);
	$hasContract = GetTextField("contract",0);
	$organizationId = GetTextField("organization",0);
	$hasAccessory = GetTextField("hasAccessory",0);
	$isAccessory = GetTextField("isAccessory",0);
	$hasUserPassword = GetTextField("hasUserPassword",0);
	$hasUserCredentials = GetTextField("hasUserCredentials",0);
	$hasSpecs = GetTextField("hasSpecs",0);
	$enforceCost = GetTextField("enforceCost",0);
  $personalProperty = GetTextField("personalProperty",0);
  $depreciationSchedule = GetTextField("depreciationSchedule",0);
  $noSerialNumber = GetTextField("noSerialNumber",0);
	$hasConstantMonitorDown = 0;

	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please specify an organization<li>";
	}
	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "assetTypeId<>".$assetTypeId;
		$param = AddEscapedParam($param,"name",$name);
		$param = AddEscapedParam($param, "organizationId", $organizationId);
		$testAssetType = new AssetType();
		if ($testAssetType->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Asset Type already in use</li>";
		}
	}
  if ($personalProperty && !$depreciationSchedule)
  {
    $numErrors++;
    $errorMsg=$errorMsg."<li>A deprection schedule must be selected for personal property</li>";
  }


	if ($numErrors ==0)
	{
		$assetType->name = $name;
		/*
		if (strlen($monitor))
		{
			$assetType->monitor = 1;
			$assetType->monitorType = $monitor;
		}
		*/
		$assetType->monitor = $monitor;
		$assetType->hasMacAddress = $hasMacAddress;
		$assetType->requireMacAddress = $requireMacAddress;
		$assetType->hasContract = $hasContract;
		$assetType->organizationId = $organizationId;
		$assetType->hasAccessory = $hasAccessory;
		$assetType->isAccessory = $isAccessory;
		$assetType->hasUserPassword = $hasUserPassword;
		$assetType->hasConstantMonitorDown = $hasConstantMonitorDown;
		$assetType->hasUserCredentials = $hasUserCredentials;
		$assetType->hasSpecs = $hasSpecs;
		$assetType->enforceCost = $enforceCost;
    $assetType->personalProperty = $personalProperty;
    $assetType->depreciationSchedule = $depreciationSchedule;
    $assetType->noSerialNumber = $noSerialNumber;
    $assetType->Persist();
		$_SESSION['assetTypeOrganizationId'] = $organizationId;
		DebugPause("/listAssetType/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;
		$_SESSION['monitor'] = $monitor;
		$_SESSION['hasMacAddress'] = $hasMacAddress;
		$_SESSION['requireMacAddress'] = $requireMacAddress;
		$_SESSION['hasContract'] = $hasContract;
		$_SESSION['organizationId'] = $organizationId;
		$_SESSION['hasAccessory'] = $hasAccessory;
		$_SESSION['isAccessory'] = $isAccessory;
		$_SESSION['hasUserPassword'] = $hasUserPassword;
		$_SESSION['hasUserCredentials'] = $hasUserCredentials;
		$_SESSION['hasSpecs'] = $hasSpecs;
		$_SESSION['enforceCost'] = $enforceCost;
    $_SESSION['personalProperty'] = $personalProperty;
    $_SESSION['depreciationSchedule'] = $depreciationSchedule;
    $_SESSION['noSerialNumber'] = $noSerialNumber;
		$_SESSION['formErrors'] = $html;
		if ($assetType->assetTypeId)
		{
			DebugPause("/editAssetType/".$assetType->assetTypeId."/");
		}
		DebugPause("/newAssetType/");
	}
}
$_SESSION['assetTypeOrganizationId'] = $organizationId;
DebugPause("/listAssetType/");
?>
