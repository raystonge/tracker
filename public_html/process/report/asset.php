<?php
/*
 * Created on Jan 30, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/module.php";
include_once "tracker/moduleQuery.php";
include_once "tracker/set.php";
$module = new Module(GetTextField("moduleId",0));
$moduleQuery = new ModuleQuery();
$moduleQuery->Reset($module->moduleId);
$module->name = GetTextField("moduleName");
$module->userId = $currentUser->userId;
$module->Persist();
foreach ($_POST as $key=>$value)
{
    echo "key:".$key."<br>";
	DebugText("key:".$key);
	DebugText("value:".$_POST[$key]);
	if (strpos($key,"Test"))
	{
		DebugText("test key:".$_POST[$key]);
		if (strlen($_POST[$key]))
		{
			$test = $_POST[$key];
			$testValue = str_replace("Test","",$key);
			$value = "";
			switch ($test)
			{
				case "numDays" : $field = $testValue."NumDays";
				                 $value = GetTextField($field,0);				                 
				                 break;
				default:
				          
				          DebugText("key:".$key." value:".$testValue);
				          $value = "";
				          $values = new Set(",");
				          if (is_array($_POST[$testValue]))
				          {
				          	@$testValues = $_POST[$testValue];
				          	while (list ($key, $val) = each ($testValues))
				          	{
				          		$values->Add($val);
				          	}
				          	$value = $values->data;
				          }
				          else
				          {
				          	$value = trim($_POST[$testValue]);
				          }
			}
			$moduleQuery = new ModuleQuery();
			$moduleQuery->moduleId = $module->moduleId;
			$moduleQuery->fieldToTest = $testValue;
			$moduleQuery->fieldTest = $test;
			
			$moduleQuery->testValue = $value;
			if (($value == 0) && ($moduleQuery->fieldTest != "numDays"))
			{
				$value = "";
			}
			if (strlen($value))
			{
				$moduleQuery->Insert();
			}
			DebugText($testValue." ".$test." ".$value);
		}
		
	}
}
$query = "";
$param = "moduleId=".$module->moduleId." and testValue <> ''";
$ok = $moduleQuery->Get($param);
while ($ok)
{
	switch($moduleQuery->fieldTest)
	{
		case "In" : $query = AddParam($query,$moduleQuery->fieldToTest." ".$moduleQuery->fieldTest." (".$moduleQuery->testValue.")");
		            break;
	    case "matches" : $query = AddEscapedLikeParamIfNotBlank($query,$moduleQuery->fieldToTest,$moduleQuery->testValue);
	                     break;
	    case "numDays" : if ($moduleQuery->testValue == 0)
	                     {
	                     	$query = AddParam($query,$moduleQuery->fieldToTest.">="."[today]");                     	
	                     }
	                     else
	                     {
	                     	$param = "[numDays_$moduleQuery->testValue]";
	                     	$query = AddParam($query,$moduleQuery->fieldToTest.">="."[today]");
	                     	$query = AddParam($query,$moduleQuery->fieldToTest."<=".$param);
	                     }
	                     break;

	    default        : $query = AddEscapedParamWithTest($query,$moduleQuery->fieldToTest,$moduleQuery->fieldTest,$moduleQuery->testValue);
	}
	$ok = $moduleQuery->Next();
}
$module->moduleType = "Asset";
$module->query = $query;
$module->Persist();
DebugPause("/viewReports/".$module->moduleId."/");
?>