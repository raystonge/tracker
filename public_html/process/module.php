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
include_once "tracker/module.php";
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
	/*
	if (!validateFormKey())
	{
		DebugPause("/improperAccess/");
	}*/

    $module = new Module();

	if (isset($_POST['moduleId']))
	{
		$moduleId=strip_tags($_POST['moduleId']);
		$module->GetById($moduleId);
	}
	$name = GetTextField("name");
	$description = GetTextField("description");
	$moduleQuery = GetTextField("moduleQuery");
	$moduleType = GetTextField("moduleType");
	$adminOnly = GetTextField("adminOnly",0);

	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
    else
	{
		$param = "moduleId<>".$moduleId;
		$param = AddEscapedParam($param,"name",$name);
		$testModule = new Module();
		if ($testModule->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>".$orgOrDept." already in use</li>";

		}
	}
	if (strlen($description) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Description</li>";
	}
	if (strlen($moduleQuery) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Query</li>";
	}


	if ($numErrors ==0)
	{
		$module->name = $name;
		$module->description = $description;
		$module->query = $moduleQuery;
		$module->moduleType = $moduleType;
		$module->admin = $adminOnly;

		if ($module->moduleId)
		{
			$module->Update();
		}
		else
		{
			$module->Insert();

		}
		DebugPause("/listModules/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['moduleName']=$name;
		$_SESSION['moduleModuleId'] = $moduleId;
		$_SESSION['moduleDescription'] = $description;
		$_SESSION['moduleQuery'] = $moduleQuery;
		$_SESSION['moduleType'] = $moduleType;
		$_SESSION['moduleAdminOnly'] = $adminOnly;
		$_SESSION['formErrors'] = $html;
		if ($module->moduleId)
		{
			DebugPause("/editModule/".$module->moduleId."/");
		}
		DebugPause("/newModule/");
	}
	//echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$module->moduleId.'"}';
//DebugOutput();
}
DebugPause("/listModules/");
?>
