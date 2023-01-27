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
include_once "tracker/control.php";
$controlId = 0;
$numErrors = 0;
$errorMsg = "";
if (isset($_POST['controlId']))
{
	$controlId = $_POST['controlId'];
}
$control = new Control();
$control->GetById($controlId);
$_SESSION['formErrors'] ="";
if (isset($_POST['submitTest']))
{
	if (!testajaxFormKey())
	{
		DebugPause("/improperAccess/");
	}

	$status='fail';
	$controlId = strip_tags($_POST['controlId']);
	$control = new Control();
	$control->GetById($controlId);
	$sectionName="";
	$keyName = "";
	$valueInt = 0;
	$valueChar = "";
	$developer = 0;
	$dataType = "";
	if(isset($_POST['sectionName']))
	{
		$sectionName = trim(strip_tags($_POST['sectionName']));
	}
	if(isset($_POST['datatype']))
	{
		$dataType = trim(strip_tags($_POST['datatype']));
	}
	if (strlen($sectionName) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specifiy a Section Name</li>";
	}
	if(isset($_POST['keyName']))
	{
		$keyName = trim(strip_tags($_POST['keyName']));
	}
	if (strlen($keyName) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specifiy a Key Name</li>";
	}
	if (isset($_POST['valueInt']))
	{
		$valueInt = trim(strip_tags($_POST['valueInt']));
	}
	if (isset($_POST['valueChar']))
	{
		$valueChar = trim(strip_tags($_POST['valueChar']));
	}
	if (isset($_POST['developer']))
	{
		$developer = 1;
	}
	if ($numErrors==0)
	{
		$control->section=$sectionName;
		$control->key = $keyName;
		$control->valueInt = $valueInt;
		$control->valueChar = $valueChar;
		$control->developer = $developer;
		$control->datatype  = $dataType;

		if ($control->controlId)
		{
			$control->Update();
		}
		else
		{
			$control->Insert();
		}

		DebugPause("/listControls/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['formErrors'] = $html;
		DebugPause("/editControls/".$control->controlId."/");
	}
	DebugPause("/listControls/");
}
?>
