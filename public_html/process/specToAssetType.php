<?php
include_once "globals.php";
include_once "tracker/assetType.php";
include_once "tracker/spec.php";
include_once "tracker/specToAssetType.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
$assetTypeId = GetTextField("assetTypeId",0);
if (!$assetTypeId)
{
  DebugText("assetTypeId is not set");
  DebugPause("/listAssetType/");
}
$spec = new Spec();
$ok = $spec->Get("");
while ($ok)
{
  $specToAssetType = new SpecToAssetType();
  $field = "spec".$spec->specId;
  $param = AddEscapedParam("","specId",$spec->specId);
  $param = AddEscapedParam($param,"assetTypeId",$assetTypeId);
  $specToAssetType->Get($param);
  if (isset($_POST[$field]))
  {
    DebugText($field." is set");
    if (!$specToAssetType->specToAssetTypeId)
    {
      $specToAssetType->assetTypeId = $assetTypeId;
      $specToAssetType->specId = $spec->specId;
      $specToAssetType->Insert();
    }
  }
  else
  {
    DebugText($field." is not set");
    if ($specToAssetType->specToAssetTypeId)
    {
      $specToAssetType->Delete($param);
    }
  }
  $ok = $spec->Next();

}
DebugPause("/listAssetType/");
