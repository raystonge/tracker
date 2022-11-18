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