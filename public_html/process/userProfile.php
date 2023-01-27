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
include "globals.php";
include_once "tracker/user.php";
include_once "tracker/userToGroup.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";
if (!validateAJAXFormKey())
{
    DebugPause("/improperAccess/");
}

if (isset($_POST['submitTest']))
{
    $user = new User();
	DebugText("form submitted");
	$userId = 0;
	$html = "";
	$numErrors = 0;

	$user = new User($currentUser->userId);
	$name = GetTextField("fullName");
	$password = GetTextField("password");
	$confirmPassword = GetTextField("confirmPassword");
	$email = GetTextField("email");
	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a name</li>";
	}
	if (strlen($password) || strlen($confirmPassword))
	{
		if (strlen($password) == 0)
		{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a password</li>";
	    }
	    if ($password != $confirmPassword)
	    {
		$numErrors++;
		$errorMsg=$errorMsg."<li>Passwords do not match</li>";
	    }
	}
	if (strlen($email) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify a email</li>";
	}
	else
	{
		if (!isValidEmail($email))
		{
			$numErrors++;
			$errorMsg = $errorMsg."<li>Please Specify a valid email</li>";
		}
	}
	if ($numErrors == 0)
	{
		$user->fullName = $name;
		if (strlen($password))
		{
			$user->password = $password;
		}
		$user->email = $email;
		$user->Persist();
		$param = AddEscapedParam("","sectionValue","userId".$user->userId);
		$param = AddParam($param,"keyValue='maxTicketsPerPage'");
		$control->Get($param);
		$maxTicketsPerPage = GetTextField("maxTicketsPerPage",25);
		$control->section="userId".$user->userId;
		$control->key="maxTicketsPerPage";
		$control->datatype = "integer";
		$control->valueInt = $maxTicketsPerPage;
		if ($control->controlId)
		{
			$control->Update();
		}
		else
		{
			$control->Insert();
		}
		$param = AddEscapedParam("","sectionValue","userId".$user->userId);
		$param = AddParam($param,"keyValue='maxAssetsPerPage'");
		$control->Get($param);
		$maxAssetsPerPage = GetTextField("maxAssetsPerPage",25);
		$control->section="userId".$user->userId;
		$control->key="maxAssetsPerPage";
		$control->datatype = "integer";
		$control->valueInt = $maxAssetsPerPage;
		if ($control->controlId)
		{
			$control->Update();
		}
		else
		{
			$control->Insert();
		}
		$param = AddEscapedParam("","sectionValue","userId".$user->userId);
		$param = AddParam($param,"keyValue='showMouseOvers'");
		$control->Get($param);
		$maxAssetsPerPage = GetTextField("showMouseOvers",0);
		$control->section="userId".$user->userId;
		$control->key="showMouseOvers";
		$control->datatype = "integer";
		$control->valueInt = $maxAssetsPerPage;
		if ($control->controlId)
		{
			$control->Update();
		}
		else
		{
			$control->Insert();
		}
		$param = AddEscapedParam("","sectionValue","userId".$user->userId);
		$param = AddParam($param,"keyValue='showISC'");
		$control->Get($param);
		$showISC = GetTextField("showISC",0);
		$control->section="userId".$user->userId;
		$control->key="showISC";
		$control->datatype = "integer";
		$control->valueInt = $showISC;
		if ($control->controlId)
		{
			$control->Update();
		}
		else
		{
			$control->Insert();
		}
		$param = AddEscapedParam("","sectionValue","userId".$user->userId);
		$param = AddParam($param,"keyValue='showGoogleRSS'");
		$control->Get($param);
		$showGoogleRSS = GetTextField("showGoogleRSS",0);
		$control->section="userId".$user->userId;
		$control->key="showGoogleRSS";
		$control->datatype = "integer";
		$control->valueInt = $showGoogleRSS;
		if ($control->controlId)
		{
			$control->Update();
		}
		else
		{
			$control->Insert();
		}

		DebugPause("/");

	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['formErrors'] = $html;
		$_SESSION['userProfileFullName'] = $name;
		$_SESSION['userProfileEmail'] = $email;
		DebugPause("/userProfile/");
	}
}
DebugPause("/");
?>
