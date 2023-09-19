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
include_once "cmsdb.php";
include_once "tracker/user.php";
if (!isset($_POST['validator']))
{
	$redirect = "/";
	DebugPause($redirect);
}
if (isset($_POST['validator']))
{
	if (strlen($_POST['validator']))
	{
		$redirect = "/";
		DebugPause($redirect);
	}
}

if (!validateFormKey())
{
	DebugPause("/");
}
if (isset($_SESSION['requestURI']))
{
	$redirect = $_SESSION['requestURI'];
	if ($redirect == "favicon.ico")
	{
		$redirect = "/";
		$_SESSION['requestURI'] = "/";
	}
}
$username = "";
$password = "";
if (isset($_SESSION['UserName']) )
{
	$redirect = "/";
	DebugPause($redirect);
}
/*
if (!testFormKey())
{
	$redirect = "/";
	DebugPause($redirect);
}
*/
if (isset($_POST['formaction']))
{
  $username = strip_tags($_POST['email']);
  $password = strip_tags($_POST['password']);
  $user = new User();
  DebugText("logLoginAttempts:".$logLoginAttempts);
  if ($logLoginAttempts)
  {
  	$fname = $siteRootPath."/tmp/loginAttempts.csv";
  	DebugText("loginAttempts:".$fname);
  	if ($fp = fopen($fname,"a"))
  	{
  		DebugText("writting to log file");
  		$text = '"'.$now.'","'.$username.'","'.$password.'"';
  		$text = $text."\n";
  		fwrite($fp,$text);
  		fclose($fp);
  	}
  }

  DebugText("Attempting login");
  if ($user->Login($username,$password))
  {
     $_SESSION['userId'] = $user->userId;
	 $_SESSION['userName'] = $user->email;
	 $_SESSION['userPassword'] = $password;
	 $_SESSION['failedLogin']=0;
	 $myGroups ="";
	 @setcookie("myGroups",$myGroups,time()+300);

	 //$redirect = "index.php";
	 $redirect = "/";

	 DebugText("login success");
	 DebugPause($redirect);
  }
}
$_SESSION['failedLogin']=1;
DebugText("login failed");
DebugPause("/");
?>
