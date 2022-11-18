<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/assetToContract.php";

$assetId = GetTextField('assetId',0);
$asset = new Asset($assetId);
if (!$asset->assetId)
{
	exit;
}
$numErrors = 0;
$errMsg = "";
$contractId = GetTextField("contractId",0);
$leased = GetTextField("leased",0);
if ($leased && !$contractId)
{
  $numErrors++;
  $errMsg=$errMsg."<li>A contract must be selected if leased</li>";
}
DebugText("contractId".$contractId);

if ($numErrors)
{
  $_SESSION['contractId'] = $contractId;
  $_SESSION['leased'] = $leased;
  $html = "<ul>".$errMsg."</ul>";
  $_SESSION['formErrors'] = $html;
  DebugPause("/assetContract/$assetId/");
}
$assetToContact = new assetToContract();
$param = AddEscapedParam("","assetId",$assetId);
$assetToContact->Get($param);
$assetToContact->contractId = $contractId;
$assetToContact->assetId = $assetId;
$assetToContact->Persist();
$asset = new Asset($assetId);
$asset->leased = $leased;
$asset->Persist();
$_SESSION['formSuccess'] = "Success";
DebugPause("/assetContract/$assetId/");
?>
