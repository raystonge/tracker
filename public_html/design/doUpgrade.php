<?php
//
//  Tracker - Version 1.7.0
//
//  -v 1.7.0
//    - added funcaionality to run sql scripts
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
include_once "tracker/permission.php";
include_once "tracker/control.php";
include_once "tracker/validStatus.php";
include_once "tracker/validCondition.php";
include_once "tracker/status.php";
include_once "tracker/queue.php";
include_once "tracker/mimeType.php";
include_once "tracker/assetCondition.php";
include_once "tracker/assetType.php";
include_once "tracker/module.php";
include_once "db/dbTools.php";

ProperAccessTest();

$tables = array();
$tables = getTables();
ProcessUpgradeTables();

$control = new Control();
$param = "sectionValue='SysConfigs' and keyValue='SysVersion'";
$control->Get($param);
$currentVersion = $control->valueInt;
$fileList = array();
$arrayIndex = 0;
$dir = $siteRootPath."/sysUpdates";
if ($dh = opendir($dir))
{
	while (($file = readdir($dh)) !== false)
	{

		if (!is_dir($file))
		{
			$file = str_replace(".txt","",$file);
			if ($file > $currentVersion &&  is_numeric($file))
			{
				$fileList[$arrayIndex++] = $file;
			}
		}
	}
	closedir($dh);
	if (sizeof($fileList))
	{
		echo "Doing Updates:<br>";
		sort($fileList);
		foreach ($fileList as &$file)
		{
			ProcessUpgrade($file);
		}
	}
	UpdatePermissions();
	UpdateControls();
	UpdateQueues();
	UpdateStatus();
	UpdateValidStatus();
	UpdateMimeType();
	UpdateAssetConditions();
	UpdateValidCondition();
	UpdateAssetTypes();
	//UpdateModules();
	$fileList = array();
	$arrayIndex = 0;
	$dir = $siteRootPath."/sysUpdates/sql";
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
	  {
			if (!is_dir($file))
		  {
				$file = str_replace(".sql","",$file);
			  if ($file > $currentVersion &&  is_numeric($file))
			  {
				  $fileList[$arrayIndex++] = $file;
			  }
		  }
		}
	}
	closedir($dh);

	foreach($fileList as &$file)
	{
		PostUpgrade($file);
	}


}
function UpdateAssetConditions()
{
	global $dir;
	echo "Updating Asset Conditions<br>";
	flush();
	$assetConditionFile = $dir."/tables/assetCondition.csv";
	$handle=fopen($assetConditionFile,"r");
	$cnt=0;
	$assetCondition = new AssetCondition();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","assetConditionId",$data[0]);
		if (!$assetCondition->Get($param))
		{
			$assetCondition->name = $data[1];
			$assetCondition->Insert();
			echo "Adding new Asset Condition:".$assetCondition->name."<br>";
			flush();
		}
		else
		{
			$assetCondition->name = $data[1];
			$assetCondition->Update();

		}
	}
	fclose($handle); 

}
function UpdateValidCondition()
{
	global $dir;
	echo "Updating ValidCondition<br>";
	flush();
	$statusFile = $dir."/tables/validCondition.csv";
	$handle=fopen($statusFile,"r");
	$cnt=0;
	$condition = new ValidCondition();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","validConditionId",$data[0]);
		if (!$condition->Get($param))
		{
			$condition->currentAssetConditionId = $data[1];
			$condition->assetConditionId = $data[2];
			$condition->Insert();
			echo "Adding new Valid Condition:"."<br>";
			flush();
		}
		else
		{
			$condition->currentAssetConditionId = $data[1];
			$condition->assetConditionId = $data[2];
			$condition->Update();
		}
	}
	fclose($handle);

}

function UpdateAssetTypes()
{
	global $dir;
	echo "Updating Asset Types<br>";
	flush();
	$assetTypeFile = $dir."/tables/assetType.csv";
	$handle=fopen($assetTypeFile,"r");
	$cnt=0;
	$assetType = new AssetType();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","assetTypeId",$data[0]);
		if (!$assetType->Get($param))
		{
			$assetType->name = $data[1];
			$assetType->monitor = $data[2];
			$assetType->hasMacAddress = $data[3];
			$assetType->Insert();
			echo "Adding new Asset Type:".$assetType->name."<br>";
			flush();
		}
		else
		{
			$assetType->name = $data[1];
			$assetType->monitor = $data[2];
			$assetType->hasMacAddress = $data[3];
			$assetType->Update();

		}
	}
	fclose($handle);

}
function UpdateInsurancePayment()
{
	global $dir;
	echo "Updating Insurance Payment<br>";
	flush();
	$insurancePaymentFile = $dir."/tables/insurancePayment.csv";
	$handle=fopen($insurancePaymentFile,"r");
	$cnt=0;
	$insurancePayment = new InsurancePayment();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","insurancePaymentId",$data[0]);
		if (!$insurancePayment->Get($param))
		{
			$insurancePayment->name = $data[1];
			$insurancePayment->Insert();
			echo "Adding new Insurance Payment:".$insurancePayment->name."<br>";
			flush();
		}
		else
		{
			$insurancePayment->name = $data[1];
			$insurancePayment->Update();

		}
	}
	fclose($handle);

}
function UpdateInsuranceRepair()
{
	global $dir;
	echo "Updating Insurance Repair<br>";
	flush();
	$insuranceRepairFile = $dir."/tables/insuranceRepair.csv";
	$handle=fopen($insuranceRepairFile,"r");
	$cnt=0;
	$insuranceRepair = new InsuranceRepair();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","insuranceRepairId",$data[0]);
		if (!$insuranceRepair->Get($param))
		{
			$insuranceRepair->name = $data[1];
			$insuranceRepair->Insert();
			echo "Adding new Insurance Repair:".$insuranceRepair->name."<br>";
			flush();
		}
		else
		{
			$insuranceRepair->name = $data[1];
			$insuranceRepair->Update();
		}
	}
	fclose($handle);

}
function UpdateInsuranceRepairComplete()
{
	global $dir;
	echo "Updating Insurance Repair Complete<br>";
	flush();
	$insuranceCompleteRepairFile = $dir."/tables/insuranceRepairComplete.csv";
	$handle=fopen($insuranceCompleteRepairFile,"r");
	$cnt=0;
	$insuranceRepairComplete = new InsuranceRepairComplete();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","insuranceRepairCompleteId",$data[0]);
		if (!$insuranceRepairComplete->Get($param))
		{
			$insuranceRepairComplete->name = $data[1];
			$insuranceRepairComplete->Insert();
			echo "Adding new Insurance Repair Complete:".$insuranceRepairComplete->name."<br>";
			flush();
		}
		else
		{
			$insuranceRepairComplete->name = $data[1];
			$insuranceRepairComplete->Update();

		}
	}
	fclose($handle);

}
function UpdateQueues()
{
	global $dir;
	echo "Updating Queues<br>";
	flush();
	$queueFile = $dir."/tables/queue.csv";
	$handle=fopen($queueFile,"r");
	$cnt=0;
	$queue = new Queue();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","queueId",$data[0]);
		if (!$queue->Get($param))
		{
			$queue->name = $data[1];
			$queue->Insert();
			echo "Adding new Queue:".$queue->name."<br>";
			flush();
		}
		else
		{
			$queue->name = $data[1];
			$queue->Update();
		}
	}
	fclose($handle);

}
function UpdateModules()
{
	global $dir;
	echo "Updating Modules<br>";
	flush();
	$queueFile = $dir."/tables/module.csv";
	$handle=fopen($queueFile,"r");
	$cnt=0;
	$module = new Module();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","moduleId",$data[0]);
		if (!$module->Get($param))
		{
			$module->name = $data[1];
			$module->query = $data[2];
			$module->userId = $data[3];
			$module->admin = $data[4];
			$module->Insert();
			echo "Adding new Module:".$module->name."<br>";
			flush();
		}
		else
		{
			$module->name = $data[1];
			$module->query = $data[2];
			$module->userId = $data[3];
			$module->admin = $data[4];
			$module->Update();
		}
	}
	fclose($handle);

}
function UpdateStatus()
{
	global $dir;
	echo "Updating Status<br>";
	flush();
	$statusFile = $dir."/tables/status.csv";
	$handle=fopen($statusFile,"r");
	$cnt=0;
	$status = new Status();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","statusId",$data[0]);
		if (!$status->Get($param))
		{
			$status->name = $data[1];
			//$status->sortOn = $data[2];
			$status->Insert();
			echo "Adding new Status:".$status->name."<br>";
			flush();
		}
		else
		{
			$status->name = $data[1];
			//$status->sortOn = $data[2];
			$status->Update();
		}
	}
	fclose($handle);
}
function UpdateValidStatus()
{
	global $dir;
	echo "Updating Status<br>";
	flush();
	$statusFile = $dir."/tables/validStatus.csv";
	$handle=fopen($statusFile,"r");
	$cnt=0;
	$status = new ValidStatus();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","validStatusId",$data[0]);
		if (!$status->Get($param))
		{
			$status->currentStatusId = $data[1];
			$status->statusId = $data[2];
			$status->Insert();
			echo "Adding new Valid Status:"."<br>";
			flush();
		}
		else
		{
			$status->currentStatusId = $data[1];
			$status->statusId = $data[2];
			$status->Update();
		}
	}
	fclose($handle);

}
function UpdateMimeType()
{
	global $dir;
	echo "Updating MimeType<br>";
	flush();
	$statusFile = $dir."/tables/mimeType.csv";
	$handle=fopen($statusFile,"r");
	$cnt=0;
	$mimeType = new MimeType();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","mimeTypeId",$data[0]);
		if (!$mimeType->Get($param))
		{
			$mimeType->name = $data[1];
			$mimeType->mimeType = $data[2];
			$mimeType->handler = $data[3];
			$mimeType->Insert();
			echo "Adding new MimeType:".$status->name."<br>";
			flush();
		}
		else
		{
			$mimeType->name = $data[1];
			$mimeType->mimeType = $data[2];
			$mimeType->handler = $data[3];
			$mimeType->Update();
		}
	}
	fclose($handle);
}
function UpdatePermissions()
{
	global $dir;
	echo "Updating Permissions<br>";
	flush();
	$permissionFile = $dir."/tables/permission.csv";
	$handle=fopen($permissionFile,"r");
	$cnt=0;
	$permission = new Permission();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","permissionId",$data[0]);
		if (!$permission->Get($param))
		{
			$permission->name = $data[1];
			$permission->developer = $data[2];
			$permission->Insert();
			echo "Adding new Permission:".$permission->name."<br>";
			flush();
		}
		else
		{
			$permission->name = $data[1];
			$permission->developer = $data[2];
			$permission->Update();
		}
	}
	fclose($handle);
}
function UpdateControls()
{
	global $dir;
	echo "Updating Controls<br>";
	flush();
	$controlFile = $dir."/tables/control.csv";
	$handle=fopen($controlFile,"r");
	$cnt=0;
	$control = new Control();
	while (($data = fgetcsv($handle,0,",")) !== FALSE)
	{
		$param = AddEscapedParam("","sectionValue",$data[0]);
		$param = AddEscapedParam($param,"keyValue",$data[1]);
		if (!$control->Get($param))
		{
			$control->section = $data[0];
			$control->key = $data[1];
			$control->valueInt = $data[2];
			$control->valueChar = $data[3];
			$control->dataType = $data[4];
			$control->description = $data[5];
			$control->developer = $data[6];
			if (strpos($control->section,"userId") === false)
			{
				$control->Insert();
				echo "Adding new Control:".$control->section.":".$control->key."<br>";
				flush();
			}
		}
	}
	fclose($handle);
}
function PostUpgrade($version)
{
	global $dir;
	global $username_cms;
	global $password_cms;
	global $database_cms;

	$sqlFile = $dir."/".$version.".sql";
	DebugText("SQL:".$sqlFile);
	if (file_exists($sqlFile))
	{
		  echo "Processing SQL ".$version."<br>";
	    $cmd = "mysql -u ".$username_cms;
	    if (strlen($password_cms))
	    {
	        $cmd = $cmd." -p".$password_cms;
	    }
	    $cmd = $cmd." ".$database_cms." < ".$sqlFile;
			DebugText($cmd);
	    system($cmd);
	}

}
function ProcessUpgrade($file)
{
	global $dir;
	global $link_cms;
	global $database_cms;

	mysqli_select_db($link_cms,$database_cms); // Reselect to make sure db is selected

	echo "Upgrading to version:".$file."<br>";
	$fileName = $dir."/".$file.".txt";
	//$f = fopen($fileName,"r");
	$fileContent = file_get_contents($fileName);
	//$lines  = split("/\012\015?/", $fileContent);
	$lines = explode(",",$fileContent);
	foreach ($lines as $query)
	{
		$query = trim($query);
		if (strlen($query))
		{
			$result = mysqli_query($link_cms,$query);
			DebugText($query);
			DebugText("Error:" . mysqli_error($link_cms));
		}
	}
	//fclose($f);
	$param = "sectionValue='SysConfigs' and keyValue='SysVersion'";
	$control = new Control();
	$control->Get($param);
	$control->section = "SysConfigs";
	$control->key = "SysVersion";
	$control->datatype = "integer";
	$control->valueInt = $file;
	$control->Persist();
}
function ProcessUpgradeTables()
{
	global $siteRootPath;
	$fileList = array();
	$arrayIndex = 0;

	DebugText("ProcessUpgradeTables");
	$dir = $siteRootPath."/sysUpdates/structure";
	if ($dh = opendir($dir))
	{
		while (($file = readdir($dh)) !== false)
		{
			DebugText($file);
			if (!is_dir($file))
			{
				$file = str_replace(".txt","",$file);
				$fileList[$arrayIndex++] = $file;
			}
		}
	}
	closedir($dh);
	if (sizeof($fileList))
	{
		echo "Updating Tables:<br>";
		sort($fileList);
		foreach ($fileList as &$table)
		{
			ProcessTable($table);
		}
	}
}
function ProcessTable($table)
{
	global $siteRootPath;
	DebugText("ProcessTable($table)");
	$fname = $siteRootPath."/sysUpdates/structure/".$table.".txt";
	if (!TableExists($table))
	{
		$fname = $siteRootPath."/sysUpdates/create/".$table.".txt";
		echo "Creating table:".$table."<br>";
		if ($fp = fopen($fname,"r"))
		{
			$query =  fread($fp, filesize($fname));
			fclose($fp);
			$pos = strpos("AUTO_INCREMENT",$query);
			if ($pos >= 0)
			{
				$end = strpos(" ",$query,$pos);
				$sub = substr($query,$pos,$end-$pos);
				$query = str_replace($sub,"",$query);
			}
			executeQuery($query);
		}
	}
	else
	{
		VerifyTable($table,$fname);
	}


}
function TableExists($table)
{
	global $tables;

	$found = 0;
	DebugText("numTables:".sizeof($tables));
	for ($i =0; $i < sizeof($tables) && !$found; $i++)
	{
		if ($table == $tables[$i])
		{
			$found = 1;
		}
	}
	return ($found);
}
function VerifyTable($table,$fname)
{
	 DebugText("VerifyTable($table,$fname)");
   $fields = getFieldsArray($table);
   $fp = fopen($fname,"r");
   while (($data = fgetcsv($fp,0,",")) !== FALSE)
   {
   	  if (!isset($fields[$data[0]]))
   	  {
   	  	addTableField($table,$data[0],$data[1]);
   	  }
   	  else
   	  {
				DebugText($data[0].":".$data[1].":".$fields[$data[0]]);
   	  	if (!($data[1] == $fields[$data[0]]))
   	  	{
   	  		modifyTableField($table,$data[0],$data[1]);
   	  	}
   	  }
   }
}
?>
