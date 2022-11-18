<?php
/*
 * Created on Mar 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/organization.php";
include_once "tracker/permission.php";
include_once "tracker/userToOrganization.php";
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
