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
include "globals.php";
include_once "tracker/user.php";
include_once "tracker/userToGroup.php";
include_once "tracker/userToOrganization.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";

if (isset($_POST['submitTest']))
{
    $user = new User();
	if (!validateAJAXFormKey())
	{
        DebugPause("/improperAccess/");
	}
	DebugText("form submitted");
	$userId = GetTextField("userId",0);
	$user = new User($userId);
	$html = "";
	$numErrors = 0;
	$name = GetTextField("fullName");
	$password = GetTextField("password");
	$confirmPassword = GetTextField("confirmPassword");
	$email = GetTextField("email");
	$initials = GetTextField("initials");
	$accountId = GetTextField("accountId",0);
	$active = GetTextField("active",-1);
	$snsTopic = GetTextField("snsTopic");

	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a name</li>";
	}
	if (!$user->userId && (strlen($password) == 0))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a password</li>";
	}
	if (!$user->userId && ($password != $confirmPassword))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Passwords do not match</li>";
	}
	if (strlen($email) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a email</li>";
	}
	if ($active == -1)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a status</li>";
	}
	if ($numErrors == 0)
	{
		$user->fullName = $name;
		$user->password = $password;
		$user->email = $email;
		$user->active = $active;
		$user->snsTopic = $snsTopic;

		if ($user->userId)
		{
			$user->Update();
		}
		else
		{
			$user->Insert();
		}
		$userGroups="";
		if (isset($_POST['userGroups']))
		{
			@$userGroups=$_POST['userGroups'];
		}
		$userToGroup = new UserToGroup();
		$userToGroup->userId = $user->userId;
		$userToGroup->Reset();
		if ($userGroups)
		{
			while (list ($key, $group) = legacy_each ($userGroups))
			{
				$userToGroup->userGroupId=$group;
				$userToGroup->Insert();
			}
		}

		$userOrganizations="";
		if (isset($_POST['userOrganizations']))
		{
			@$userOrganizations=$_POST['userOrganizations'];
		}
		$userToOrganization = new UserToOrganization();
		$userToOrganization->userId = $user->userId;
		$userToOrganization->Reset();
		if ($userOrganizations)
		{
			while (list ($key, $organization) = legacy_each ($userOrganizations))
			{
				$userToOrganization->organizationId=$organization;
				$userToOrganization->Insert();
			}
		}

		DebugPause("/listUsers/");

	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['formErrors'] = $html;
		$_SESSION['name'] = $name;
		$_SESSION['password'] = $password;
		$_SESSION['confirmPassword'] = $confirmPassword;
		$_SESSION['email'] = $email;
		$_SESSION['active'] = $active;
		$_SESSION['userUserGroups'] = "";
		$_SESSION['userUserOrganizations'] = "";
		$_SESSION['userSNSTopic'] = $snsTopic;
        if (isset($_POST['userOrganizations']))
        {
            @$userGroups=$_POST['userOrganizations'];
            $_SESSION['userOrganizations'] = $_POST['userOrganizations'];
        }
        if (isset($_POST['userGroups']))
        {
            @$userGroups=$_POST['userGroups'];
            $_SESSION['userGroups'] = $_POST['userGroups'];
        }
		if ($user->userId)
		{
			DebugPause("/editUser/".$user->userId."/");
		}
		DebugPause("/newUser/");
	}
}
?>
