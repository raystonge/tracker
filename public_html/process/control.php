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