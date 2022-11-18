<?php
include_once "globals.php";
include_once 'tracker/asset.php';
include_once 'tracker/assetType.php';
include_once "tracker/assetTypeDepreciationSchedule.php";

$_SESSION['formErrors'] ="";
//ProperAccessValidate();
$errorMsg = "";
$numErrors = 0;
$assetTypeId = GetTextField("assetTypeId",0);
$assetType = new AssetType($assetTypeId);
if (!$assetType->assetTypeId)
{
  DebugPause("/");
}
$numYears = $assetType->depreciationSchedule;
$param = AddEscapedParam("","assetTypeId",$assetType->assetTypeId);
$assetTypeDepreciationSchedule = new AssetTypeDepreciationSchedule();
$assetTypeDepreciationSchedule->Get($param);

for ($i = 1; $i<=10;$i++)
{
  $fieldName="year".$i;
  DebugText($fieldName.":".$assetTypeDepreciationSchedule->$fieldName);
}
for ($i = 1; $i <= $numYears; $i++)
{
  $fieldName="year".$i;
  $val = GetTextField($fieldName,0);
  if ($val == 0)
  {
    $numErrors++;
    $errorMsg = $errorMsg."<li>Year ".$i." needs a value</li>";
  }
}

if ($numErrors)
{
  $html = "<ul>".$errorMsg."</ul>";

  $_SESSION['formErrors'] = $html;
  for ($i = 1; $i <= $numErrors; $i++)
  {
    $fieldName = "year".$i;
    $val = GetTextField($fieldName,0);
    $_SESSION[$fieldName] = $val;
  }
  DebugPause("/editDeprectionSchedule/".$assetTypeId."/");
}
for ($i = 1; $i <= $numYears; $i++)
{
  $fieldName = "year".$i;
  $val = GetTextField($fieldName,0);
  $assetTypeDepreciationSchedule->$fieldName = $val;
}
$assetTypeDepreciationSchedule->assetTypeId = $assetTypeId;
$assetTypeDepreciationSchedule->Persist();
DebugPause("/editAssetType/".$assetTypeId."/");
 ?>
