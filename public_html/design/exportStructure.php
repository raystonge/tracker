<h2>Export Data Structures</h2>
<br>
<strong>Outputting Data Structures</strong><br>
<?php
include_once "db/dbTools.php";
include_once "tracker/permission.php";
include_once "tracker/control.php";
include_once "tracker/assetCondition.php";
include_once "tracker/assetType.php";
include_once "tracker/insurancePayment.php";
include_once "tracker/insuranceRepair.php";
include_once "tracker/insuranceRepairComplete.php";
include_once "tracker/queue.php";
include_once "tracker/status.php";
include_once "tracker/mimeType.php";
include_once "tracker/validStatus.php";
include_once "tracker/validCondition.php";
include_once "tracker/module.php";
$tables = getTables();
foreach($tables as $table)
{
	echo "Processing: ".$table."<br>";
	$fname  = $siteRootPath."/sysUpdates/structure/".$table.".txt";
	$fp = fopen($fname,"w");
	$fields = getFields($table);
	foreach ($fields as $field)
	{
		$fieldString = '"'.$field['Field'].'","'.$field['Type'].'"';
		$fieldString = $fieldString."\n";
		fwrite($fp,$fieldString);
	}
	fclose($fp);
	$fname = $siteRootPath."/sysUpdates/create/".$table.".txt";
	$query = "show create table ".$table;
	$rows = doQuery($query);
	if (sizeof($rows))
	{
	$fp = fopen($fname,"w");
	fwrite($fp,$rows[0]['Create Table']);
	fclose($fp);
	}
}
?>
<strong>Outputting Table Data</strong><br>
Processing Permission<br>
<?php
$permission = new Permission();
$ok = $permission->Get();
$fname = $siteRootPath."/sysUpdates/tables/permission.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $permission->permissionId.',"'.$permission->name.'","'.$permission->developer.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $permission->Next();
}
fclose($fp);
?>
Processing Asset Condition<br>
<?php
$assetCondition = new AssetCondition();
$ok = $assetCondition->Get();
$fname = $siteRootPath."/sysUpdates/tables/assetCondition.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $assetCondition->assetConditionId.',"'.$assetCondition->name.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $assetCondition->Next();
}
fclose($fp);
?>
Processing Asset Type<br>
<?php
$assetType = new AssetType();
$ok = $assetType->Get();
$fname = $siteRootPath."/sysUpdates/tables/assetType.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $assetType->assetTypeId.',"'.$assetType->name.'",'.$assetType->monitor.','.$assetType->hasMacAddress;
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $assetType->Next();
}
fclose($fp);
?>
Processing Insurance Payment<br>
<?php
$insurancePayment = new InsurancePayment();
$ok = $insurancePayment->Get();
$fname = $siteRootPath."/sysUpdates/tables/insurancePayment.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $insurancePayment->insurancePaymentId.',"'.$insurancePayment->name.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $insurancePayment->Next();
}
fclose($fp);
?>
Processing Insurance Repair<br>
<?php
$insuranceRepair = new InsuranceRepair();
$ok = $insuranceRepair->Get();
$fname = $siteRootPath."/sysUpdates/tables/insuranceRepair.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $insuranceRepair->insuranceRepairId.',"'.$insuranceRepair->name.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $insuranceRepair->Next();
}
fclose($fp);
?>
Processing Insurance Repair Complete<br>
<?php
$insuranceRepairComplete = new InsuranceRepairComplete();
$ok = $insuranceRepairComplete->Get();
$fname = $siteRootPath."/sysUpdates/tables/insuranceRepairComplete.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $insuranceRepairComplete->insuranceRepairCompleteId.',"'.$insuranceRepairComplete->name.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $insuranceRepairComplete->Next();
}
fclose($fp);
?>
Processing Queues<br>
<?php
$queue = new Queue();
$ok = $queue->Get();
$fname = $siteRootPath."/sysUpdates/tables/queue.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $queue->queueId.',"'.$queue->name.'"';
	//$fieldString = $fieldString.',"'.$queue->name.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $queue->Next();
}
fclose($fp);
?>
Processing Status<br>
<?php
$status = new Status();
$ok = $status->Get();
$fname = $siteRootPath."/sysUpdates/tables/status.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $status->statusId.',"'.$status->name.'","'.$status->sortOn.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $status->Next();
}
fclose($fp);
?>
Processing Module<br>
<?php
$module = new Module();
$ok = $module->Get();
$fname = $siteRootPath."/sysUpdates/tables/module.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $module->moduleId.',"'.$module->name.'","'.$module->query.'","'.$module->userId.'","'.$module->admin.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $module->Next();
}
fclose($fp);
?>

Processing MimeType<br>
<?php
$mimeType = new MimeType();
$ok = $mimeType->Get();
$fname = $siteRootPath."/sysUpdates/tables/mimeType.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $mimeType->mimeTypeId.',"'.$mimeType->name.'","'.$mimeType->mimeType.'","'.$mimeType->handler.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $status->Next();
}
fclose($fp);
?>
Processing ValidStatus<br>
<?php
$validStatus = new ValidStatus();
$ok = $validStatus ->Get();
$fname = $siteRootPath."/sysUpdates/tables/validStatus.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $validStatus->validStatusId.',"'.$validStatus->currentStatusId.'","'.$validStatus->statusId.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $validStatus->Next();
}
fclose($fp);
?>
Processing ValidCondition<br>
<?php
$validCondition = new ValidCondition();
$ok = $validCondition->Get();
$fname = $siteRootPath."/sysUpdates/tables/validCondition.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = $validCondition->validConditionId.',"'.$validCondition->currentAssetConditionId.'","'.$validCondition->assetConditionId.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $validCondition->Next();
}
fclose($fp);
?>
Processing Control<br>
<?php
$control = new Control();
$ok = $control->Get();
$fname = $siteRootPath."/sysUpdates/tables/control.csv";
$fp = fopen($fname,"w");
while ($ok)
{
	$fieldString = '"'.$control->section.'","'.$control->key.'","'.$control->valueInt.'","'.$control->valueChar.'","'.$control->datatype.'","'.$control->description.'","'.$control->developer.'"';
	$fieldString = $fieldString."\n";
	fwrite($fp,$fieldString);
	$ok = $control->Next();
}
fclose($fp);
?>
<?php
	$param = "sectionValue='SysConfigs' and keyValue='SysVersion'";
	$control = new Control();
	$control->Get($param);
	$control->section = "SysConfigs";
	$control->key = "SysVersion";
	$control->datatype = "integer";
	$control->valueInt++;
	$dir = $siteRootPath."/sysUpdates";

	$fileName = $dir."/".$control->valueInt.".txt";
	if ($fp = fopen($fileName,"w"));
	{
		fwrite($fp," ");
		fclose($fp);
		$control->Persist();
	}


DebugOutput();
?>
