<?php
/*
 * Created on Mar 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
			while (list ($key, $group) = each ($userGroups))
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
			while (list ($key, $organization) = each ($userOrganizations))
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
