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
include_once "tracker/asset.php";
include_once "tracker/assetToContract.php";
ProperAccessValidate();
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
