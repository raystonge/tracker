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
include_once 'globals.php';
include_once 'tracker/asset.php';
include_once 'tracker/assetType.php';

$_SESSION['formErrors'] ="";
//ProperAccessValidate();
if (isset($_POST['submitTest']))
{
	$numErrors = 0;
	$errorMsg = "";
	$assetId = GetTextField("assetId",0);
	$asset = new Asset($assetId);
	$assetType = new AssetType($asset->assetTypeId);
	$asset->purchasePrice = GetTextField("purchasePrice","0.00");
	$asset->poNumberId = GetTextField("poNumberId",0);
	$asset->vendor = GetTextField("vendor");
	$asset->taxable = GetTextField("taxable",0);
	$asset->sold = GetTextField("sold",0);
	if ($asset->sold)
	{
		$asset->soldPrice = GetTextField("soldPrice","0.00");
		$asset->soldDate = GetTextField("soldDate","0000-00-00");
		$asset->soldTo = GetTextField("soldTo");
	}
	else
	{
		$asset->soldPrice = "0.00";
		$asset->soldDate = "0000-00-00";
		$asset->soldTo = "";
	}
	if (!strlen($asset->vendor))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Vendor must be specified</li>";
	}
	if ($assetType->enforceCost && ($asset->purchasePrice == "0.00") || ($asset->purchasePrice == 0))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Cost needs to be specified</li>";
	}
	if (!$numErrors)
	{
		$asset->Persist();
		$_SESSION['formSuccess'] = "Success";
	}
	else {
		$html = "<ul>".$errorMsg."</ul>";

		$_SESSION['formErrors'] = $html;
		$_SESSION['purchasePrice'] = $asset->purchasePrice;
		$_SESSION['poNumberId'] = $asset->poNumberId;
		$_SESSION['vendor'] = $asset->vendor;
		$_SESSION['taxable'] = $asset->taxable;
		$_SESSION['sold'] = $asset->sold;
		$_SESSION['soldPrice'] = $asset->soldPrice;
		$_SESSION['soldDate'] = $asset->soldDate;
		$_SESSION['soldTo'] = $asset->soldTo;

	}

	DebugPause("/assetValue/".$asset->assetId."/");
}
DebugPause("/listAssets/");
?>
