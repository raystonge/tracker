<?php
//
//  Tracker - Version 1.13.0
//
// v1.13.0
//  - added support for limit sharing across orgs
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
include_once "tracker/organization.php";
include_once "tracker/permission.php";
include_once "tracker/userToOrganization.php";
include_once "tracker/shareWithOrganization.php";
$_SESSION['formErrors'] ="";

if (isset($_POST['submitTest']))
{
	$validated = false;
	$status='fail';
	$html="";
	$name = "";
	$assignee = 0;
	$billable = 0;
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;
	if (!validateFormKey())
	{
		DebugPause("/improperAccess/");
	}
    $organization = new Organization();

	if (isset($_POST['organizationId']))
	{
		$organizationId=strip_tags($_POST['organizationId']);
		$organization->GetById($organizationId);
	}
	$name = GetTextField("name");
	$assetPrefix = GetTextField("assetPrefix");

	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
    else
	{
		$param = "organizationId<>".$organizationId;
		$param = AddEscapedParam($param,"name",$name);
		$testOrganization = new Organization();
		if ($testOrganization->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>".$orgOrDept." already in use</li>";

		}
	}
	if (strlen($assetPrefix) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Asset Prefix</li>";
	}
	$billable = GetTextField("billable",0);
	$defaultAssigneeId = GetTextField("defaultAssgineeId",0);
	$showAllUsers = GetTextField("showAllUsers",0);
	$active = GetTextField("active",0);
	DebugText("showAllUsers:".$showAllUsers);


	if ($numErrors ==0)
	{
		$organization->name = $name;
		$organization->assetPrefix = $assetPrefix;
		$organization->billable = $billable;
		$organization->showAllUsers = $showAllUsers;
		$organization->defaultAssigneeId = $defaultAssigneeId;
		$organization->active = $active;

		if ($organization->organizationId)
		{
			$organization->Update();
		}
		else
		{
			$organization->Insert();
			$userToOrganization = new UserToOrganization();
			$userToOrganization->userId = $currentUser->userId;
			$userToOrganization->organizationId = $organization->organizationId;
			$userToOrganization->Insert();
		}
		$shareWith = "";
		if (isset($_POST['shareWith']))
		{
			@$shareWith=$_POST['shareWith'];
		}
		$shareWithOrganization = new ShareWithOrganization();
		$shareWithOrganization->organizationId = $organization->organizationId;
		$shareWithOrganization->Reset();
		if ($shareWith)
		{
          foreach ($shareWith as $org)
			{
				$shareWithOrganization->shareWithId = $org;
				$shareWithOrganization->Insert();
			}
		}
		DebugPause("/listOrganizations/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['organizationName']=$name;
		$_SESSION['organizationOrganizationId'] = $organizationId;
		$_SESSION['organizationAssetPrefix'] = $assetPrefix;
		$_SESSION['organizationBillable'] = $billable;
		$_SESSION['organizationShowAllUsers'] = $showAllUsers;
		$_SESSION['formErrors'] = $html;
		if ($organization->organizationId)
		{
			DebugPause("/editOrganization/".$organization->organizationId."/");
		}
		DebugPause("/newOrganization/");
	}
	//echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$organization->organizationId.'"}';
//DebugOutput();
}
DebugPause("/listOrganizations/");
?>
