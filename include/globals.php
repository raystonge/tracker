<?php
//
//  AdSys - Version 1.0
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
//include_once "session.php";
session_start();
date_default_timezone_set('America/New_York');
include_once "tracker/support.php";
include_once "tracker/user.php";
include_once "tracker/history.php";
include_once "tracker/control.php";
include_once "tracker/security.php";
include_once "tracker/permission.php";
include_once "db/fieldValidators.php";
include_once "debug.php";
include_once "cmsdb.php";
$permission = new Permission();
$yesterday = date("Y-m-d", time() - 60 * 60 * 24);
$oneYear = date("Y-m-d", time() + 365*(60 * 60 * 24));
$today = date("Y-m-d");
$todayInt = date("Ymd");
$now = date("Y-m-d H:i:s");
$nowInt = date("YmdHis");
$control = new Control();
$param = "sectionValue='Globals'";
$control->SetOrderBy("sectionValue");
$ok = $control->Get($param);
while ($ok)
{
	$varName=$control->key;
	$$varName = "";
	if ($control->datatype == "text")
	{
		$$varName = $control->valueChar;
	}
	else
	{
		$$varName = $control->valueInt;
	}

	DebugText($varName.":".$$varName);
	$ok = $control->Next();
}
$param = "sectionValue='Paths'";
$control->SetOrderBy("sectionValue");
$ok = $control->Get($param);
while ($ok)
{
	$varName=$control->key;
	$$varName = "";
	if ($control->datatype == "text")
	{
		$$varName = $control->valueChar;
	}
	else
	{
		$$varName = $control->valueInt;
	}

	DebugText($varName.":".$$varName);
	$ok = $control->Next();
}
$param = "sectionValue='File Uploads'";
$control->SetOrderBy("sectionValue");
$ok = $control->Get($param);
while ($ok)
{
	$varName=$control->key;
	$$varName = "";
	if ($control->datatype == "text")
	{
		$$varName = $control->valueChar;
	}
	else
	{
		$$varName = $control->valueInt;
	}

	DebugText($varName.":".$$varName);
	$ok = $control->Next();
}

$param = "sectionValue='Configs'";
$control->SetOrderBy("sectionValue");
$ok = $control->Get($param);
while ($ok)
{
	$varName=$control->key;
	$$varName = "";
	if ($control->datatype == "text")
	{
		$$varName = $control->valueChar;
	}
	else
	{
		$$varName = $control->valueInt;
	}

	DebugText($varName.":".$$varName);
	$ok = $control->Next();
}
$param = "sectionValue='SysConfigs'";
$control->SetOrderBy("sectionValue");
$ok = $control->Get($param);
while ($ok)
{
	$varName=$control->key;
	$$varName = "";
	if ($control->datatype == "text")
	{
		$$varName = $control->valueChar;
	}
	else
	{
		$$varName = $control->valueInt;
	}

	DebugText($varName.":".$$varName);
	$ok = $control->Next();
}

$currentUser = new User();
if (isset($_SESSION['userId']))
{
	$currentUser->GetById($_SESSION['userId']);
}
$showMouseOvers=1;
$orderWizard = 0;
$param = "sectionValue='userId$currentUser->userId'";
$control->SetOrderBy("sectionValue");
$ok = $control->Get($param);
while ($ok)
{
	$varName=$control->key;
	$$varName = "";
	if ($control->datatype == "text")
	{
		$$varName = $control->valueChar;
	}
	else
	{
		$$varName = $control->valueInt;
	}

	DebugText($varName.":".$$varName);
	$ok = $control->Next();
}

$hostPath = "";
if (isset($_SERVER['HTTP_HOST']))
{
  $hostPath = "http://".$_SERVER['HTTP_HOST'];
}

$ipAddress = "";
if (isset($_SERVER['REMOTE_ADDR']))
{
  $ipAddress = $_SERVER['REMOTE_ADDR'];
}
$jsVersion = $todayInt;
if ($debug)
{
	$jsVersion = $nowInt;
}
$editFieldClass = "ui-corner-left ui-corner-right";
$param = "";
$closedId = 4;
$historyArray = array();

function OneYear()
{
   return date("Y-m-d", time() + 365*(60 * 60 * 24));
}

function Now()
{
	return date("Y-m-d H:i:s");	
}
function NowInt()
{
	return date("YmdHis");
}
function Today()
{
	return date("Y-m-d");
}
function TodayInt()
{
	return date("Ymd");
}
function Yesterday()
{
	return date("Y-m-d", time() - 60 * 60 * 24);
}
?>
